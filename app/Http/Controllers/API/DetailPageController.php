<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseResponseController;
use App\Http\Controllers\Controller;
use App\Models\BlockbusterHistory;
use App\Models\Cast;
use App\Models\NewArrival;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DetailPageController extends BaseResponseController
{
    public function getNewArrival(): Response
    {
        $newArrivals = NewArrival::orderBy('created_at', 'desc')->get();
        $Result = [
            'NewArrivals' => $newArrivals,
        ];
        return $this->responseSuccess($Result);
    }
    public function getCast(): Response
    {
        $newCasts = Cast::orderBy('created_at', 'desc')->get();
        $Result = [
            'Casts' => $newCasts,
        ];
        return $this->responseSuccess($Result);
    }
    public function getBlockBusterHistory(): Response
    {
        $blockbusterHistory = BlockbusterHistory::orderBy('created_at', 'desc')->get();
        $Result = [
            'BlockbusterHistories' => $blockbusterHistory,
        ];
        return $this->responseSuccess($Result);
    }
    public function getInvestment(): Response
    {
        $investments = BlockbusterHistory::orderBy('created_at', 'desc')->get();
        $Result = [
            'Investments' => $investments,
        ];
        return $this->responseSuccess($Result);
    }
}
