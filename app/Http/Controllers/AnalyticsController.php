<?php

namespace App\Http\Controllers;

use App\Techniques;
use App\Analytics;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Analytics::all());
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
        if (!isset($request->UserID) || !isset($request->Username) || !isset($request->Action)){
            return response()->json(['ResultCode' => 1, 'Message' => 'Invalid Parameters']);
        }
        switch ($request->Action) {

            // @Params: UserID, Username, Action, SessionTime
            case 'OpenedApp':
                if (!isset($request->SessionTime)){
                    return response()->json(['ResultCode' => 1, 'Message' => 'Invalid Parameters']);
                }
                return $this->processOpened($request);

            // @Params: UserID, Username, Action, TechName, TechniqueSessionTime
            case 'CompletedExperience':
                if (!isset($request->TechName) || !isset($request->TechniqueSessionTime)){
                    return response()->json(['ResultCode' => 1, 'Message' => 'Invalid Parameters']);
                }
                return $this->processExperience($request);
            default:
                return response()->json(['ResultCode' => 1, 'Message' => 'Invalid Action']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Analytics  $analytics
     * @return \Illuminate\Http\Response
     */
    public function show(Analytics $analytics)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Analytics  $analytics
     * @return \Illuminate\Http\Response
     */
    public function edit(Analytics $analytics)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Analytics  $analytics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Analytics $analytics)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Analytics  $analytics
     * @return \Illuminate\Http\Response
     */
    public function destroy(Analytics $analytics)
    {
        //
    }

    public function processOpened(Request $request)
    {
        // Check if user id already exists
        $res = Analytics::where('user_id', '=', $request->UserID)->first();

        // Create if it does not exist
        if (!isset($res->user_id)){
            $analytic = Analytics::create([
                'user_id' => $request->UserID, 
                'username' => $request->Username, 
                'session_time' => $request->SessionTime, 
                'completed_experiences' => 0,
                'opened_app' => 0
            ]);
            $analytic->save();
        }
        // If exists, update the values.
        else 
        {
            Analytics::where('user_id', '=', $res->user_id)->update(
                    [
                        'username' => $request->Username,
                        'session_time' => ($res->session_time + $request->SessionTime),
                        'opened_app' => ($res->opened_app + 1)
                    ]
                );
        }
        return response()->json(['ResultCode' => 0, 'Message' => 'OK']);
    }

    public function processExperience(Request $request){

        // Check if a record for the current technique already exists
        $res = Techniques::where([
            'user_id' => $request->UserID,
            'tech_name' => $request->TechName
        ])->first();

        // Create if it does not exist
        if (!isset($res->user_id)){
            $tech = Techniques::create([
                'user_id' => $request->UserID,
                'username' => $request->Username, 
                'tech_name' => $request->TechName, 
                'session_time' => $request->TechniqueSessionTime, 
                'completion' => 1,
            ]);
            $tech->save();
        }else{
            Techniques::where('user_id', '=', $res->user_id)->update(
                [
                    'username' => $request->Username,
                    'session_time' => ($res->session_time + $request->TechniqueSessionTime),
                    'completion' => ($res->completion + 1)
                ]
            );
        }

        // Check if exists user record in analytics
        $analytic = Analytics::where('user_id', '=', $request->UserID)->first();
        if (isset($analytic->user_id)){
            Analytics::where('user_id', $analytic->user_id)->increment('completed_experiences', 1);
        }
        return response()->json(['ResultCode' => 0, 'Message' => 'OK']);
    }
}