<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseResponseController;
use App\Models\ArtCategory;
use App\Models\NftProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class NftProductController extends BaseResponseController
{
    public function getNftProduct(Request $request): Response {

        $nftProducts = NftProduct::where('art_id', $request->art_id)->get();
        $result = [
            'Message' => 'Success',
            'ArtLevels' =>$nftProducts,
        ];
        return $this->responseSuccess($result);
    }
}
