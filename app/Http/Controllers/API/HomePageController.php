<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseResponseController;
use App\Http\Controllers\Controller;
use App\Models\AnalogData;
use App\Models\CooperativeFilm;
use App\Models\QuestCorridor;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomePageController extends BaseResponseController
{
    public function getSlide(): Response
    {
        $slides = Slide::orderBy('created_at', 'desc')->get();
        $Result = [
            'Slides' => $slides,
        ];
        return $this->responseSuccess($Result);
    }
    public function getQuestCorridor(): Response
    {
        $QuestCorridors = QuestCorridor::orderBy('created_at', 'desc')->get();
        $Result = [
            'QuestCorridors' => $QuestCorridors,
        ];
        return $this->responseSuccess($Result);
    }
    public function getAnalogData(): Response
    {
        $analogData = AnalogData::orderBy('created_at', 'desc')->get();
        $Result = [
            'AnalogData' => $analogData,
        ];
        return $this->responseSuccess($Result);
    }
    public function getCooperatedFilm(): Response
    {
        $cooperatedFilm = CooperativeFilm::orderBy('created_at', 'desc')->get();
        $Result = [
            'CooperatedFilms' => $cooperatedFilm,
        ];
        return $this->responseSuccess($Result);
    }
}
