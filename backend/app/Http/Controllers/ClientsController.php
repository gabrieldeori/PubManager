<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Helpers\Error_Handlers;
use App\Helpers\Response_Handlers;
use App\Helpers\ERR;

class clientsController extends Controller
{
  public function getClients(Request $request)
  {
    try {
        $clients = Client::all()->toArray();
        $response = Response_Handlers::setAndRespond(ERR::CLIENTS_FOUND, $clients);
        return response()->json($response);
    } catch (\Exception $e) {
        $error = $e->getMessage();
        Error_Handlers::logError(ERR::CLIENTS_NOT_FOUND, $error);
        $response = Response_Handlers::setAndRespond(ERR::CLIENTS_NOT_FOUND, ['error'=>$error]);
        return response()->json($response, ERR::NOT_FOUND);
    }
  }

  public function createClients(Request $request)
  {
    try {
        $clients = $request->all();

        foreach ($clients as $client)
        {
            Client::create([ "name" => $client["name"]]);
        }
        $response = Response_Handlers::setAndRespond(ERR::CLIENTS_CREATED);
        return response()->json($response, ERR::CREATED);
    } catch (\Exception $e) {
        $error = $e->getMessage();
        Error_Handlers::logError(ERR::CLIENTS_NOT_FOUND, $error);
        $response = Response_Handlers::setAndRespond(ERR::CLIENTS_NOT_FOUND, ['error'=>$error]);
        return response()->json($response, ERR::INTERNAL_SERVER_ERROR);
    }
  }

  public function deleteClients(Request $request)
  {
    try {
        $clientsIds = $request->all();
        Client::destroy($clientsIds);
        $response = Response_Handlers::setAndRespond(ERR::CLIENTS_DELETED);
        return response()->json($response, ERR::ACCEPTED);
    } catch (\Exception $e) {
        $error = $e->getMessage();
        Error_Handlers::logError(ERR::CLIENTS_NOT_FOUND, $error);
        $response = Response_Handlers::setAndRespond(ERR::CLIENTS_NOT_FOUND, ['error'=>$error]);
        return response()->json($response, ERR::INTERNAL_SERVER_ERROR);
    }
  }
}
