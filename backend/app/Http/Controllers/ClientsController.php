<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\Client;
use App\Helpers\Error_Handlers;
use App\Helpers\Response_Handlers;
use App\Helpers\MSG;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class clientsController extends Controller
{
  public function getClients(Request $request)
  {
    try {
        $clients = Client::all()->toArray();
        if (count($clients) == 0) {
            throw new Exception(MSG::CLIENTS_NOT_FOUND);
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

  public function getClientsOptions(Request $request)
  {
    try {
        $clients = Client::orderBy('name')->get();

        if ($clients->isEmpty()) {
            throw new ModelNotFoundException(MSG::PRODUCTS_TABLE_EMPTY);
        }

        $clients = $clients->map(function ($client) {
            return [
                'id' => $client->id,
                'name' => $client->name,
            ];
        });

        if (count($clients) == 0) {
            throw new Exception(MSG::CLIENTS_NOT_FOUND);
        } else {
            $clients = Response_Handlers::setAndRespond(MSG::CLIENTS_FOUND, $clients->toArray());
        }
        return response()->json($clients);
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

  public function getAClient(Request $request)
  {
    try {
        $id = $request->all()['id'];
        $client = Client::find($id);
        if ($client == null) {
            $response = Response_Handlers::setAndRespond(MSG::CLIENT_NOT_FOUND);
            return response()->json($response, MSG::NOT_FOUND);
        }
        $response = Response_Handlers::setAndRespond(MSG::CLIENTS_FOUND, ['client' => $client]);
        return response()->json($response);
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
        if (count($clients) == 0 || !isset($clients[0])) {
            $response = Response_Handlers::setAndRespond(MSG::CLIENTS_NOT_CREATED);
            return response()->json($response, MSG::BAD_REQUEST);
        }

        foreach ($clients as $client)
        {
            if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $client["name"])) {
                $response = Response_Handlers::setAndRespond(MSG::CLIENTS_INVALID_FORMAT);
                return response()->json($response, MSG::BAD_REQUEST);
            }
        }


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
        $toUpdate = $request->all();
        $client = Client::find($toUpdate['id']);
        if ($client == null) {
            $response = Response_Handlers::setAndRespond(MSG::CLIENT_NOT_FOUND);
            return response()->json($response, MSG::NOT_FOUND);
        }
        $client->name = $toUpdate['name'];
        $client->save();
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
?>
