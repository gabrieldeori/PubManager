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

  public function createClient(Request $request)
  {
    $client = Client::create([
      'name' => $request->name,
    ]);
    return response()->json($client);
  }
}
