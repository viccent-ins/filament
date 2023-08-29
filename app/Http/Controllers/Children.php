<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class Children extends BaseResponseController
{
    public $arr = [];
    public function __construct($arrays = [])
    {
        $this->arr = $arrays;
    }
    public function getChildren($myid, $withself = false)
    {
        $newarr = [];
        foreach ($this->arr as $value) {
            if (!isset($value['id'])) {
                continue;
            }
            if ((string)$value['pid'] == (string)$myid) {
                $newarr[] = $value;
                $newarr = array_merge($newarr, $this->getChildren($value['id']));
            } elseif ($withself && (string)$value['id'] == (string)$myid) {
                $newarr[] = $value;
            }
        }
        return $newarr;
    }
//    public function init($arr = [])
//    {
//        $this->arr = $arr;
//        return $this;
//    }
    public function getSumMoney()
    {
        return $this->arr->sum('money');
    }
    public function getTotalDepositOrWithdraw($result = [], $cash = '')
    {
        try {
            $depositsOrWithdraw = [];
            foreach ($result as $k => $value) {
                $data = DB::table('balances')
                    ->where([
                        'user_id' => $value->id,
                        'type' => $cash
                    ])->get();
                $obj = get_object_vars($value);
                $depositsOrWithdraw[] = $obj;
                $depositsOrWithdraw[$k]['balances'] = $data;

            }
            $total_balance = 0;
            foreach ($depositsOrWithdraw as $total_deposit) {
                $total_balance += $total_deposit['balances']->sum('latest_balance');
            }
        } catch (\Exception $e) {
            // do task when error
            echo $e->getMessage();   // insert query
            return $e->getMessage();
        }

        return $total_balance;
    }
    public function getNewRegister() {
        try {
            $data = [];
            foreach ($this->arr as $k => $value) {
                $data[] = $value;
                $data[$k]['joindate'] = explode(' ', $value->created_at)[0];
            }
            $currentTime = Carbon::now()->toDateString();
            $filterData = collect($data)->where('joindate', $currentTime)->all();
        } catch (\Exception $e) {
            // do task when error
            return $e->getMessage();
        }
        return ($filterData);
    }
    public function getActivety() {
        try {
            $currentTime = Carbon::now()->toDateString();
            $filterData = collect($this->arr)->where('login_time', $currentTime)->all();
        } catch (\Exception $e) {
            // do task when error
            return $e->getMessage();
        }
        return ($filterData);
    }
}
