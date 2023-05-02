<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    public function getProducts(Request $request)
    {
        $products = Product::all();
        return response()->json($products);
    }
}
