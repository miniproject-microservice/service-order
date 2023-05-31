<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Xendit\Xendit;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function pay ($id, Request $request) {
        Xendit::setApiKey('xnd_development_xwi8Wzm7o0KA1yJG7NiZflbrAytDrpyVIAqGs95fjWzgqKSNdBQYRDBunNp19');
        // $validator = Validator::make($request->all(), [
        //     'product_id' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }

        $getProduct = Product::where('id', $id)->first();
        if ($getProduct == NULL) {
            return response()->json(["error" => true,"message" => "Product not found"]);
        }

        $params = [
            'external_id' => Str::random(8),
            'amount' => $getProduct->price,
            'description' => 'sdds',
            'success_redirect_url' => URL::to('/'),
            'items' => [
                [
                    'name' => $getProduct->name,
                    'quantity' => 1,
                    'price' => $getProduct->price,
                ]
            ],
        ];

        $createInvoice = \Xendit\Invoice::create($params);
        $link = 'https://checkout-staging.xendit.co/web/' . $createInvoice['id'];
        return response()->json(['link' => $link]);

    }
}
