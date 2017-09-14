<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Models\MstTopSubject;
use App\Models\MstDeviationValueRank;
use App\Models\TblTrialTestName;
use App\Models\LogSchoolContentsHistoryStudent;
use App\Models\TblSchoolContentsBlock;

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
                            );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->processData(5533, '2016-03-01 0:00:00', '2016-08-31 0:00:00');

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
            $logs = $this->getLogData($request->test, $request->contentNumber, $request->dateFrom, $request->dateTo, $request->rank, $request->subject);
            
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
}
