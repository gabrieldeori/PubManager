<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Utils\MSG;
use App\Utils\Response_Handlers;



class ComandasController extends Controller
{
    public function createPurchase(Request $request) {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'products' => 'required|array|min:1',
                'products.*.id' => 'required|integer',
                'products.*.quantity' => 'required|numeric',
                'products.*.individualPrice' => 'required|numeric',
            ], MSG::PURCHASE_VALIDATE);

            $purchase = new Purchase();
            $purchase->name = $request->name;
            $purchase->description = $request->description;
            $purchase->total_price = 0;
            $purchase->save(); // salva a compra e atribui um ID

            foreach ($request->products as $product) {
                $purchaseProduct = new PurchaseProduct();
                $purchaseProduct->purchase_id = $purchase->id;
                $purchaseProduct->product_id = $product['id'];
                $purchaseProduct->quantity = $product['quantity'];
                $purchaseProduct->individual_price = $product['individualPrice'];
                $purchaseProduct->save();

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
