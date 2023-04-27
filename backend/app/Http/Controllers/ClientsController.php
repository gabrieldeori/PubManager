<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Helpers\Error_Handlers;
use App\Helpers\Response_Handlers;
use App\Helpers\MSG;

class clientsController extends Controller
{
  public function getClients(Request $request)
  {
    try {
        $clients = Client::all()->toArray();
        if (count($clients) == 0) {
            $clients = Response_Handlers::setAndRespond(MSG::CLIENTS_NOT_FOUND, $clients);
        } else {
            $clients = Response_Handlers::setAndRespond(MSG::CLIENTS_FOUND, $clients);
        }
        return response()->json($clients);
    } catch (\Exception $e) {
        $error = $e->getMessage();
        Error_Handlers::logError(MSG::SERVER_ERROR, $error);
        $response = Response_Handlers::setAndRespond(MSG::SERVER_ERROR, ['error'=>$error]);
        return response()->json($response, MSG::NOT_FOUND);
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
        $response = Response_Handlers::setAndRespond(MSG::CLIENTS_CREATED);
        return response()->json($response, MSG::CREATED);
    } catch (\Exception $e) {
        $error = $e->getMessage();
        Error_Handlers::logError(MSG::SERVER_ERROR, $error);
        $response = Response_Handlers::setAndRespond(MSG::SERVER_ERROR, ['error'=>$error]);
        return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
    }
  }

  public function editAClient(Request $request)
  {
    try {
        $client = Client::find($request->id);
        if ($client == null) {
            $response = Response_Handlers::setAndRespond(MSG::CLIENT_NOT_FOUND);
            return response()->json($response, MSG::NOT_FOUND);
        }
        $client->update($request->all());
        $response = Response_Handlers::setAndRespond(MSG::CLIENT_UPDATED);
        return response()->json($response, MSG::ACCEPTED);
    } catch (\Exception $e) {
        $error = $e->getMessage();
        Error_Handlers::logError(MSG::SERVER_ERROR, $error);
        $response = Response_Handlers::setAndRespond(MSG::SERVER_ERROR, ['error'=>$error]);
        return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
    }
  }

    public function deleteAClient(Request $request)
    {
        try {
            $client = Client::find($request->id);
            if ($client == null) {
                $response = Response_Handlers::setAndRespond(MSG::CLIENT_NOT_FOUND);
                return response()->json($response, MSG::NOT_FOUND);
            }
            $client->delete();
            $response = Response_Handlers::setAndRespond(MSG::CLIENTS_DELETED);
            return response()->json($response, MSG::ACCEPTED);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            Error_Handlers::logError(MSG::SERVER_ERROR, $error);
            $response = Response_Handlers::setAndRespond(MSG::SERVER_ERROR, ['error'=>$error]);
            return response()->json($response, MSG::INTERNAL_SERVER_ERROR);
        }
    }
}
