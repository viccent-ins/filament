<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseResponseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Children;
use App\Models\BankCardManagement;
use App\Models\Deposit;
use App\Models\User;
use App\Models\UserRecharge;
use App\Models\Withdraw;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAccountController extends BaseResponseController
{
    public function __construct()
    {
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
            'deposit_amount' => 'required',
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
            'withdraw_amount' => 'required',
            'withdraw_bank' => 'required',
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
            'card_name' => 'required',
            'card_address' => 'required',
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

    public function changePassword(Request $request): Response
    {
        $request->validate([
            'new_password' => 'required|string|min:8|max:16',
        ]);
        #Update the Password
        User::whereId($this->getAuthId())->update([
            'password' => Hash::make($request->new_password)
        ]);
        $Result = [
            'Message' => 'Success',
        ];
        return $this->responseSuccess($Result);
    }
    public function withdrawPassword(Request $request): Response
    {
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
    public $arr = [];
    public function getChildren(): Response
    {
        $users = User::all();
        $children = new Children($users);
        $result = $children->getChildren($this->getAuthId(),true);
        $Result = [
            'Referral' => $result,
            'SumMoney' => $children->getSumMoney(),
            'TotalDeposit' => $children->getTotalDepositOrWithdraw($result, 'deposit'),
            'TotalWithdraw' => $children->getTotalDepositOrWithdraw($result, 'withdraw'),
            'TotalTeam' => count($result),
            'SystemId' => $this->getUser()->incode,
            'NewRegister' => count($children->getNewRegister()),
            'Activities' => count($children->getActivety()),
            'TeamTrading' => '',
            'Level' => count($this->buildTree($result, $this->getAuthId())),
            'Subordinates' => $this->buildTree($result, $this->getAuthId()),
        ];
        return $this->responseSuccess($Result);
    }
    protected function buildTree(array &$subordinates, $parentId) {

        $branch = [];
        foreach ($subordinates as &$subordinate) {
            if ($subordinate['pid'] == $parentId) {
                $children = $this->buildTree($subordinates, $subordinate['id']);
                if ($children) {
                    $subordinate['subordinates'] = $children;
                }
                $branch[] = $subordinate;
                unset($subordinate);
            }
        }

        return $branch;
    }
    public function getRecharge(): Response {
        try {
            $userRecharges = UserRecharge::orderBy('created_at', 'desc')
                ->where('user_id', $this->getAuthId())
                ->get();
        } catch (Exception $e) {
            return Response($e->getMessage());
        }
        $Result = [
            'Recharge' => $userRecharges,
        ];
        return $this->responseSuccess($Result);
    }
    public function userRecharge(Request $request): Response {
        $request->validate([
           'user_id' => 'required',
           'refusal_reason_remark' => 'required',
           'order_status' => 'required',
           'order_remark' => 'required',
           'order_creation_time' => 'required',
        ]);
        $recharge = new UserRecharge();
        try {
            $recharge->user_id = $this->getAuthId();
            $recharge->order_id = $request->order_id ?? null;
            $recharge->refusal_reason_remark = $request->refusal_reason_remark;
            $recharge->order_status = $request->order_status;
            $recharge->order_remark = $request->order_remark;
            $recharge->order_approval_time = $request->order_approval_time;
            $recharge->order_creation_time = $request->order_creation_time ?? '';
            $recharge->save();
        } catch (Exception $e) {
            return Response($e->getMessage());
        }
        $Result = [
            'Recharges' => $recharge,
        ];
        return $this->responseSuccess($Result);
    }
}


























