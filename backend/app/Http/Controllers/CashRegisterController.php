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

class CashRegisterController extends Controller
{
    public function createComandaEntry($comandaId)
    {
        try {
            $comanda = Comanda::select('id', 'name', 'description', 'total_price')->findOrFail($comandaId);

            $cashRegister = new CashRegister([
                'name' => $comanda->name,
                'movement' => 1,
            ]);

            $cashRegister->comanda()->associate($comanda);
            $cashRegister->save();

        } catch (\Exception $error) {
            $errors = ['errors' => ['generic' => $error->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::CASH_REGISTER_NOT_CREATED, $errors);
            return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
        }
    }

    public function getCashRegister() {
        try {
            $cashRegister = CashRegister::with('comanda')->get();

            $response = Response_Handlers::setAndRespond(MSG::CASH_REGISTER_FOUND, ['cashRegister'=>$cashRegister]);
            return response()->json($response, MSG::OK);

        } catch (\Exception $error) {
            $errors = ['errors' => ['generic' => $error->getMessage()]];
            $response = Response_Handlers::setAndRespond(MSG::CASH_REGISTER_NOT_FOUND, $errors);
            return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
        }
    }
}
