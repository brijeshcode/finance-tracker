<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use App\Models\Investors\InvestorPlatform;
use App\Models\Investors\StockHolding;
use App\Models\Investors\StockPortfolio;
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
        $portfolio = StockPortfolio::where('user_id', auth()->user()->id)->with('stock:id,name')->get([ 'stock_id', 'quantity', 'running_avg_rate', 'invested_value']);
        $totalInvesteValue = $portfolio->sum('invested_value');
        $stockCount = $portfolio->count('stock_id');
        return Inertia::render($this->files['portfolio'], compact('portfolio', 'totalInvesteValue', 'stockCount')); 
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
    
    function holdingsByPlatform($userId){
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
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return Inertia::render($this->files['create']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        return redirect(route($this->routes['index']))->with('type', 'success')->with('message', 'StockHolding Added Successfully !!');
    }

    /**
     * Display the specified resource.
     */
    public function show(StockHolding $stockHolding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockHolding $stockHolding)
    {
        //
        return Inertia::render($this->files['create'], compact('{{ modelVariable}}'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockHolding $stockHolding)
    {
        //
        return redirect(route($this->routes['index']))->with('type', 'success')->with('message', 'StockHolding Updated Successfully !!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockHolding $stockHolding)
    {
        //
        return redirect(route($this->routes['index']))->with('type', 'success')->with('message', 'StockHolding deleted successfully !!');
    }
}
