<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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
            $products = Product::select(
                'products.id',
                'products.name as nome',
                'products.description as Descrição',
                DB::raw("IF(products.alcoholic, 'Sim', 'Não') as Alcoólico"),
                DB::raw("IF(products.preparable, 'Sim', 'Não') as Preparável"),
                'created_by_user.name as Criado por',
                'updated_by_user.name as Atualizado por',
                'products.created_at as Criado em',
                'products.updated_at as Atualizado em',
            )
            ->leftJoin('users as created_by_user', 'created_by_user.id', '=', 'products.created_by')
            ->leftJoin('users as updated_by_user', 'updated_by_user.id', '=', 'products.updated_by')
            ->get();

            if ($products->isEmpty()) {
                throw new ModelNotFoundException(MSG::PRODUCTS_TABLE_EMPTY);
            }

            $response = Response_Handlers::setAndRespond(MSG::PRODUCTS_FOUND, ['products'=>$products]);
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
            return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
        }
    }
}
