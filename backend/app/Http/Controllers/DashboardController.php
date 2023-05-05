<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard;

class DashboardController extends Controller
{
    public function getDashBoard()
    {
        $dashboard = Dashboard::first();
        return response()->json([
            'message' => 'Encontrado',
            'payload' => [
                'dashboard' => $dashboard,
            ],
        ]);
    }

    // Abaixo não seria necessário já que é feito no Model do CashRegister
    public function update(Request $request)
    {
        $dashboard = Dashboard::first();

        if ($request->has('purchase_id')) {
            $totalOutcome = $dashboard->total_outcome + $request->total;
            $dashboard->update(['total_outcome' => $totalOutcome]);
        }

        if ($request->has('comanda_id')) {
            $totalIncome = $dashboard->total_income + $request->total;
            $dashboard->update(['total_income' => $totalIncome]);
        }

        return redirect()->route('dashboard.index');
    }
}
