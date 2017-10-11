<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Models\MstTopSubject;
use App\Models\MstDeviationValueRank;
use App\Models\TblTrialTestName;
use App\Models\LogSchoolContentsHistoryStudent;
use App\Models\TblSchoolContentsBlock;
use Exception;
use Google\Cloud\Language\LanguageClient;
use FFMpeg;

# Includes the autoloader for libraries installed with composer
use Vendor\autoload;

# Imports the Google Cloud client library
use Google\Cloud\Speech\SpeechClient;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Core\ExponentialBackoff;

use App\Libraries\Tb\TbEntry;
use App\Libraries\Tb\TbMap;
use App\Libraries\Tb\Tb;
use App\Libraries\Tb\Tools;
use App\Libraries\Tb\Mp3;

use App\Models\ApiSpeechTranscript;
use App\Models\ApiSpeechWord;

use File;

use App\Libraries\Audio\ConcatAudioFilter;

use Illuminate\Contracts\Filesystem\Filesystem;
use Barryvdh\Debugbar\Facade as Debugbar;

class GraphController extends Controller
{
    public $contentInfo = array("eventCount" => 0, 
                                "eventPerView" => 0, 
                                "pauseRatio" => 0, 
                                "forwardRatio" => 0, 
                                "rewindRatio" => 0, 
                                "totalPauseCount" => 0, 
                                "totalForwardCount" => 0, 
                                "totalRewindCount" => 0, 
                                "totalStudentCount" => 0,
                                "totalViewCount" => 0,
                                "blocksForEvents" => [],
                                "blocksForViewDensity" => [],
                                "indexedForwardCount" => [],
                                "indexedPauseCount" => [],
                                "indexedRewindCount" => [],
                                "indexedViewCount" => [],
                                "duration" => [],
                                "indexedViewDensityPerCount" => [],
                            );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->processData(5533, '2016-03-01 0:00:00', '2016-08-31 0:00:00');
        //$this->upload_object();
        $user = $request->session()->get('user');
        if($user != null)
        {
            $tests = TblTrialTestName::pluck("name","trial_test_number")->all();
            $subjects = MstTopSubject::pluck("name","top_subject_number")->all();
            $ranks = MstDeviationValueRank::orderBy('rank_number', 'DESC')->get();
            return view('graph.index')->with('subjects', $subjects)->with('ranks', $ranks)->with('tests', $tests);
        }
        else
        {
            return redirect()->route('login.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show the application getSubjectContents.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSubjectContents(Request $request)
    {
        if($request->ajax()){
    		$contents = DB::select("SELECT DISTINCT
                                        d.school_contents_number
                                    FROM
                                        tbl_school_contents a
                                    INNER JOIN tbl_school_subject_section b ON a.school_subject_section_number = b.school_subject_section_number
                                    INNER JOIN tbl_school_subject c ON c.school_subject_number = b.school_subject_number
                                    INNER JOIN log_school_contents_history_student d ON d.school_contents_number = a.school_contents_number
                                    INNER JOIN log_school_contents_history_student_event e ON d.history_number = e.history_number
                                    INNER JOIN tbl_trial_test_result f ON f.student_number = d.student_number
                                    WHERE
                                        c.top_subject_number = ?", [$request->subject_number]);

            $formattedContents = array();
            foreach($contents as $content)
            { 
                $formattedContents[$content->school_contents_number] = $content->school_contents_number;
            }
                                                
            $data = view('utility.content-select', compact('formattedContents'))->render();
            return response()->json(['options'=>$data]);
    	}
    }

    /**
     * Show the application selectAjax.
     *
     * @return \Illuminate\Http\Response
     */
    public function getGraphData(Request $request){
    	if($request->ajax()){
            $logs = array();

            // Multiple Rank
            // for($i=0; $i<count($request->rank); $i++)
            // {
            //     $newLogs = $this->getLogDataRawQuery($request->test, $request->contentNumber, $request->dateFrom, $request->dateTo, $request->rank[$i], $request->subject);
            //     $logs = array_merge($logs, $newLogs);
            // }
            $logs = $this->getGrowth($request->contentNumber, $request->subject, $request->rank, $request->growth);
            //dd($growth);
            //$logs = $this->getLogData($request->test, $request->contentNumber, $request->dateFrom, $request->dateTo, $request->rank, $request->subject);
            
            $blocks = $this->getBlockMarks($request->contentNumber);
            $this->processData($logs, $blocks);

    		return response()->json(['contentInfo'=> $this->contentInfo]);
    	}
    }

    private function getLogDataRawQuery($test, $contentNummber, $dateFrom, $dateTo, $rank, $subject){
        // Database query
        $logs = DB::transaction(function() use ($test, $contentNummber, $dateFrom, $dateTo, $rank, $subject)
        {
            //$ranks = implode(",", (array)$rank);
            try 
            {
                //DB::enableQueryLog();
                DB::statement("SET @previousEventActionNumber = NULL");
                DB::statement("SET @prePreviousEventActionNumber = NULL");
                $data = DB::select("SELECT
                                        (
                                            CASE
                                            WHEN (
                                                @previousEventActionNumber = 4
                                                AND b.event_action_number = 1
                                            ) THEN
                                                'F'
                                            WHEN (
                                                @previousEventActionNumber = 1
                                                AND @prePreviousEventActionNumber = 4
                                                AND b.event_action_number = 1
                                            ) THEN
                                                'F'
                                            END
                                        ) AS state,
                                        b.event_number,
                                        b.history_number,
                                        FLOOR(a.duration / 1000) duration,
                                        FLOOR(b.progress_time / 1000) progress_time,
                                        FLOOR(b.position / 1000) position,
                                        b.event_action_number,
                                        b.speed_number,
                                        c. NAME AS contents_name,
                                        d. NAME AS subject_section_name,
                                        e. NAME AS subject_name,
                                        a.student_number,
                                        a.registered_datetime AS log_registered_day,
                                        @prePreviousEventActionNumber := @previousEventActionNumber No_Need,
                                        @previousEventActionNumber := b.event_action_number No_Need1
                                    FROM
                                        log_school_contents_history_student a
                                    INNER JOIN log_school_contents_history_student_event b ON a.history_number = b.history_number
                                    INNER JOIN tbl_school_contents c ON c.school_contents_number = a.school_contents_number
                                    INNER JOIN tbl_school_subject_section d ON d.school_subject_section_number = c.school_subject_section_number
                                    INNER JOIN tbl_school_subject e ON e.school_subject_number = d.school_subject_number
                                    INNER JOIN tbl_trial_test_result f ON f.student_number = a.student_number
                                    WHERE
                                        a.school_contents_number = ?
                                    AND a.contents_download_datetime BETWEEN ? AND ?
                                    AND f.deviation_rank = ?
                                    AND f.top_subject_number = ?
                                    AND f.trial_test_number = ?
                                    AND a.history_upload_datetime IS NOT NULL
                                    AND a.duration IS NOT NULL
                                    AND a.player3_code IS NULL
                                    AND b.event_action_number <> 3 -- Auto playback
                                    -- Changing position in pause mode
                                    AND  !(
                                        b.event_action_number = 1
                                        AND b.speed_number = 0
                                    )
                                    ORDER BY
                                        a.registered_datetime;", [$contentNummber, $dateFrom, $dateTo, $rank, $subject, $test]);

                //dd(DB::getQueryLog());
                return $data;

            } catch (\Exception $e) {
                DB::rollback();
                return null;
            }
        });

        return $logs;
    }

    private function getLogData($test, $contentNummber, $dateFrom, $dateTo, $ranks, $subject)
    {
        $logs = LogSchoolContentsHistoryStudent::join('log_school_contents_history_student_event', 'log_school_contents_history_student.history_number', '=', 'log_school_contents_history_student_event.history_number')
                        ->join('tbl_school_contents', 'log_school_contents_history_student.school_contents_number', '=', 'tbl_school_contents.school_contents_number')
                        ->join('tbl_school_subject_section', 'tbl_school_contents.school_subject_section_number', '=', 'tbl_school_subject_section.school_subject_section_number')
                        ->join('tbl_school_subject', 'tbl_school_subject_section.school_subject_number', '=', 'tbl_school_subject.school_subject_number')
                        ->join('tbl_trial_test_result', 'log_school_contents_history_student.student_number', '=', 'tbl_trial_test_result.student_number')
                        ->select(DB::raw('null as state, log_school_contents_history_student_event.event_number, log_school_contents_history_student_event.history_number, FLOOR(log_school_contents_history_student.duration / 1000) as duration, 
                                            FLOOR(log_school_contents_history_student_event.progress_time / 1000) as progress_time, FLOOR(log_school_contents_history_student_event.position / 1000) as position, log_school_contents_history_student_event.event_action_number, 
                                            log_school_contents_history_student_event.speed_number, tbl_school_contents.name AS contents_name , tbl_school_subject_section.name  AS subject_section_name, 
                                            tbl_school_subject.name AS subject_name, log_school_contents_history_student.student_number,  DATE_FORMAT(log_school_contents_history_student.registered_datetime, "%Y-%m-%d") AS log_registered_day 
                                        ')
                                )
                        ->whereBetween('log_school_contents_history_student.contents_download_datetime', [$dateFrom, $dateTo])
                        ->where('log_school_contents_history_student.school_contents_number', $contentNummber)
                        ->whereIn('tbl_trial_test_result.deviation_rank', $ranks)
                        ->where('tbl_trial_test_result.top_subject_number', $subject)
                        ->where('tbl_trial_test_result.trial_test_number', $test)
                        ->whereNotNull('log_school_contents_history_student.history_upload_datetime')
                        ->whereNotNull('log_school_contents_history_student.duration')
                        ->whereNull('log_school_contents_history_student.player3_code')
                        ->where('log_school_contents_history_student_event.event_action_number', '!=', 3)
                        ->where(function($query){
                            $query->where('log_school_contents_history_student_event.event_action_number', '!=', 1)
                                ->orWhere('log_school_contents_history_student_event.speed_number', '!=', 0);
                        })
                        ->get();
        return $logs;
    }

    private function processData($logs, $blocks)
    {
        $durationInSecond = array();
        if($logs != null)
        {
            // Getting total View Count
            $histories = array();
            // Getting total Student Count
            $students = array();
            foreach($logs as $log)
            { 
                $histories[$log->history_number][] = $log;
                $students[$log->student_number][] = $log;
            }
            $this->contentInfo['totalViewCount'] = count($histories);
            $this->contentInfo['totalStudentCount'] = count($students);
            //dd($this->contentInfo);


            $logByDuration = $this->getDuration($logs);
            //dd(json_encode($logByDuration));
            if(count($logByDuration) == 1)
            {
                
                // Creating array according to content duration
                $this->contentInfo['duration'] = array();

                $this->contentInfo['blocksForViewDensity'] = array();
                $this->contentInfo['blocksForEvents'] = array();
                
                $duration = array_keys($logByDuration)[0];
                for($i = 0; $i <= $duration; $i++)
                {
                    $durationInSecond[$i] = array("second" => $i, "viewCount" => 0, "pauseCount" => 0, "forwardCount" => 0, "rewindCount" => 0);
                    array_push($this->contentInfo['duration'] , gmdate("i:s", $i));
                    array_push($this->contentInfo['blocksForViewDensity'] , 0);
                    array_push($this->contentInfo['blocksForEvents'] , 0);
                }

                $events = array_values($logByDuration);
                
                // Loading contect Information
                if(count($events[0]) > 0)
                {
                     $this->contentInfo['contents_name'] = $events[0][0]->contents_name;
                     $this->contentInfo['subject_section_name'] = $events[0][0]->subject_section_name;
                     $this->contentInfo['subject_name'] = $events[0][0]->subject_name;
                     $this->contentInfo['registered_from'] = $events[0][0]->log_registered_day;
                     $this->contentInfo['registered_to'] = $events[0][count($events[0])-1]->log_registered_day;
                }

                // Looping through logs and calculate in second
                $previousEvent = null;
                $logCount = count($events[0]);
                for($i = 0; $i < $logCount; $i++)
                {
                    $currentEvent = $events[0][$i];
                    // if($currentEvent->history_number != 31347)
                    //     continue;

                    
                    // Pause Count
                    if($currentEvent->event_action_number == 2 && $currentEvent->speed_number == 0)
                    {
                        $valueArray = $durationInSecond[$currentEvent->position];
                        $valueArray['pauseCount'] += 1;
                        $durationInSecond[$currentEvent->position] = $valueArray;

                        $this->contentInfo['eventCount'] += 1;
                        $this->contentInfo['totalPauseCount'] += 1;
                    }

                    // Forward - Rewind Count
                    if($currentEvent->event_action_number == 1 && $currentEvent->event_number ==  $currentEvent->state)
                    {
                        // Forward position of start point 
                        if($currentEvent->position > $previousEvent->position)
                        {
                            $durationInSecond[$previousEvent->position]['forwardCount'] -= 1;
                            $this->contentInfo['totalForwardCount'] += 1;
                        }
                        // Rewind position of ending point
                        else if($currentEvent->position < $previousEvent->position)
                        {
                            $durationInSecond[$currentEvent->position]['rewindCount'] += 1;
                            $this->contentInfo['totalRewindCount'] += 1;
                        }

                        $this->contentInfo['eventCount'] += 1;
                    }

        

                    // View Density Count
                    // Checking for 1st time
                    if($previousEvent == null)
                    {
                        $previousEvent = $currentEvent;
                        continue;
                    }

                    // Play again checking
                    if($previousEvent->event_action_number == 4 && $currentEvent->event_action_number != 255)
                    {
                        $previousEvent->event_action_number = 0;
                    }
                        
                    // Checking for play start points (View Density)
                    if(($previousEvent->event_action_number == 0) || ($previousEvent->event_action_number == 2 && $previousEvent->speed_number > 0) || 
                            ($previousEvent->event_action_number == 1 && $previousEvent->event_number ==  $previousEvent->state))
                    {
                        for($j = $previousEvent->position; $j < $currentEvent->position; $j++)
                        {
                            $durationInSecond[$j]['viewCount'] += 1;
                        }
                    }
                    $previousEvent = $currentEvent;
                }

                

                if($this->contentInfo['eventCount'] > 0)
                {
                    $this->contentInfo['eventPerView'] = floor($this->contentInfo['eventCount'] / $this->contentInfo['totalViewCount']);
                    $this->contentInfo['pauseRatio'] = number_format(($this->contentInfo['totalPauseCount'] / $this->contentInfo['eventCount'] * 100),  1, '.', '');
                    $this->contentInfo['forwardRatio'] = number_format($this->contentInfo['totalForwardCount'] / $this->contentInfo['eventCount'] * 100,  1, '.', '');
                    $this->contentInfo['rewindRatio'] = number_format($this->contentInfo['totalRewindCount'] / $this->contentInfo['eventCount'] * 100,  1, '.', '');
                }

                // Getting viewcount for new index array
                $this->contentInfo['indexedViewCount'] = array();
                $this->contentInfo['indexedPauseCount'] = array();
                $this->contentInfo['indexedForwardCount'] = array();
                $this->contentInfo['indexedRewindCount'] = array();

                foreach($durationInSecond as $key => $value)
                {
                    array_push($this->contentInfo['indexedViewCount'] , $durationInSecond[$key]['viewCount']);
                    array_push($this->contentInfo['indexedPauseCount'] , $durationInSecond[$key]['pauseCount']);
                    array_push($this->contentInfo['indexedForwardCount'] , $durationInSecond[$key]['forwardCount']);
                    array_push($this->contentInfo['indexedRewindCount'] , $durationInSecond[$key]['rewindCount']);
                    array_push($this->contentInfo['indexedViewDensityPerCount'] , ($durationInSecond[$key]['viewCount'] / $this->contentInfo['totalViewCount']) * 100);
                    
                }

                // Getting Highest peak value
                $maxViewCount = max($this->contentInfo['indexedViewCount']);
                // Increasing Block value by 10% more than highest Peak 
                $maxViewCount *= 1.15;

                // Getting Highest peak value from all Events
                $maxEvents = max(max($this->contentInfo['indexedPauseCount']), max(abs(min($this->contentInfo['indexedForwardCount'])), max($this->contentInfo['indexedRewindCount'])));
                // Increasing Block value by 15% more than highest Peak 
                $maxEvents *= 1.15;
                
                // Preparing Block data
                foreach($blocks as $block)
                {
                    $position = floor($block->final_frame/100);
                    $this->contentInfo['blocksForViewDensity'][$position] = $maxViewCount;
                    $this->contentInfo['blocksForEvents'][$position] = $maxEvents;
                }
            }
        }
    }

    // Getting duration
    private function getDuration($logs)
    {
        // Group By Durations (BUG)
        $durations = array();
        foreach($logs as $log)
        { 
            $durations[$log->duration][] = $log;
        }

        // Getting Max used duration
        $maxValue = 0;
        $maxKey = 0;
        foreach ($durations as $key => $duration)
        {
            if($maxValue < count($duration))
            {
                 $maxValue = count($duration);
                 $maxKey = $key;
            }
        }

        // Adjusting bug data calculating with original duration
        $maxDurations = array();
        $previousLog = null;
        foreach($logs as $log)
        { 
            $this->fixDuration($maxKey, $log);
            if($previousLog == null)
            {
                $maxDurations[$maxKey][] = $previousLog = $log;
                continue;
            }

            else
            {
                // Getting pair value for Seeking
                if($previousLog->event_action_number == 1 && $log->event_action_number == 1 && $previousLog->state == null)
                {
                    $previousLog->state = $log->event_number;
                    $log->state = $log->event_number;
                }
                $maxDurations[$maxKey][] = $log;
                $previousLog = $log;
            }
        }
        return $maxDurations;
    }

    private function fixDuration($realDuration, $log)
    {
        $calculateData = ($realDuration / $log->duration);
        $log->duration = floor($calculateData * $log->duration);
        $log->position = floor($calculateData * $log->position);
        return $log;
    }

    private function getBlockMarks($contentNumber)
    {
        return TblSchoolContentsBlock::where('school_contents_number', $contentNumber)->get();
    }

    private function getGrowth($content, $subject, $rank, $growth)
    {
        try
        {
            switch ($growth) {
                case 1:
                    $data = DB::select('CALL sp_growth_over(?,?,?)', array($content, $subject, implode(",",$rank)));
                    break;
                case 2:
                    $data = DB::select('CALL sp_growth_little(?,?,?)', array($content, $subject, implode(",",$rank)));
                    break;
                case 3:
                    $data = DB::select('CALL sp_growth_under(?,?,?)', array($content, $subject, implode(",",$rank)));
                    break;
            }
            return $data;
        }
        catch (Exception $e) 
        {
            return $e;
        }
    }

    public function getTranscribeSync()
    {
        # Your Google Cloud Platform project ID
        $projectId = 'kjs-speech-api-1506584214035';
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__ .'/kjs-speech-api-be0e3f3e08c8.json'); //your path to file of cred

        # Instantiates a client
        $speech = new SpeechClient([
            'projectId' => $projectId,
            'languageCode' => 'ja-JP',
        ]);

        # The name of the audio file to transcribe
        $fileName = __DIR__ . '/test.flac';

        # The audio file's encoding and sample rate
        $options = [
            'encoding' => 'FLAC',
            'sampleRateHertz' => 22050,
        ];

        # Detects speech in the audio file
        $results = $speech->recognize(fopen($fileName, 'r'), $options);

        $transcribedData = array();
        foreach ($results as $key => $value) 
        {
            array_push($transcribedData, $value->alternatives()[0]['transcript']);
        }

        return response()->json(['transcribedData'=> $transcribedData]);
    }

    private function convertToFlac()
    {
        $ffmpeg = \FFMpeg\FFMpeg::create([
            'ffmpeg.binaries' => 'C:/ffmpeg/bin/ffmpeg.exe',
            'fprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe',
        ]);
        $audio = $ffmpeg->open(storage_path('app/sounds/255/1.mp3'));
        
        $format = new FFMpeg\Format\Audio\Flac();
        $format->on('progress', function ($audio, $format, $percentage) {
            echo "$percentage % transcoded";
        });
        
        $format
            ->setAudioChannels(1)
            ->setAudioKiloBitrate(32);
        
        $audio->save($format, 'track.flac');
    }

    /**
    * Transcribe an audio file using Google Cloud Speech API
    * Example:
    * ```
    * transcribe_async_gcs('your-bucket-name', 'audiofile.wav');
    * ```.
    *
    * @param string $bucketName The Cloud Storage bucket name.
    * @param string $objectName The Cloud Storage object name.
    * @param string $languageCode The Cloud Storage
    *     be recognized. Accepts BCP-47 (e.g., `"en-US"`, `"es-ES"`).
    * @param array $options configuration options.
    *
    * @return string the text transcription
    */
    function getTranscribe(Request $request)
    {
        # Your Google Cloud Platform project ID
        $projectId = 'kjs-speech-api-1506584214035';
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__ .'/kjs-speech-api-997d7db4b8f5.json'); //your path to file of cred

        # Instantiates a client
        $speech = new SpeechClient([
            'projectId' => $projectId,
            'languageCode' => 'ja-JP'
        ]);

        # The audio file's encoding and sample rate
        $options = [
            'encoding' => 'FLAC',
            'sampleRateHertz' => 22050,
            'enableWordTimeOffsets' => true,
        ];

        // Fetch the storage object
        $fileName = $request->contentNumber;
        $storage = new StorageClient();
        $object = $storage->bucket('kjs-lms')->object($fileName.'.flac');

        // Create the asyncronous recognize operation
        $operation = $speech->beginRecognizeOperation(
            $object,
            $options
        );

        // Wait for the operation to complete
        $backoff = new ExponentialBackoff(100);
        $backoff->execute(function () use ($operation) {
            print('Waiting for operation to complete' . PHP_EOL);
            $operation->reload();
            if (!$operation->isComplete()) {
                throw new Exception('Job has not yet completed', 500);
            }
        });

        // Print the results
        if ($operation->isComplete()) {
            $results = $operation->results();

            $transcribedData = array();
            //dd($results);
            foreach ($results as $result) 
            {
                $alternative = $result->alternatives()[0];

                $apiSpeechTranscript = new ApiSpeechTranscript;
                $apiSpeechTranscript->student_content_number = $fileName;
                $apiSpeechTranscript->transcript = $alternative['transcript'];
                $apiSpeechTranscript->confidence = $alternative['confidence'];
                $apiSpeechTranscript->save();
                $insertedId = $apiSpeechTranscript->transcript_number;

                foreach ($alternative['words'] as $words) 
                {
                    $kanji = ''; 
                    $katakana = '';
                    if (strpos($words['word'], '|') !== false) 
                    {
                        $kanji = explode("|", $words['word'])[0];
                        $katakana = explode("|", $words['word'])[1];
                    }
                    else
                    {
                        $kanji = $words['word'];
                    }
                    $apiSpeechWord = new ApiSpeechWord;
                    $apiSpeechWord->student_content_number = $fileName;
                    $apiSpeechWord->start_time = rtrim($words['startTime'], "s");
                    $apiSpeechWord->end_time = rtrim($words['endTime'], "s"); 
                    $apiSpeechWord->word_kanji = $kanji;
                    $apiSpeechWord->word_katakana = $katakana;
                    $apiSpeechWord->transcript_number = $insertedId;
                    $apiSpeechWord->save();
                }
            }
        }
    }

    function convertToAudio(Request $request)
    {
        $message = 'error';
        // Reading Tb content
        try 
        {
            $fileTypes = array("TBO-LN", "TBON");
            $file = null;
            foreach ($fileTypes as $fileType) 
            {
                if (File::exists(storage_path('app/contents/'.$request->contentNumber.'.'.$fileType)))
                {
                    $file = File::get(storage_path('app/contents/'.$request->contentNumber.'.'.$fileType));
                    break;
                }
            }
            
    
            if($file != null)
            {
                // Checking for directory existance
                if (!File::exists(storage_path('app/sounds/'.$request->contentNumber))) 
                {
                    mkdir(storage_path('app/sounds/'.$request->contentNumber), 0777, true);
                }
                
                // Writing MP3 
                $tb = new Tb();
                $play_data = $tb->setBinary($file)->getPlayData();
                for ($i=0; $i < count($play_data['blocks']); $i++) 
                {
                    File::put(storage_path('app/sounds/'.$request->contentNumber.'/'.$i.'.mp3'), $play_data['blocks'][$i]['audio']);
                }

                // Reading MP3 from folder
                $soundFileAbsolutePaths = glob(storage_path('app/sounds/'.$request->contentNumber.'/*.*'));
                $tempPaths = array();
                for ($i=1; $i < count($soundFileAbsolutePaths); $i++) 
                { 
                    array_push($tempPaths, $soundFileAbsolutePaths[$i]);
                } 
                
                Debugbar::info($soundFileAbsolutePaths);
                // Concating the Blocks MP3s and Converting to FLAC
                if(count($soundFileAbsolutePaths) > 1)
                {
                    $ffmpeg = \FFMpeg\FFMpeg::create([
                        'ffmpeg.binaries' => 'C:/ffmpeg/bin/ffmpeg.exe',
                        'fprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe',
                    ]);
                    $audio = $ffmpeg->open($soundFileAbsolutePaths[0]);
                    $filter = new ConcatAudioFilter();
                    $filter->addFiles($tempPaths);
            
                    $format = new FFMpeg\Format\Audio\Flac();
                    $format->on('progress', function ($audio, $format, $percentage) {
                        //echo "$percentage % transcoded";
                    });
                    
                    $format
                        ->setAudioChannels(1)
                        ->setAudioKiloBitrate(32);
                    $audio->addFilter($filter);
                    $audio->save($format, storage_path('app/sounds/'.$request->contentNumber.'.flac'));

                    $folderPath = storage_path('app/sounds/'.$request->contentNumber);
                    $this->rmdir_recursive($folderPath);

                    $this->uploadObject($request->contentNumber.'.flac', storage_path('app/sounds/'.$request->contentNumber.'.flac'));

                }
                $message = 'success';
            }
            
        } 
        catch (\Exception $e) 
        {
            $message =  $e->getMessage();
        }

        return response()->json(['message'=> $message]);
    }

    function speechToText(Request $request)
    {
        if($request->ajax())
        {
            $startTime = $this->convertToSecond($request->startTime);
            $endTime = $this->convertToSecond($request->endTime);

            $kanji = array();
            $katakana = array();
            if($startTime > $endTime)
            {
                //list($startTime, $endTime) = array($startTime, $endTime);

                $startTime =  $startTime + $endTime;  // 5 + 6 = 11
                $endTime = $startTime - $endTime;   // 11 - 6 = 5
                $startTime = $startTime - $endTime;
            }

            $apiSpeechWords = ApiSpeechWord::where('start_time', '>=', $startTime)->where('start_time', '<=', $endTime)->where('student_content_number', $request->contentNumber)->get();
            foreach ($apiSpeechWords as $apiSpeechWord) 
            {
                array_push($kanji, $apiSpeechWord->word_kanji);
                array_push($katakana, $apiSpeechWord->word_katakana);
            }

            return response()->json(['kanji'=> $kanji, 'katakana'=> $katakana]);
        }
    }

    function convertToSecond($minuteSecond)
    {
        sscanf($minuteSecond, "%d:%d:%d", $hours, $minutes, $seconds);
        return isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
    }

    function concatAudio()
    {
        $ffmpeg = \FFMpeg\FFMpeg::create([
            'ffmpeg.binaries' => 'C:/ffmpeg/bin/ffmpeg.exe',
            'fprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe',
        ]);
        $audio = $ffmpeg->open(storage_path('app/sounds/335/0.mp3'));
        $filter = new ConcatAudioFilter();
        $filter->addFiles([
            storage_path('app/sounds/335/1.mp3'),
            storage_path('app/sounds/335/2.mp3')
        ]);

        $format = new FFMpeg\Format\Audio\Flac();
        $format->on('progress', function ($audio, $format, $percentage) {
            echo "$percentage % transcoded";
        });
        
        $format
            ->setAudioChannels(1)
            ->setAudioKiloBitrate(32);
        $audio->addFilter($filter);
        $audio->save($format, storage_path('app/sounds/335/full.flac'));
    }

    function rmdir_recursive($dir) 
    {
        foreach(scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }

    function uploadObject($objectName, $source)
    {
        $projectId = 'kjs-speech-api-1506584214035';
        $bucketName = 'kjs-lms';
        //$objectName = '255.flac';
        //$source = storage_path('app/sounds/255.flac');
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__ .'/kjs-speech-api-0488e705ae97.json'); //your path to file of cred

        $storage = new StorageClient([
            'projectId' => $projectId
        ]);
        $file = fopen($source, 'r');
        $bucket = $storage->bucket($bucketName);
        $object = $bucket->upload($file, [
            'name' => $objectName,
            'predefinedAcl' => 'PUBLICREAD'
        ]);
        //printf('Uploaded %s to gs://%s/%s' . PHP_EOL, basename($source), $bucketName, $objectName);
    }
}
