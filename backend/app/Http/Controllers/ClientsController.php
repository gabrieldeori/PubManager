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
    // Pegar request aqui
    $client = Client::create([
      'name' => 'John Doe',
    ]);
    return response()->json($client);
  }
}
