<?php

namespace App\Http\Controllers\Admin\Setup;

use Inertia\Inertia;
use App\Models\Admin\Stock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setup\StockStoreRequest;
use App\Http\Requests\Admin\Setup\StockUpdateRequest;

class StockController extends Controller
{
    protected $files = [
        'index' => 'Admin/Setups/Stocks/Index',
        'create' => 'Admin/Setups/Stocks/Create',
        'show' => 'Admin/Setups/Stocks/Show',

    ];

    protected $routes = [
        'index' => 'admin.stocks.index',
    ];

    public function index(Request $request)
    {
        $stocks = Stock::orderBy('name')->paginate(pageSize())->withQueryString();

        return Inertia::render($this->files['index'], compact('stocks'));
    }

    public function list($fields = '')
    {
        if (empty($fields)) {
            return Stock::active()->get();
        }
        return Stock::select(explode(',', $fields))->active()->get();

    }

    public function create()
    {
        return Inertia::render($this->files['create']);
    }

    public function store(StockStoreRequest $request)
    {
        Stock::create($request->only('name', 'symbol', 'nse_code', 'bse_code', 'web_link', 'note', 'active'));

        return redirect(route($this->routes['index']))->with('type', 'success')->with('message', 'Stock Added Successfully !!');
    }

    public function show(Stock $stock)
    {
        abort(404);
        // return Inertia::render($this->files['show'], compact('client'));
    }

    public function edit(Stock $stock)
    {
        return Inertia::render($this->files['create'], compact('stock'));
    }

    public function update(StockUpdateRequest $request, Stock $stock)
    {
        $stock->update($request->only('name', 'symbol', 'nse_code', 'bse_code', 'web_link', 'note', 'active'));
        
        return redirect(route($this->routes['index']))->with('type', 'success')->with('message', 'Stock Updated Successfully !!');
    }

    public function destroy(Stock $stock)
    {
        abort(404);
        // $stock->delete();
        // return redirect(route($this->routes['index']))->with('type', 'success')->with('message', 'Client Deleted Successfully !!');
    }
}
