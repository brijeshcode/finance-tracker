<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use App\Models\INvestors\StockPartialSale;
use App\Models\Investors\StockPurchase;
use App\Models\Investors\StockSale;
use Illuminate\Http\Request;
use Inertia\Inertia;


class StockSalesController extends Controller
{ 
    public function store(Request $request){
        $saleData = $request->only('date', 'platform_id', 'stock_id', 'quantity', 'rate', 'price', 'transaction_fee', 'note' );
        $saleData['user_id'] = auth()->user()->id;

        $sale = StockSale::create($saleData);
        $this->updateSaleDataToPurchaseTable($sale);
        return back();
    }

    public function updateSaleDataToPurchaseTable(StockSale $sale)
    {
        
        $saleQuantity = $sale->quantity;
        $update = [
            'sale_id' => $sale->id,
            'sale_rate' => $sale->rate,
            'partial_sale_quantity' => 0,
            'profit_on_sale' => 0,
        ];

        $purchases = StockPurchase::currentStock()
            ->includePartial()
            ->isStock($sale->stock_id)
            ->isPlatform($sale->platform_id)
            ->orderBy('date', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        foreach($purchases as $purchase ){
            if($saleQuantity <= 0 ) break;

            $update['profit_on_sale'] = 0;
            if(($purchase->quantity - ($purchase->partial_sale_quantity + $saleQuantity)) <= 0){
                
                // normal flow.
                $buyQty = $purchase->quantity;
                $update['partial_sale_quantity'] = 0;
                if($purchase->partial_sale_quantity > 0){
                    $buyQty = $purchase->quantity - $purchase->partial_sale_quantity; 
                    $update['profit_on_sale'] +=  $purchase->profit_on_sale ;
                }
                $update['profit_on_sale'] += ($buyQty * $sale->rate) - ($buyQty * $purchase->rate) ;
                $saleQuantity -= $buyQty;
            }else{
                
                $netProfit = ($saleQuantity * $sale->rate) - ($saleQuantity * $purchase->rate) ;
                $update['profit_on_sale'] = $purchase->profit_on_sale + $netProfit;
                $update['partial_sale_quantity']  = $purchase->partial_sale_quantity + $saleQuantity;
                // update partial sales data
                StockPartialSale::create([
                    'purchase_id' => $purchase->id,
                    'sale_id' => $sale->id,
                    'date' => $sale->date,
                    'quantity' => $saleQuantity,
                    'rate' => $sale->rate,
                    'profit_on_sale' => $netProfit,
                ]);
                $saleQuantity -= $purchase->quantity;
            }
            $purchase->update($update);
        }
    }
} 