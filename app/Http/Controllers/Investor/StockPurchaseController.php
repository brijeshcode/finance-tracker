<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use App\Models\Investors\CurrentHolding;
use App\Models\Investors\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


class StockPurchaseController extends Controller
{ 
    public function store(Request $request)
    {
        DB::beginTransaction();
        $userId = auth()->user()->id;

        $transaction = StockTransaction::create([
            'user_id' => $userId,
            'platform_id' => $request->platform_id,
            'stock_id' => $request->stock_id,
            'type' => 'buy',
            'quantity' => $request->quantity,
            'price' => $request->rate,
            'total' => $request->quantity * $request->rate,
        ]);

        $holding = CurrentHolding::firstOrNew([
            'user_id' => $userId,
            'platform_id' => $request->platform_id,
            'stock_id' => $request->stock_id,
        ]);

        $holding->quantity += $request->quantity;
        $holding->average_price = ($holding->average_price * ($holding->quantity - $request->quantity) + $transaction->total) / $holding->quantity;
        $holding->current_value = $holding->average_price * $holding->quantity;
        $holding->save();
        
        DB::commit();
        return back();
    }

    public function purchaes(){
        return StockTransaction::get();
    }

    
}
