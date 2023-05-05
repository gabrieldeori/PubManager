<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Comanda;
use App\Helpers\MSG;
use App\Helpers\Response_Handlers;
use App\Models\CashRegister;

use Illuminate\Support\Facades\DB;

class CashRegisterController extends Controller
{
    public function createComandaEntry($comandaId)
    {
        try {
            $comanda = Comanda::findOrFail($comandaId);

            $cashRegister = new CashRegister([
                'name' => $comanda->name,
                'comanda_id' => $comanda->id,
                'movement' => 1,
            ]);

            $cashRegister->comanda()->associate($comanda);
            $cashRegister->save();

            return response()->json(MSG::CASH_REGISTER_CREATED, MSG::CREATED);

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

    public function createCashRegister() {
        try {
            $cashRegister = new CashRegister();
            $cashRegister->name = 'Caja 1';
            $cashRegister->movement = 0;
            $cashRegister->save();

            $response = Response_Handlers::setAndRespond(MSG::CASH_REGISTER_CREATED, ['cashRegister'=>$cashRegister]);
            return response()->json($response, MSG::CREATED);

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

    public function getCashRegister() {
        try {
            $cashRegister = CashRegister::all();

            $response = Response_Handlers::setAndRespond(MSG::CASH_REGISTER_FOUND, ['cashRegister'=>$cashRegister]);
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

    public function getCashRegisterToLeft() {
        try {
            $cashRegisters = CashRegister::select(
                'cash_registers.*',
                'purchases.total_price as purchase_total_price',
                'comandas.total_price as comanda_total_price'
            )
            ->leftJoin('purchases', 'cash_registers.purchase_id', '=', 'purchases.id')
            ->leftJoin('comandas', 'cash_registers.comanda_id', '=', 'comandas.id')
            ->get();

            $response = Response_Handlers::setAndRespond(MSG::CASH_REGISTER_FOUND, ['cashRegisters'=>$cashRegisters]);
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
}
