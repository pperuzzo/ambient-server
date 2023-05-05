<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Scene;

class AmbientController extends Controller
{
    public function authenticate(Request $request)
    {
        if (!isset($request->email) && !isset($request->password))
        {
            return response()->json(['ResultCode' => 3, 'Message' => "Missing email and password"]);
        }
        if (!isset($request->email))
        {
            return response()->json(['ResultCode' => 3, 'Message' => "Missing email"]);
        }
        if (!isset($request->password))
        {
            return response()->json(['ResultCode' => 3, 'Message' => "Missing password"]);
        }
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) 
        {
            $result = Scene::select('GameId')->where('UserId', Auth::user()->id)->get();

            $data = [
                'ResultCode' => 1,
                'UserId' => Auth::user()->id,
                'Nickname' => Auth::user()->name,
                "Data" => [
                    json_encode($result, JSON_FORCE_OBJECT)
                ]
            ];

            $json = ['ResultCode' => 1, 'UserId' => Auth::user()->id, 'Nickname' => Auth::user()->name, 'Data' => $result];
            return json_encode($json, JSON_FORCE_OBJECT);


            return response()->json(['ResultCode' => 1, 'UserId' => Auth::user()->id, 'Nickname' => Auth::user()->name, 'Data' => $result]);
        }
        else
        {
            return response()->json(['ResultCode' => 2, "Message" => "Wrong email and/or password. Try again."]);
        }
    }
}
