<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use App\Models\Investors\StockHolding;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StockHoldingController extends Controller
{
    protected $files = [
        'index' => 'Investor/StockHoldings/Index',
        'create' => 'Investor/StockHoldings/Create',
        'show' => 'Investor/StockHoldings/Show',

    ];

    protected $routes = [
        'index' => 'investors.stocks.holdings',
    ];
    /**
     * Display a listing of the resource.
     */
    public function holdings()
    {
        //
        return Inertia::render($this->files['index']); 
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
