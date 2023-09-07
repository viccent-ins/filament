<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseResponseController;
use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LikeController extends BaseResponseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function getLike(): Response {
        $likes = Like::orderBy('created_at', 'desc')->get();
        $Result = [
            'Slides' => $likes,
        ];
        return $this->responseSuccess($Result);
    }
    public function storeLike(Request $request): Response {
        $request->validate([
           'nft_product_id' => 'required',
        ]);

        $like = Like::where([
            'user_id' => $this->getAuthId(),
            'nft_product_id' => $request->nft_product_id
        ])->first();
        if ($like) {
            $like->delete();
            $result = [
                'Message' => 'You have unliked the product',
            ];
        } else {
            $like = new Like();
            $like->user_id = $this->getAuthId();
            $like->nft_product_id = $request->nft_product_id;
            $like->save();
            $result = [
                'Message' => 'You have liked the product',
                'like' => $like->load('user'),
            ];
        }
        return $this->responseSuccess($result);
    }
}
