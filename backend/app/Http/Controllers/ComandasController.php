<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Comandas;
use App\Models\ComandaProduct;
use App\Helpers\MSG;
use App\Helpers\Response_Handlers;



class ComandasController extends Controller
{
    public function createComanda(Request $request) {
        try {
            $request->validate([
                'client' => 'required|integer|exists:clients,id',
                'name' => 'required|string',
                'description' => 'required|string',
                'products' => 'required|array|min:1',
                'products.*.id' => 'required|integer|exists:products,id',
                'products.*.quantity' => 'required|numeric',
                'products.*.individualPrice' => 'required|numeric',
            ], MSG::COMANDA_VALIDATE);

            $comanda = new Comandas();
            $comanda->client_id = $request->client;
            $comanda->name = $request->name;
            $comanda->description = $request->description;
            $comanda->total_price = 0;
            $comanda->save();

            foreach ($request->products as $product) {
                $comandaProduct = new ComandaProduct();
                $comandaProduct->comanda_id = $comanda->id;
                $comandaProduct->product_id = $product['id'];
                $comandaProduct->quantity = $product['quantity'];
                $comandaProduct->individual_price = $product['individualPrice'];
                $comandaProduct->save();

                $comanda->total_price += $product['individualPrice'] * $product['quantity'];
            }

            $comanda->save();

            $response = Response_Handlers::setAndRespond(MSG::COMANDA_CREATED, ['comanda'=>$comanda]);
            return response()->json($response, MSG::CREATED);

        } catch (ValidationException $validator) {
            $errors = ['errors' => ['validation' => $validator->errors()]];
            $response = Response_Handlers::setAndRespond(MSG::COMANDA_INVALID_FORMAT, $errors);
            return response()->json($response, MSG::UNPROCESSABLE_ENTITY);

        } catch (\Exception $error) {
            $errors = ['errors' => ['generic' => $error->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::COMANDA_NOT_CREATED, $errors);
            return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
        }
    }
}
