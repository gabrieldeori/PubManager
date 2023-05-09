<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard;
use App\Models\CashRegister;

class DashboardController extends Controller
{
    public function getDashBoard()
    {
        $cashRegisters = CashRegister::select(
            'comandas.total_price as comanda_prices',
            'purchases.total_price as purchase_prices',
            'cash_registers.movement',
        )
        ->leftJoin('purchases', 'cash_registers.purchase_id', '=', 'purchases.id')
        ->leftJoin('comandas', 'cash_registers.comanda_id', '=', 'comandas.id')
        ->get();

        $totalIncome = 0;
        $totalOutcome = 0;

        foreach ($cashRegisters as $cashRegister)
        {
            if ($cashRegister->movement == 1) {
                $totalIncome += $cashRegister->comanda_prices;
            } else {
                $totalOutcome += $cashRegister->purchase_prices;
            }
        }

        $dashboard = Dashboard::firstOrNew();
        $dashboard->update([
            'total_income' => $totalIncome,
            'total_outcome' => $totalOutcome,
        ]);

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
        $dashboard = Dashboard::firstOrNew();

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
