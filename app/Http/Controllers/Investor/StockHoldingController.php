<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use App\Models\Investors\InvestorPlatform;
use App\Models\Investors\StockHolding;
use App\Models\Investors\StockPortfolio;
use App\Models\Investors\StockPurchase;
use App\Models\Investors\StockSale;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StockHoldingController extends Controller
{
    protected $files = [
        'index' => 'Investor/StockHoldings/Index',
        'holding' => 'Investor/StockHoldings/Index',
        'portfolio' => 'Investor/StockHoldings/portfolio',
        'create' => 'Investor/StockHoldings/Create',
        'show' => 'Investor/StockHoldings/Show',

    ];

    protected $routes = [
        'index' => 'investors.stocks.holdings',
    ];

    public function portfolio()
    {
        $investor = auth()->user(); 
        $purchases = StockPurchase::user($investor->id)->CurrentStock()->includePartial()->with('stock:id,name,symbol')->get([
            'user_id', 'stock_id', 'quantity', 'rate', 'price', 'sale_id', 'partial_sale_quantity', 'profit_on_sale'
        ])->groupBy('stock_id');
        $portfolio =  $purchases->map(function ($stock, $stockId) { 
            return [
                'stock_id' => $stockId,
                'name' => $stock->first()->stock->name,
                'symbol' => $stock->first()->stock->symbol,
                'quantity' => $stock->sum('quantity') - $stock->sum('partial_sale_quantity'),
                'price' => round($stock->sum('price'), 2),
                'rate' => round($stock->avg('rate'), 2)
            ];
        });
         
        $totalInvesteValue = $portfolio->sum('price');
        $companies = $portfolio->count('stock_id');
        return Inertia::render($this->files['portfolio'], compact('portfolio', 'totalInvesteValue', 'companies')); 
    }
    
    /**
     * Display a holdings base on platform.
     */
    public function holdings()
    {
        $investor = auth()->user();
        $holdings = $this->holdingsByPlatform($investor->id);
        
        $investorPlatforms = InvestorPlatform::with('platform:id,name')->isInvestor($investor->id)->get(['id', 'user_id', 'platform_id']);
        return Inertia::render($this->files['holding'], compact('investorPlatforms', 'holdings')); 
    }
    
    public function holdingsByPlatform($investorId){

        $purchases = StockPurchase::where('user_id', $investorId)->CurrentStock()->includePartial()->with('stock:id,name,symbol')->get()->groupBy('platform_id');
        $purchaseData =  $purchases->map(function ($platformStocks, $platformId) {
            return $platformStocks->groupBy('stock_id')->map(function ($stock, $stockId){
                return [
                    'stock_id' => $stockId,
                    'name' => $stock->first()->stock->name,
                    'symbol' => $stock->first()->stock->symbol,
                    'quantity' => $stock->sum('quantity') - $stock->sum('partial_sale_quantity'),
                    'price' => round($stock->sum('price'), 2),
                    'rate' => round($stock->avg('rate'), 2)
                ];
            });
        });
        
        return $purchaseData;
    }

    public function holdingsByPlatform1($investorId){
        $purchases = StockPurchase::where('user_id', $investorId)->with('stock:id,name,symbol')->get()->groupBy('platform_id');
        $sales = StockSale::where('user_id', $investorId)->get()->groupBy('platform_id');
        $purchaseData =  $purchases->map(function ($platformStocks, $platformId) {
            return $platformStocks->groupBy('stock_id')->map(function ($stock, $stockId){
                return [
                    'stock_id' => $stockId,
                    'name' => $stock->first()->stock->name,
                    'symbol' => $stock->first()->stock->symbol,
                    'quantity' => $stock->sum('quantity'),
                    'price' => round($stock->sum('price'), 2),
                    'rate' => round($stock->avg('rate'), 2)
                ];
            });
        });
        
         

        $saleData = $sales->map(function ($platformStocks, $platformId) {
            return $platformStocks->groupBy('stock_id')->map(function ($stock, $stockId){
                return [
                    'stock_id' => $stockId,
                    'name' => $stock->first()->stock->name,
                    'symbol' => $stock->first()->stock->symbol,
                    'quantity' => $stock->sum('quantity'),
                    'price' => round($stock->sum('price'), 2),
                    'rate' => round($stock->avg('rate'), 2)
                ];
            });
        });

        $holdings = array();
        foreach($purchaseData as $platformId => $platforms){
            $holdings[$platformId] = $platforms->toArray();
            foreach($platforms as $stockId => $stock ){
                if(isset($saleData[$platformId]) && isset($saleData[$platformId][$stockId])) {
                    $holdings[$platformId][$stockId]['quantity'] -= $saleData[$platformId][$stockId]['quantity']; 
                }
            }
        }
        return $holdings;

    }

    private function holdingsByPlatformOld($userId){
        $stockHoldings = StockHolding::with('stock:id,name,symbol')->user($userId)->get()->groupBy('platform_id');
        return $stockHoldings->map(function ($platformStocks, $platformId) {
            // return [$platformStocks, $platform_id];
            return $platformStocks->groupBy('stock_id')->map(function ($stock, $stockId){
                return [
                    'stock_id' => $stockId,
                    'name' => $stock->first()->stock->name,
                    'symbol' => $stock->first()->stock->symbol,
                    'quantity' => $stock->sum('quantity'),
                    'price' => $stock->sum('price'),
                    'rate' => $stock->avg('rate')
                ];
            });
        });
    }
}
