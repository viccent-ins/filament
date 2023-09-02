<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseResponseController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class AuthController extends BaseResponseController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['w3Login', 'register']]);
    }
    public function w3Login(Request $request): Response
    {
        $request->validate([
            'user_address' => 'required',
        ]);
        $w3Exist = User::where('user_address', $request->user_address)->first();
        try {
            if ($w3Exist) {
                $w3Exist->login_time = Carbon::now();
                $w3Exist->update();
                $user = $w3Exist;
                if ($user == null) {
                    return $this->responseFail('unAuthorize');
                }
            } else {
                $user = User::create([
                    'user_address' => $request->user_address,
                    'username' => $request->username ?? '',
                    'user_level' => $request->username ?? '',
                    'login_time' => Carbon::now(),
                    'phone' => $request->phone ?? '',
                    'is_delete' => 0,
                ]);
            }
            $token = $user->createToken('authToken');
        } catch (Exception $e) {
            echo $e->getMessage();   // insert query
            return $this->responseFail($e);
        }
        return $this->responseToken($token);
    }
    public function logout(): Response
    {
        $user = Auth::user()->token();
        $user->revoke();
        return $this->responseSuccess(null);
    }
    public function refresh(): Response
    {
        $token = Auth::user()->token();
        $token->revoke();
        $newToken = $token->createToken('New Token Name');
        return $this->responseToken($newToken);

    }
    protected function responseToken($token): Response
    {
        $data = [
            'Authorization' => [
                'access_token' => $token->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($token->token->expires_at)->toDateString(),
            ]
        ];
        return $this->responseSuccess($data, 0, 201);
    }

}
