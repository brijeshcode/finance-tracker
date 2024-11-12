<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use App\Models\Investors\CurrentHolding;
use App\Models\INvestors\StockPartialSale;
use App\Models\Investors\StockPurchase;
use App\Models\Investors\StockSale;
use App\Models\Investors\StockSalePurchaseLink;
use App\Models\Investors\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


class StockSalesController extends Controller
{ 

    public function store(Request $request)
    {
        $userId = auth()->user()->id;
        $platformId = $request->platform_id;
        $stockId = $request->stock_id;
        $quantityToSell = $request->quantity;
        $sellRate = $request->rate;

        $this->sellStock($userId, $platformId, $stockId, $quantityToSell, $sellRate);
        return back();
        // return back()->json(['message' => 'Stock sold successfully']);
    } 


    private function sellStock($userId, $platformId, $stockId, $quantityToSell, $sellRate)
    {
        DB::beginTransaction();
    
        try {
            $purchases = $this->getAvailablePurchases($userId, $platformId, $stockId);
    
            // Check if the user has enough stock to sell
            $totalAvailableQuantity = $purchases->sum('available_quantity');
            if ($totalAvailableQuantity < $quantityToSell) {
                throw new \Exception('Not enough stock to sell');
            }
    
            $quantityRemaining = $quantityToSell;
            $sales = [];
    
            foreach ($purchases as $purchase) {
                if ($quantityRemaining <= 0) {
                    break;
                }
    
                if ($quantityRemaining >= $purchase->available_quantity) {
                    // Sell the entire available quantity from the purchase
                    $profit = ($sellRate - $purchase->price) * $purchase->available_quantity;
                    $sales[] = [
                        'purchase_id' => $purchase->id,
                        'quantity' => $purchase->available_quantity,
                        'profit_amount' => $profit
                    ];
                    $quantityRemaining -= $purchase->available_quantity;
                } else {
                    // Sell part of the available quantity from the purchase
                    $profit = ($sellRate - $purchase->price) * $quantityRemaining;
                    $sales[] = [
                        'purchase_id' => $purchase->id,
                        'quantity' => $quantityRemaining,
                        'profit_amount' => $profit
                    ];
                    $quantityRemaining = 0;
                }
            }
    
            // Record the sale transaction
            $saleTransaction = StockTransaction::create([
                'user_id' => $userId,
                'platform_id' => $platformId,
                'stock_id' => $stockId,
                'type' => 'sell',
                'quantity' => $quantityToSell,
                'price' => $sellRate,
                'total' => $quantityToSell * $sellRate
            ]);
    
            // Record the links between the sale and the purchases
            foreach ($sales as $sale) {
                StockSalePurchaseLink::create([
                    'sale_id' => $saleTransaction->id,
                    'purchase_id' => $sale['purchase_id'],
                    'quantity' => $sale['quantity'],
                    'profit_amount' => $sale['profit_amount']
                ]);
            }


            // Update the current holdings
            $this->updateCurrentHolding($userId, $platformId, $stockId, $quantityToSell);
    
            DB::commit();
    
            return 'Stock sold successfully';
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Updates the current holding for a given user, platform, and stock by reducing the quantity
     * by the specified amount to sell. If the quantity becomes zero, the average price is reset to zero.
     * Otherwise, recalculates the average price based on the remaining quantity.
     *
     * @param int $userId The ID of the user.
     * @param int $platformId The ID of the platform.
     * @param int $stockId The ID of the stock.
     * @param int $quantityToSell The quantity of stock to sell.
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If no current holding is found.
     */

    private function updateCurrentHolding($userId, $platformId, $stockId, $quantityToSell) {

        $currentHolding = CurrentHolding::where('user_id', $userId)
        ->where('platform_id', $platformId)
        ->where('stock_id', $stockId)
        ->firstOrFail();

        $currentHolding->quantity -= $quantityToSell;

        if ($currentHolding->quantity == 0) {
            $currentHolding->average_price = 0;
            $currentHolding->current_value = 0;
        } else {
            // Calculate new average price if quantity remains
            $currentHolding->average_price = $this->calculateNewAveragePrice($userId, $platformId, $stockId);
            $currentHolding->current_value = $currentHolding->average_price * $currentHolding->quantity;
        }

        $currentHolding->save();

    }

    /**
     * Returns all purchases of the given stock on the given platform made by the given user, 
     * sorted by the oldest first. The quantity of each purchase is adjusted by subtracting 
     * the quantity sold from the purchase from previous sales.
     * 
     * @param int $userId The ID of the user.
     * @param int $platformId The ID of the platform.
     * @param int $stockId The ID of the stock.
     * 
     * @return Illuminate\Database\Eloquent\Collection A collection of purchases with adjusted quantities.
     */
    private function getAvailablePurchases($userId, $platformId, $stockId)
    {
        // Fetch all purchases sorted by the oldest first
        $purchases = StockTransaction::where('user_id', $userId)
            ->where('platform_id', $platformId)
            ->where('stock_id', $stockId)
            ->where('type', 'buy')
            ->orderBy('created_at', 'asc')
            ->get();

        // Adjust the purchase quantities based on previous sales
        foreach ($purchases as $purchase) {
            $soldQuantity = StockSalePurchaseLink::where('purchase_id', $purchase->id)->sum('quantity');
            $purchase->available_quantity = $purchase->quantity - $soldQuantity;
        }
        
        return $purchases;
    }

    /**
     * Calculates the new average price for a stock on a platform after a sale has been made.
     * 
     * The average price is calculated by summing up the cost of all remaining purchases
     * and dividing it by the total quantity.
     * 
     * @param int $userId The ID of the user.
     * @param int $platformId The ID of the platform.
     * @param int $stockId The ID of the stock.
     * 
     * @return float The new average price.
     */
    private function calculateNewAveragePrice($userId, $platformId, $stockId)
    {
        // Recalculate average price based on remaining purchases
        $purchases = $this->getAvailablePurchases($userId, $platformId, $stockId);
        $totalQuantity = $purchases->sum('available_quantity');
        $totalCost = $purchases->sum(function ($purchase) {
            return $purchase->available_quantity * $purchase->price;
        });

        return $totalCost / $totalQuantity;
    }
} 