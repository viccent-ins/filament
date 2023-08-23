<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseResponseController;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Withdraw;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserAccountController extends BaseResponseController
{
    public function __construct() {
       $this->middleware('auth:api');
    }
    public function getDeposit(): Response
    {
        $deposits = Deposit::orderBy('created_at', 'desc')
            ->where('user_id', $this->getAuthId())
            ->get();
        $Result = [
            'Deposits' => $deposits,
        ];
        return $this->responseSuccess($Result);
    }
    public function storeDeposit(Request $request): Response
    {
        $request->validate([
            'deposit_amount' => 'required|unique:users,phone',
            'deposit_bank' => 'required',
        ]);
        $deposit = new Deposit();
        try {
            $deposit->user_id = $this->getAuthId();
            $deposit->deposit_amount = $request->deposit_amount;
            $deposit->deposit_bank = $request->deposit_bank;
            $deposit->save();
        } catch (Exception $e) {
            return Response($e->getMessage());
        }
        $Result = [
            'Deposit' => $deposit,
        ];
        return $this->responseSuccess($Result);
    }
    public function getWithdraw(): Response
    {
        $withdraws = Withdraw::orderBy('created_at', 'desc')
            ->where('user_id', $this->getAuthId())
            ->get();
        $Result = [
            'Withdraws' => $withdraws,
        ];
        return $this->responseSuccess($Result);
    }
    public function storeWithdraw(Request $request): Response
    {
        $request->validate([
            'withdraw_amount' => 'required|unique:users,phone',
            'withdraw_bank' => 'required|unique:users,phone',
        ]);
        $withdraw = new Withdraw();
        try {
            $withdraw->user_id = $this->getAuthId();
            $withdraw->withdraw_amount = $request->withdraw_amount;
            $withdraw->withdraw_bank = $request->withdraw_bank;
            $withdraw->save();
        } catch (Exception $e) {
            return Response($e->getMessage());
        }
        $Result = [
            'Withdraw' => $withdraw,
        ];
        return $this->responseSuccess($Result);
    }
}
