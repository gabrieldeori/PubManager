<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class clientsController extends Controller
{
  public function getClients(Request $request)
  {
    $clients = Client::all();
    return response()->json($clients);
  }

  public function createClients(Request $request)
  {
    $clients = $request->all();

    foreach ($clients as $client) {
        Client::create([
            "name" => $client["name"],
        ]);
    }
    return response()->json($clients);
  }
}
