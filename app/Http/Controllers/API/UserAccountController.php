<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseResponseController;
use App\Http\Controllers\Controller;
use App\Models\BankCardManagement;
use App\Models\Deposit;
use App\Models\User;
use App\Models\Withdraw;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

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
    public function getBankCardManagement(): Response
    {
        $bankCards = BankCardManagement::orderBy('created_at', 'desc')
            ->where('user_id', $this->getAuthId())
            ->get();
        $Result = [
            'BankCardManagements' => $bankCards,
        ];
        return $this->responseSuccess($Result);
    }
    public function storeBankCardManagement(Request $request): Response
    {
        $request->validate([
            'card_name' => 'required|unique:users,phone',
            'card_address' => 'required|unique:users,phone',
        ]);
        $bank = new BankCardManagement();
        try {
            $bank->user_id = $this->getAuthId();
            $bank->card_name = $request->card_name;
            $bank->card_address = $request->card_address;
            $bank->card_address_2 = $request->card_address_2;
            $bank->others = $request->others;
            $bank->save();
        } catch (Exception $e) {
            return Response($e->getMessage());
        }
        $Result = [
            'BankCardManagement' => $bank,
        ];
        return $this->responseSuccess($Result);
    }
    public function changePassword (Request $request): Response {
        $request->validate([
            'new_password' => 'required|string|min:8|max:16',
        ]);
        #Update the Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        $Result = [
            'Message' => 'Success',
        ];
        return $this->responseSuccess($Result);
    }
    public function withdrawPassword (Request $request): Response {
        $request->validate([
            'withdraw_password' => 'required|string|min:4|max:4',
        ]);
        #Update the Password
        User::whereId(auth()->user()->id)->update([
            'withdraw_password' => Hash::make($request->withdraw_password)
        ]);
        $Result = [
            'Message' => 'Success',
        ];
        return $this->responseSuccess($Result);
    }
}
