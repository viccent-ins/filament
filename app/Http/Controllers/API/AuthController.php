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
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function login(Request $request): Response
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|string',
        ]);
        try {
            $credentials = $request->only('username', 'password');
            Auth::attempt($credentials);
            $user = Auth::user();
            if ($user == null) {
                return $this->responseFail('username or password is incorrect');
            }
            $token = $user->createToken('authToken');
        } catch (Exception $e) {
            echo $e->getMessage();   // insert query
            return $this->responseFail($e);
        }
        return $this->responseToken($token);
    }

    public function register(Request $request): Response
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'nick_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user = User::create([
            'username' => $request->username,
            'nick_name' => $request->nick_name,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
            'email' => $request->email ?? '',
            'referral' => $request->referral_code,
            'status' => 0,
        ]);
        $token = $user->createToken('authToken');
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
        return $this->responseToken(auth('api')->refresh());
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
