<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseResponseController;
use App\Http\Controllers\FileHelperController;
use App\Models\Like;
use App\Models\NftProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class NftProductController extends BaseResponseController
{
    public function __construct()
    {
        $this->Helper = new FileHelperController();
        $this->middleware('auth:api');
    }

    public function getNftProduct(Request $request): Response {

        $nftProducts = NftProduct::where([
            'art_id' => $request->art_id,
            'is_transfer' => 0,
        ])->get();
        $nftProductsIncludeLikes = [];
        foreach ($nftProducts as $k => $value) {
            $data = DB::table('likes')->where('nft_product_id', $value->id)->get();
            $obj = $value;
            $nftProductsIncludeLikes[] = $obj;
            $nftProductsIncludeLikes[$k]['likes'] = count($data);

        }
        $result = [
            'Message' => 'Success',
            'NftProducts' =>$nftProductsIncludeLikes,
        ];
        return $this->responseSuccess($result);
    }
    public function postNftProduct(Request $request): Response {

        $request->validate([
           'art_id' => 'required',
           'user_id' => 'required',
           'nft_title' => 'required',
           'nft_price' => 'required',
           'nft_coin_type' => 'required',
           'nft_image' => 'required'
        ]);
        $nftPos = new NftProduct();
        try {
            $image = $request->nft_image;
            if ($image) {
                $address = $this->Helper->fileUpload($image, 'assets/product/');
                $nftPos->nft_image = $address;
            }
            $nftPos->art_id = $request->art_id;
            $nftPos->user_id = $request->user_id;
            $nftPos->nft_title = $request->nft_title;
            $nftPos->nft_price = $request->nft_price;
            $nftPos->nft_coin_type = $request->nft_coin_type;
            $nftPos->save();
        } catch (Exception $e) {
            return Response($e->getMessage());
        }
        $result = [
            'Message' => 'Success',
            'NftPost' =>$nftPos,
        ];
        return $this->responseSuccess($result);
    }
}
