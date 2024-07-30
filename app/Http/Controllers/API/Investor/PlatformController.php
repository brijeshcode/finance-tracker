<?php

namespace App\Http\Controllers\API\Investor;

use App\Http\Controllers\Controller;
use App\Models\Admin\Platform;
use App\Models\Admin\Stock;
use App\Models\Investors\StockHolding;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    public function platfroms(){
        return Platform::get(['id','name']);
    }

    public function stocks(){
        return  Stock::active()->get(['id','name']);
    }

    public function userStockQuantity($platformId, $stockId){
        $userId = auth()->user()->id;
        return StockHolding::user($userId)->isPlatform($platformId)->isStock($stockId)->currentHoldings()->orderBy('date', 'desc')->get(['quantity']);
    }
}
