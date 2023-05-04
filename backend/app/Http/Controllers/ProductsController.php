<?php

namespace App\Http\Controllers;

use App\Helpers\Response_Handlers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Helpers\MSG;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Validation\ValidationException;

class ProductsController extends Controller
{
    public function getProducts()
    {
        try {
            $products = Product::all();

            if ($products->isEmpty()) {
                throw new ModelNotFoundException(MSG::PRODUCTS_TABLE_EMPTY);
            }

            $products = $products->map(function ($product) {
                $product->alcoholic = $product->alcoholic ? 'Sim' : 'Não';
                $product->preparable = $product->preparable ? 'Sim' : 'Não';
                return $product;
            });

            // rename products column to ptbr
            $productsRenamedColumns = collect([]);
            foreach ($products as $product) {
                $productsRenamedColumns->push([
                    'id' => $product->id,
                    'nome' => $product->name,
                    'Descrição' => $product->description,
                    'Alcoólico' => $product->alcoholic,
                    'Preparável' => $product->preparable,
                ]);
            }

            $response = Response_Handlers::setAndRespond(MSG::PRODUCTS_FOUND, ['products'=>$productsRenamedColumns]);
            return response()->json($response, MSG::OK);

        } catch (ModelNotFoundException $modelError) {
            $errors = ['errors' => ['generic' => $modelError->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PRODUCTS_NOT_FOUND, $errors);
            return response()->json($response, MSG::NOT_FOUND);

        } catch (\Exception $error) {
            $errors = ['errors' => ['generic' => $error->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PRODUCTS_NOT_FOUND, $errors);
            return response()->json($response, MSG::SERVER_ERROR);
        }
    }

    public function getProductsOptions() {
        try {
            $products = Product::all();

            if ($products->isEmpty()) {
                throw new ModelNotFoundException(MSG::PRODUCTS_TABLE_EMPTY);
            }

            $products = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                ];
            });

            $response = Response_Handlers::setAndRespond(MSG::PRODUCTS_FOUND, ['products'=>$products]);
            return response()->json($response, MSG::OK);

        } catch (ModelNotFoundException $modelError) {
            $errors = ['errors' => ['generic' => $modelError->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PRODUCTS_NOT_FOUND, $errors);
            return response()->json($response, MSG::NOT_FOUND);

        } catch (\Exception $error) {
            $errors = ['errors' => ['generic' => $error->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PRODUCTS_NOT_FOUND, $errors);
            return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
        }
    }

    public function getAProduct(Request $request) {
        try {
            $request->validate([
                'id' => 'required|integer',
            ], MSG::PRODUCT_VALIDATE);

            $product = Product::findOrFail($request->id);

            $product->alcoholic = $product->alcoholic ? 'Sim' : 'Não';
            $product->preparable = $product->preparable ? 'Sim' : 'Não';

            $response = Response_Handlers::setAndRespond(MSG::PRODUCT_FOUND, ['product'=>$product]);
            return response()->json($response, MSG::OK);

        } catch (ValidationException $validator) {
            $errors = ['errors' => ['validation' => $validator->errors()]];
            $response = Response_Handlers::setAndRespond(MSG::PRODUCT_NOT_FOUND, $errors);
            return response()->json($response, MSG::BAD_REQUEST);

        } catch (ModelNotFoundException $modelError) {
            $errors = ['errors' => ['generic' => $modelError->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PRODUCT_NOT_FOUND, $errors);
            return response()->json($response, MSG::NOT_FOUND);

        } catch (\Exception $error) {
            $errors = ['errors' => ['generic' => $error->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PRODUCT_NOT_FOUND, $errors);
            return response()->json($response, MSG::SERVER_ERROR);
        }
    }

    public function createProduct(Request $request) {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'alcoholic' => 'required|boolean',
                'preparable' => 'required|boolean',
            ], MSG::PRODUCT_VALIDATE);

            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'alcoholic' => $request->alcoholic,
                'preparable' => $request->preparable,
            ]);

            $response = Response_Handlers::setAndRespond(MSG::PRODUCT_CREATED, ['product'=>$product]);
            return response()->json($response, MSG::CREATED);

        } catch (ValidationException $validator) {
            $errors = ['errors' => ['validation' => $validator->errors()]];
            $response = Response_Handlers::setAndRespond(MSG::PRODUCT_NOT_CREATED, $errors);
            return response()->json($response, MSG::BAD_REQUEST);

        } catch (\Exception $error) {
            $errors = ['errors' => ['generic' => $error->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PRODUCT_NOT_CREATED, $errors);
            return response()->json($response, MSG::SERVER_ERROR);
        }
    }

    public function editAProduct(Request $request) {
        try {
            $request->validate(
                [
                    'id' => 'required|integer',
                    'name' => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'alcoholic' => 'required|boolean',
                    'preparable' => 'required|boolean',
                ],
                MSG::PRODUCT_VALIDATE
            );

            $product = Product::findOrFail($request->id);

            $product->name = $request->name;
            $product->description = $request->description;
            $product->alcoholic = $request->alcoholic;
            $product->preparable = $request->preparable;
            $product->save();

            $response = Response_Handlers::setAndRespond(MSG::PRODUCT_UPDATED, ['product'=>$product]);
            return response()->json($response, MSG::OK);

        } catch (ValidationException $validator) {
            $errors = $validator->errors();
            $response = Response_Handlers::setAndRespond(MSG::PRODUCT_NOT_UPDATED, $errors);
            return response()->json($response, MSG::BAD_REQUEST);

        } catch (ModelNotFoundException $modelError) {
            $errors = [
                'errors' => [
                    'generic' => MSG::PRODUCT_NOT_FOUND,
                    'specific' => $modelError->getMessage()
                ]
            ];
            $response = Response_Handlers::setAndRespond(MSG::PRODUCT_NOT_UPDATED, $errors);
            return response()->json($response, MSG::NOT_FOUND);

        } catch (\Exception $error) {
            $errors = ['errors' => ['generic' => $error->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PRODUCT_NOT_UPDATED, $errors);
            return response()->json($response, MSG::SERVER_ERROR);
        }
    }

    public function deleteAProduct(Request $request) {
        try {
            $request->validate([
                'id' => 'required|integer',
            ], MSG::PRODUCT_VALIDATE);
            $product = Product::findOrFail($request->id);
            $product->delete();

            $response = Response_Handlers::setAndRespond(MSG::PRODUCT_DELETED, ['product'=>$product]);
            return response()->json($response, MSG::OK);

        } catch (ValidationException $validator) {
            $errors = $validator->errors();
            $response = Response_Handlers::setAndRespond(MSG::PRODUCT_NOT_DELETED, $errors);
            return response()->json($response, MSG::BAD_REQUEST);

        } catch (ModelNotFoundException $modelError) {
            $errors = [
                'errors' => [
                    'generic' => MSG::PRODUCT_NOT_FOUND,
                    'specific' => $modelError->getMessage()
                ]
            ];
            $response = Response_Handlers::setAndRespond(MSG::PRODUCT_NOT_DELETED, $errors);
            return response()->json($response, MSG::NOT_FOUND);

        } catch (\Exception $error) {
            $errors = ['errors' => ['generic' => $error->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::PRODUCT_NOT_DELETED, $errors);
            return response()->json($response, MSG::SERVER_ERROR);
        }
    }
}
