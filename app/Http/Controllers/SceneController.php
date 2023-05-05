<?php

namespace App\Http\Controllers;

use App\Scene;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\DebugRequest;

class SceneController extends Controller
{
    // WEB RPC
    public function list(Request $request)
    {
        if (!isset($request->UserId)){
            return response()->json(['ResultCode' => 1, 'Message' => 'Internal error.']);
        }
        $res = Scene::where("UserId", "=", (int)$request->UserId)->get();

        $scenes = [];
        foreach ($res as $key => $value) 
        {
            array_push($scenes, ['GameId' => $value->GameId]);
        }

        $data = ['WebRpcCode'=> 0, 'Scenes' => $scenes];
        $json = ['ResultCode' => 0, 'Message' => 'OK', 'Data' => $data];
        return json_encode($json, JSON_FORCE_OBJECT);
        return response()->json($json);
    }

    public function create(Request $request)
    {
        if ($request->Type == "Create"){
            return $this->createScene($request);
        }
        elseif ($request->Type == "Load"){
            return $this->loadScene($request);
        }
    }

    public function close(Request $request)
    {
        if (!isset($request->GameId)){
            return response()->json(['ResultCode' => 1, 'Message' => 'Internal error.']);
        }

        $res = Scene::where('GameId', '=', $request->GameId)->first();
        if (!isset($res->id)){
            return response()->json(['ResultCode' => 1, 'Message' => 'Scene not found in the server.']);
        }
        
        $json = json_encode($request->State, JSON_UNESCAPED_SLASHES);
        $state = json_decode($json);
        $state->ActorCounter = 1;
        $state->ActorList = array_slice($state->ActorList, 0, 1);
        foreach ($state->ActorList as $key => $value) {
            unset($value->Nickname);
            unset($value->DEBUG_BINARY);
        }
        unset($state->DebugInfo);

        $res->State = json_encode($state, JSON_UNESCAPED_SLASHES);
        $res->save();

        return response()->json(['ResultCode' => 0, 'Message' => 'OK']);
    }

    // WEB RPC
    public function delete(Request $request)
    {
        if (!isset($request->UserId) || !isset($request->RpcParams)){
            return response()->json(['ResultCode' => 1, 'Message' => 'Internal error.', 'WebRpcCode' => 1]);
        }
        $res = Scene::where(['UserId' => $request->UserId, 'GameId' => $request->RpcParams])->first();
        if (!isset($res->id)){
            return response()->json(['ResultCode' => 1, 'Message' => 'Errror. Scene not found.']);
        }
        Scene::destroy($res->id);
        return response()->json(['ResultCode' => 0, 'Message' => 'OK', 'Data' => ['WebRpcCode'=> 1]]);
    }

    public function createScene(Request $request)
    {
        if (!isset($request->GameId) || !isset($request->UserId)){
            return response()->json(['ResultCode' => 1, 'Message' => 'Internal error.']);
        }

        // Check User ID
        $request->UserId = (int)$request->UserId;
        $res = User::find($request->UserId);
        if (!isset($res->id)){
            return response()->json(['ResultCode' => 3, 'Message' => "Invalid User ID."]);
        }

        // Check scene Name
        $res = Scene::where('GameId', '=', $request->GameId)->first();
        if (isset($res->id)){
            return response()->json(['ResultCode' => 3, 'Message' => "This scene name is already taken. Try another one."]);
        }

        Scene::create(array('GameId' => $request->GameId, 'UserId' => $request->UserId, 'State' => " "));
        return response()->json(['ResultCode' => 0, 'Message' => "OK"]);
    }

    public function loadScene(Request $request)
    {
        if (!isset($request->GameId)){
            return response()->json(['ResultCode' => 1, 'Message' => 'Internal error.']);
        }

        // Check scene Name
        $res = Scene::where('GameId', '=', $request->GameId)->first();
        if (!isset($res->id)){
            return response()->json(['ResultCode' => 1, 'Message' => "The scene could not be found in our servers."]);
        }
        return '{ "State" : '. $res->State . ', "ResultCode" : 0 }';
    }


    public function test(Request $request)
    {
        $res = Scene::where('GameId', '=', $request->GameId)->first();
        return $res->State;
    }

}
