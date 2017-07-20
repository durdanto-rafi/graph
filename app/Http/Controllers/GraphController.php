<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = DB::transaction(function()
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
                                                'D'
                                            WHEN (
                                                @previousEventActionNumber = 1
                                                AND @prePreviousEventActionNumber = 4
                                                AND b.event_action_number = 1
                                            ) THEN
                                                'D'
                                            END
                                        ) AS state,
                                        b.event_number,
                                        b.history_number,
                                        FLOOR(a.duration / 1000) duration,
                                        FLOOR(b.progress_time / 1000) progress_time,
                                        FLOOR(b.position / 1000) position,
                                        b.event_action_number,
                                        b.speed_number,
                                        -- Flagging Auto playback
                                        @prePreviousEventActionNumber := @previousEventActionNumber No_Need,
                                        @previousEventActionNumber := b.event_action_number No_Need
                                    FROM
                                        log_school_contents_history_student a
                                    INNER JOIN log_school_contents_history_student_event b ON a.history_number = b.history_number
                                    WHERE
                                        a.school_contents_number = 5533

                                    AND a.contents_download_datetime BETWEEN '2016-03-01 0:00:00'
                                    AND '2016-08-31 0:00:00'
                                    AND a.history_upload_datetime IS NOT NULL
                                    AND a.duration IS NOT NULL
                                    AND a.player3_code IS NULL
                                    AND b.event_action_number <> 3 
                                    -- Start point 
                                    AND ! (
                                        b.progress_time = 0
                                        AND b.position = 0
                                        AND b.event_action_number = 0
                                    ) 
                                    -- Changing position in pause mode 
                                    AND ! (
                                        b.event_action_number = 1
                                        AND b.speed_number = 0
                                    )");
                return $data;

            } catch (\Exception $e) {
                DB::rollback();
                return null;
            }
        });
        
        if($logs != null)
        {
            $logByDuration = $this->getDuration($logs);

            if(count($logByDuration) == 1)
            {
                $durationInSecond = array();
                for($i = 0; $i <= array_keys($logByDuration)[0]; $i++)
                {
                    $durationInSecond[$i] = 0;
                }
                //dd($durationInSecond);

                $events = array_values($logByDuration);

                // Group By history from Events
                $previousEvent = null;
                foreach($events[0] as $event)
                { 
                    $previousEvent = new $event;
                    $previousEvent->position = 0;
                    // Pause
                    if($event->event_action_number == 2 && $event->speed_number == 0)
                    {
                        for($i = $previousEvent->position; $i <= $event->position; $i++)
                        {
                            $value = $durationInSecond[$i];
                            $durationInSecond[$i] = $value + 1;
                        }
                        
                    }

                    // Forward/Rewind
                    else if($event->event_action_number == 1)
                    {
                        if($previousEvent->event_action_number == 2 && $event->speed_number == 10)
                        {
                            for($i = $previousEvent; $i <= $event->position; $i++)
                            {
                                $value = $durationInSecond[$i];
                                $durationInSecond[$i] = $value + 1;
                            }
                        }
                        
                    }

                    // Self Stop
                    else if($event->event_action_number == 2 && $event->speed_number == 0)
                    {
                        for($i = $previousEvent; $i <= $event->position; $i++)
                        {
                            $value = $durationInSecond[$i];
                            $durationInSecond[$i] = $value + 1;
                        }
                    }

                    // Exit
                    else if($event->event_action_number == 2 && $event->speed_number == 0)
                    {
                        for($i = $previousEvent; $i <= $event->position; $i++)
                        {
                            $value = $durationInSecond[$i];
                            $durationInSecond[$i] = $value + 1;
                        }
                    }
                    $previousEvent = $event;
                }
               
            }
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
        $durations = array();
        $previousLog = null;
        foreach($logs as $log)
        { 
            if($previousLog == null)
            {
                $previousLog = $log;
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
                        //dd($log);
                    }
                    $this->fixDuration($maxKey, $log);
                    $durations[$log->duration][] = $log;
                    $previousLog = $log;
                }
            }
        }

        dd(json_encode($durations));
      
        return $durations;
    }

    private function fixDuration($realDuration, $log)
    {
        $calculateData = ($realDuration / $log->duration);

        $log->duration = $calculateData * $log->duration;
        $log->progress_time = $calculateData * $log->progress_time;
        $log->position = $calculateData * $log->position;

        return $log;
    }
}
