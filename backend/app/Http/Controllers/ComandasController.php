<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Comandas;
use App\Models\ComandaProduct;
use App\Helpers\MSG;



class ComandasController extends Controller
{
    public function createPurchase(Request $request) {
        try {
            $request->validate([
                'client' => 'required|integer|exists:clients,id',
                'name' => 'required|string',
                'description' => 'required|string',
                'products' => 'required|array|min:1',
                'products.*.id' => 'required|integer|exists:products,id',
                'products.*.quantity' => 'required|numeric',
                'products.*.individualPrice' => 'required|numeric',
            ], MSG::PURCHASE_VALIDATE);

            $purchase = new Comandas();
            $purchase->client_id = $request->client;
            $purchase->name = $request->name;
            $purchase->description = $request->description;
            $purchase->total_price = 0;
            $purchase->save(); // salva a compra e atribui um ID

            foreach ($request->products as $product) {
                $comandaProduct = new ComandaProduct();
                $comandaProduct->purchase_id = $purchase->id;
                $comandaProduct->product_id = $product['id'];
                $comandaProduct->quantity = $product['quantity'];
                $comandaProduct->individual_price = $product['individualPrice'];
                $comandaProduct->save();

                $purchase->total_price += $product['individualPrice'] * $product['quantity'];
            }

            $purchase->save(); // atualiza o total_price da compra

            $response = Response_Handlers::setAndRespond(MSG::PURCHASE_CREATED, ['purchase'=>$purchase]);
            return response()->json($response, MSG::CREATED);

        } catch (ValidationException $validator) {
            $errors = ['errors' => ['validation' => $validator->errors()]];
            $response = Response_Handlers::setAndRespond(MSG::PURCHASE_INVALID_FORMAT, $errors);
            return response()->json($response, MSG::UNPROCESSABLE_ENTITY);

        } catch (\Exception $error) {
            $errors = ['errors' => ['generic' => $error->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PURCHASE_NOT_CREATED, $errors);
            return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
        }
    }
}
