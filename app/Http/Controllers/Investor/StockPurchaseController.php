<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use App\Models\Investors\StockPurchase;
use Illuminate\Http\Request;
use Inertia\Inertia;


class StockPurchaseController extends Controller
{ 
    public function store(Request $request){
        $purchaseData = $request->only('date', 'platform_id', 'stock_id', 'quantity', 'rate', 'price', 'transaction_fee', 'note' );
        $purchaseData['user_id'] = auth()->user()->id;
        StockPurchase::create($purchaseData);
        return back();
    }

    public function purchaes(){
        return StockPurchase::get();
    }
}
