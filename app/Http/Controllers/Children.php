<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class Children
{
    public $arr = [];

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

    public function init($arr = [])
    {
        $this->arr = $arr;
        return $this;
    }

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
}
