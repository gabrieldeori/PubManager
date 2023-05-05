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
                'cash_registers.name as Nome',
                'comandas.total_price as Total Comanda',
                'purchases.total_price as Total Compra',
                DB::raw("IF(cash_registers.movement, 'Entrada', 'Saída') as Movimento"),
                'cash_registers.updated_at as Atualizado em',
                'cash_registers.created_at as Criado em',
                'comandas.id as idComanda',
                'purchases.id as idCompra',
            )
            ->leftJoin('purchases', 'cash_registers.purchase_id', '=', 'purchases.id')
            ->leftJoin('comandas', 'cash_registers.comanda_id', '=', 'comandas.id')
            ->orderBy('cash_registers.updated_at', 'desc')->orderBy('cash_registers.created_at', 'desc')->get();

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
