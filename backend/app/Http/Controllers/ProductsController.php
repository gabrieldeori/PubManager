<?php

namespace App\Http\Controllers;

use App\Helpers\Response_Handlers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Helpers\MSG;

class ProductsController extends Controller
{
    public function getProducts(Request $request)
    {
        $products = Product::all()->toArray();
        if (count($products) == 0) {
            $response = Response_Handlers::setAndRespond(MSG::PRODUCTS_NOT_FOUND);
            return response()->json($response, MSG::NOT_FOUND);
        }
        $response = Response_Handlers::setAndRespond(MSG::PRODUCTS_FOUND , $products);
        return response()->json($response, MSG::OK);
    }
}
