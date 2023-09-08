<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseResponseController;
use App\Models\NftProduct;
use App\Models\PurchasingProduct;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PurchasingProductController extends BaseResponseController
{
    public function __construct ()
    {
        $this->middleware('auth:api');
    }
    public function get(): Response {
        $purchases = PurchasingProduct::orderBy('created_at', 'desc')
            ->where('user_id', $this->getAuthId())
            ->get();
        $result = [
            'Message' => 'Success',
            'Purchases' =>$purchases,
        ];
        return $this->responseSuccess($result);
    }
    public function purchaseProduct(Request $request): Response {

        $request->validate([
            'product_id' => 'required',
            'nft_amount_pay' => 'required',
        ]);
        $product = NftProduct::where('id', $request->product_id)->first();
        try {
            $purchase = PurchasingProduct::where( 'nft_product_id', $product->id)->first();
            if ($purchase) {
                return $this->responseFail('You have already purchase this product!');
            } else {
                $purchase = PurchasingProduct::create([
                    'user_id' => $product->user_id,
                    'nft_product_id' => $product->id,
                    'nft_title' => $product->nft_title,
                    'nft_click' => $product->nft_click,
                    'nft_price' => $product->nft_price,
                    'nft_like' => $product->nft_like,
                    'nft_amount_pay' => $request->nft_amount_pay,
                    'nft_coin_type' => $product->nft_coin_type,
                    'nft_buy_date' => Carbon::now(),
                    'nft_status_process' => 'requested',
                    'nft_image' => $product->nft_image,
                ]);
            }
            $result = [
                'Message' => 'Success',
                'Purchase' =>$purchase,
            ];
            return $this->responseSuccess($result);
        } catch (Exception $e) {
            return Response($e->getMessage());
        }
    }
}
