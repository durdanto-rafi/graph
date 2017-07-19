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
        });
        //dd($logs);
        

        $duration = $this->getDuration($logs);
        //dd($duration);

        // Group By history from Log
        $histories = array();
        foreach($logs as $log)
        { 
            if($log->state != 'D')
            {
                $histories[$log->history_number][] = $log;
            }
        }

        //dd(json_encode($histories));

        foreach($histories as $history)
        {
            dd($history);
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
        $durations = array();
        foreach($logs as $log)
        { 
            if($log->state != 'D')
            {
                $durations[$log->duration][] = $log;
            }
        }

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
        return $maxKey;
    }
}
