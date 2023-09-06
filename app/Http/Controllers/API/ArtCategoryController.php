<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseResponseController;
use App\Models\ArtCategory;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ArtCategoryController extends BaseResponseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function getArt(): Response {
        $artsLevel = ArtCategory::all();
        $result = [
            'Message' => 'Success',
            'ArtLevels' =>$artsLevel,
        ];
        return $this->responseSuccess($result);
    }
}
