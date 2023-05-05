<?php

namespace App\Http\Controllers;

use App\DebugRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DebugRequestController extends Controller
{
    public function create(Request $request)
    {
        DebugRequest::create(array('request' => json_encode($request->all())));
        return response()->json(['ResultCode' => 0, 'Message' => 'OK.']);
    }

    public function list()
    {
        $res = DebugRequest::all();
        return response()->json(new JsonResponse(['items' => $res]));
    }

    public function delete()
    {
        DebugRequest::truncate();
        return response()->json(['ResultCode' => 0, 'Message' => 'Delete All.']);
    }
}
