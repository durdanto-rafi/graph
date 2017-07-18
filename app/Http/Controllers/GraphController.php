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
        $logs = DB::select("SELECT
                                b.event_number,
                                b.history_number,
                                FLOOR(a.duration / 1000) duration,
                                FLOOR(b.progress_time / 1000) progress_time,
                                FLOOR(b.position / 1000) position,
                                b.event_action_number,
                                b.speed_number
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
                            AND b.event_action_number <> 2
                            AND b.event_action_number <> 3
                            AND b.event_action_number <> 4
                            AND ! (
                                b.event_action_number = 1
                                AND b.position = a.duration
                            )
                            AND ! (
                                b.event_action_number = 1
                                AND b.position = 0
                            )
                            AND ! (
                                b.progress_time = 0
                                AND b.position = 0
                                AND b.event_action_number = 0
                            )");

        dd($logs);

        // Group By history from Log
        $duration = 0;               
        $histories = array();
        foreach($logs as $log)
        { 
            $histories[$log->history_number][] = $log;
            if($duration == 0)
            {
                $duration =  $log->duration;
            }
        }

        //dd($duration);

        for($i = 0; $i < $duration; $i++)
        {

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
}
