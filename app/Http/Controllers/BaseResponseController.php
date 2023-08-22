<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BaseResponseController extends Controller
{
    public function responseSuccess($result, $errorCode = 0, $status = 200): Response
    {
        $response = [
            'ErrorCode' => $errorCode,
            'Data' => $result,
        ];
        return Response($response, $status);
    }

    public function responseFail($errorMessage, $errorCode = 1, $status = 200): Response
    {
        $response = [
            'Message' => $errorMessage,
            'ErrorCode' => $errorCode,
        ];
        return Response($response, $status);
    }
    public function responseUnAuthorize() : Response
    {
        $response = [
            'Message' => 'Unauthorize',
            'ErrorCode' => 1,
        ];
        return Response($response, 200);
    }
    public function createdBy() {
        return auth()->user()->name;
    }
}
