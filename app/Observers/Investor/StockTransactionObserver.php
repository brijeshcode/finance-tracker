<?php

namespace App\Observers\Investor;

use App\Models\Investors\StockHolding;
use App\Models\Investors\StockPortfolio;
use App\Models\Investors\StockTransaction;

class StockTransactionObserver
{
    public function created(StockTransaction $stockTransaction)
    {
        if($stockTransaction->is_buy){

            $stockHolding = StockHolding::create([
                'date' => $stockTransaction->date, 
                'stock_transaction_id'=> $stockTransaction->id, 
                'platform_id'=> $stockTransaction->platform_id, 
                'user_id' => $stockTransaction->user_id, 
                'stock_id' => $stockTransaction->stock_id, 
                'quantity' => $stockTransaction->quantity,
                'rate' => $stockTransaction->rate, 
                'price' => $stockTransaction->price, 
                'sold_quantity' => 0, 
                'long_termed' => true, 
                'sold_out' => false, 
                'is_reinvestment' => false, 
                'reinvestment_lable' => null, 
                'note' => $stockTransaction->note 
                
            ]);

            $this->updatePortfolio($stockTransaction->user_id, $stockTransaction->stock_id);
        }
    }


    public function updated(StockTransaction $stockTransaction)
    {
        if($stockTransaction->is_buy){
            $stockHolding = StockHolding::where('stock_transaction_id', $stockTransaction->id)->first();
            $stockHolding->update([
                'date' => $stockTransaction->date, 
                'stock_transaction_id'=> $stockTransaction->id, 
                'platform_id'=> $stockTransaction->platform_id, 
                'user_id' => $stockTransaction->user_id, 
                'stock_id' => $stockTransaction->stock_id, 
                'quantity' => $stockTransaction->quantity,
                'rate' => $stockTransaction->rate, 
                'price' => $stockTransaction->price, 
                'sold_quantity' => 0, 
                'long_termed' => true, 
                'sold_out' => false, 
                'is_reinvestment' => false, 
                'reinvestment_lable' => null, 
                'note' => $stockTransaction->note 
            ]);

            $this->updatePortfolio($stockTransaction->user_id, $stockTransaction->stock_id);
        }
    }

    public function updatePortfolio($userId, $stockId){
        $holdings = StockHolding::currentHoldings()->isStock($stockId)->user($userId)->get();
        
        if(!count($holdings)){
            info(" holdings Not found user-id: $userId and stock-id: $stockId" );
            return ;
        }
        $quantity = 0;
        $rate = 0;
        $price = 0;

        
        foreach($holdings as $hold){ 

            $rate = $hold->rate;
            $quantity += $hold->quantity;
            $price +=  $hold->quantity * $hold->rate;
        }

        StockPortfolio::updateOrCreate([
            'user_id' => $userId,
            'stock_id' => $stockId
        ], [
            'quantity' => $quantity,
            'running_avg_rate' => $rate,
            'invested_value' => $price,
            'long_term_quantities' => 0,
            
        ]);
    }
}
