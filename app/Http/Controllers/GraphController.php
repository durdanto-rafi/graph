<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class GraphController extends Controller
{
    public $contentInfo = array();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$this->processData(5533, '2016-03-01 0:00:00', '2016-08-31 0:00:00');
        return view('graph.index');
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

    private function getDuration($logs)
    {
        // Group By Durations (BUG)
        $durations = array();
        foreach($logs as $log)
        { 
            $durations[$log->duration][] = $log;
        }

        //dd(json_encode($durations));

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
        $durations = array();
        $previousLog = null;
        foreach($logs as $log)
        { 
            if($previousLog == null)
            {
                $durations[$log->duration][] = $previousLog = $log;
                continue;
            }

            else
            {
                if($log->state != 'D')
                {   
                    if($previousLog->event_action_number == 1 && $log->event_action_number == 1 && $previousLog->state == null)
                    {
                        $previousLog->state = $log->event_number;
                        $log->state = $log->event_number;
                    }
                    $this->fixDuration($maxKey, $log);
                    $durations[$log->duration][] = $log;
                    $previousLog = $log;
                }
            }
        }

        //dd(json_encode($durations));
      
        return $durations;
    }

    private function fixDuration($realDuration, $log)
    {
        $calculateData = ($realDuration / $log->duration);

        $log->duration = floor($calculateData * $log->duration);
        //$log->progress_time = floor($calculateData * $log->progress_time);
        $log->position = floor($calculateData * $log->position);

        return $log;
    }

    /**
     * Show the application selectAjax.
     *
     * @return \Illuminate\Http\Response
     */
    public function getGraphData(Request $request)
    {
    	if($request->ajax()){
            $durationInSecond = $this->processData($request->contentNumber, $request->dateFrom, $request->dateTo);
    		return response()->json(['durationInSecond'=> $durationInSecond, 'contentInfo'=> $this->contentInfo]);
    	}
    }

    private function processData($contentNummber, $dateFrom, $dateTo)
    {
        $logs = DB::transaction(function() use ($contentNummber, $dateFrom, $dateTo)
        {
            try 
            {
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
                                    c.name as contents_name,
                                    d.name as subject_section_name,
                                    e.name as subject_name,
                                    a.registered_datetime as log_registered_day,
                                    @prePreviousEventActionNumber := @previousEventActionNumber No_Need,
                                    @previousEventActionNumber := b.event_action_number No_Need1
                                    FROM
                                    log_school_contents_history_student a
                                    INNER JOIN log_school_contents_history_student_event b ON a.history_number = b.history_number
                                    INNER JOIN tbl_school_contents c ON c.school_contents_number = a.school_contents_number
                                    INNER JOIN tbl_school_subject_section d ON d.school_subject_section_number = c.school_subject_section_number
                                    INNER JOIN tbl_school_subject e ON e.school_subject_number = d.school_subject_number
                                    WHERE
                                    a.school_contents_number = ?
                                    AND a.contents_download_datetime BETWEEN ?
                                    AND ?
                                    AND a.history_upload_datetime IS NOT NULL
                                    AND a.duration IS NOT NULL
                                    AND a.player3_code IS NULL
                                    AND b.event_action_number <> 3 -- Auto playback
                                    -- Changing position in pause mode
                                    AND ! (
                                    b.event_action_number = 1
                                    AND b.speed_number = 0
                                    ) order by a.registered_datetime", [$contentNummber, $dateFrom, $dateTo]);
                return $data;

            } catch (\Exception $e) {
                DB::rollback();
                return null;
            }
        });

        //dd($logs);
        $durationInSecond = array();
        if($logs != null)
        {
            $logByDuration = $this->getDuration($logs);
            if(count($logByDuration) == 1)
            {
                $duration = array_keys($logByDuration)[0];
                for($i = 0; $i <= $duration; $i++)
                {
                    $durationInSecond[$i] = array("second" => $i, "viewCount" => 0, "pauseCount" => 0, "forwardCount" => 0, "rewindCount" => 0);
                }
                //dd($durationInSecond);

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
                    }

                    // Forward - Rewind Count
                    if($currentEvent->event_action_number == 1 && $currentEvent->event_number ==  $currentEvent->state)
                    {
                        $valueArray = $durationInSecond[$currentEvent->position];
                        // Forward
                        if($currentEvent->position > $previousEvent->position)
                        {
                            $valueArray['forwardCount'] += 1;
                        }
                        // Rewind
                        else if($currentEvent->position < $previousEvent->position)
                        {
                            $valueArray['rewindCount'] += 1;
                        }
                        
                        $durationInSecond[$currentEvent->position] = $valueArray;
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
                            $valueArray = $durationInSecond[$j];
                            $valueArray['viewCount'] += 1;
                            $durationInSecond[$j] = $valueArray;
                        }
                    }
                    $previousEvent = $currentEvent;
                }
                //dd(json_encode($durationInSecond));
            }
        }
        return $durationInSecond;
    }
}
