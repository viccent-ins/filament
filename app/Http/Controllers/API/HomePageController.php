<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseResponseController;
use App\Models\SlideThumbnail;
use Illuminate\Http\Response;

class HomePageController extends BaseResponseController
{
    public function getSlide(): Response
    {
        $slides = SlideThumbnail::orderBy('created_at', 'desc')->get();
        $Result = [
            'Slides' => $slides,
        ];
        return $this->responseSuccess($Result);
    }
}
