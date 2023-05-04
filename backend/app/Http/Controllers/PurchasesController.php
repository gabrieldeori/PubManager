<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Helpers\Response_Handlers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Helpers\MSG;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\PurchasesProduct;
use App\Models\Product;
use App\Models\PurchaseProduct;
use App\Models\Unit;
use \Illuminate\Validation\ValidationException;

class PurchasesController extends Controller
{
    public function getPurchases() {
        try {
            $purchases = Purchase::with('products')
            ->get();

            if ($purchases->isEmpty()) {
                throw new ModelNotFoundException(MSG::PURCHASES_TABLE_EMPTY);
            }

            $processed = [];

            foreach ($purchases as $purchase) {
                $newPurchase = [
                    'id' => $purchase->id,
                    'Nome' => $purchase->name,
                    'Descrição' => $purchase->description,
                    'Preço Total' => $purchase->total_price,
                    'Produtos' => $purchase->products->map(function ($product) {
                        return $product->name . ': R$ ' . $product->pivot->individual_price . ' x' . $product->pivot->quantity . ' = R$ ' . $product->pivot->individual_price * $product->pivot->quantity;
                    })
                ];
                array_push($processed, $newPurchase);
            }

            $response = Response_Handlers::setAndRespond(MSG::PURCHASES_FOUND, ['purchases'=>$processed]);
            return response()->json($response, MSG::OK);

        } catch (ModelNotFoundException $modelError) {
            $errors = ['errors' => ['generic' => $modelError->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PURCHASES_NOT_FOUND, $errors);
            return response()->json($response, MSG::NOT_FOUND);

        } catch (\Exception $error) {
            $errors = ['errors' => ['generic' => $error->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PURCHASES_NOT_FOUND, $errors);
            return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
        }
    }

    public function getAPurchase(Request $request) {
        try {
            $request->validate([
                'id' => 'required|integer',
            ], MSG::PURCHASE_VALIDATE);

            $purchase = Purchase::with(['products' => function($query) {
                $query->select(
                    'products.id',
                    'products.name',
                    'products.description',
                    'purchase_products.quantity',
                    'purchase_products.individual_price'
                );
            }])
            ->findOrFail($request->id);


            // if (!$purchase) {
            //     throw new ModelNotFoundException(MSG::PURCHASE_NOT_FOUND);
            // }

            // $purchase->created_by = $purchase->createdBy->name;
            // $purchase->updated_by = $purchase->updatedBy->name;
            // $purchase->total_price = 'R$ ' . number_format($purchase->total_price, 2, ',', '.');
            // $purchase->products = $purchase->products->map(function ($product) {
            //     $product->pivot->individual_price = 'R$ ' . number_format($product->pivot->individual_price, 2, ',', '.');
            //     return $product;
            // });

            $response = Response_Handlers::setAndRespond(MSG::PURCHASE_FOUND, ['purchase' => $purchase]);
            return response()->json($response, MSG::OK);

        } catch (ModelNotFoundException $modelError) {
            $errors = ['errors' => ['generic' => $modelError->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PURCHASE_NOT_FOUND, $errors);
            return response()->json($response, MSG::NOT_FOUND);

        } catch (ValidationException $validator) {
            $errors = ['errors' => ['validation' => $validator->errors()]];
            $response = Response_Handlers::setAndRespond(MSG::PURCHASE_INVALID_FORMAT, $errors);
            return response()->json($response, MSG::UNPROCESSABLE_ENTITY);

        } catch (\Exception $error) {
            $errors = ['errors' => ['generic' => $error->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PURCHASE_NOT_FOUND, $errors);
            return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
        }
    }

    public function createPurchase(Request $request) {
        try {
            // $request->validate([
            //     'name' => 'required|string',
            //     'description' => 'required|string',
            //     'products' => 'required|array|min:1',
            //     'products.*.id' => 'required|integer',
            //     'products.*.quantity' => 'required|integer',
            //     'products.*.unit' => 'required|string',
            //     'products.*.individualPrice' => 'required|numeric',
            // ], MSG::PURCHASE_VALIDATE);

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

    public function editAPurchase(Request $request) {
        try {
            $request->validate([
                'id' => 'required|integer',
                'description' => 'required|string',
                'total_price' => 'required|numeric',
                'products' => 'required|array',
                'products.*.id' => 'required|integer',
                'products.*.quantity' => 'required|integer',
                'products.*.unit' => 'required|string',
                'products.*.individual_price' => 'required|numeric',
            ], MSG::PURCHASE_VALIDATE);

            $purchase = Purchase::find($request->id);

            if (!$purchase) {
                throw new ModelNotFoundException(MSG::PURCHASE_NOT_FOUND);
            }

            $purchase->description = $request->description;
            $purchase->total_price = $request->totalPrice;
            $purchase->save();

            $purchase->products()->detach();
            $purchase->products()->attach($request->products);

            $response = Response_Handlers::setAndRespond(MSG::PURCHASE_UPDATED, ['purchase'=>$purchase]);
            return response()->json($response, MSG::OK);

        } catch (ModelNotFoundException $modelError) {
            $errors = ['errors' => ['generic' => $modelError->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PURCHASE_NOT_FOUND, $errors);
            return response()->json($response, MSG::NOT_FOUND);

        } catch (ValidationException $validator) {
            $errors = ['errors' => ['validation' => $validator->errors()]];
            $response = Response_Handlers::setAndRespond(MSG::PURCHASE_INVALID_FORMAT, $errors);
            return response()->json($response, MSG::UNPROCESSABLE_ENTITY);

        } catch (\Exception $error) {
            $errors = ['errors' => ['generic' => $error->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PURCHASE_NOT_UPDATED, $errors);
            return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteAPurchase(Request $request) {
        try {
            $request->validate([
                'id' => 'required|integer',
            ], MSG::PURCHASE_VALIDATE);

            $purchase = Purchase::find($request->id);

            if (!$purchase) {
                throw new ModelNotFoundException(MSG::PURCHASE_NOT_FOUND);
            }

            $purchase->products()->detach();
            $purchase->delete();

            $response = Response_Handlers::setAndRespond(MSG::PURCHASE_DELETED, ['purchase'=>$purchase]);
            return response()->json($response, MSG::OK);

        } catch (ModelNotFoundException $modelError) {
            $errors = ['errors' => ['generic' => $modelError->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PURCHASE_NOT_FOUND, $errors);
            return response()->json($response, MSG::NOT_FOUND);

        } catch (ValidationException $validator) {
            $errors = ['errors' => ['validation' => $validator->errors()]];
            $response = Response_Handlers::setAndRespond(MSG::PURCHASE_INVALID_FORMAT, $errors);
            return response()->json($response, MSG::UNPROCESSABLE_ENTITY);

        } catch (\Exception $error) {
            $errors = ['errors' => ['generic' => $error->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PURCHASE_NOT_DELETED, $errors);
            return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
        }
    }
}
