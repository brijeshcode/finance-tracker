<?php

namespace App\Http\Controllers\Admin\Setup;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Admin\Mutualfund;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setup\MutualStoreRequest;
use App\Http\Requests\Admin\Setup\MutualUpdateRequest;

class MutualFundController extends Controller
{
    protected $files = [
        'index' => 'Admin/Setups/MutualFunds/Index',
        'create' => 'Admin/Setups/MutualFunds/Create',
        'show' => 'Admin/Setups/MutualFunds/Show',

    ];

    protected $routes = [
        'index' => 'admin.mutualFunds.index',
    ];

    public function index(Request $request)
    {
        $mutualFunds = Mutualfund::orderBy('name')->paginate(pageSize())->withQueryString();

        return Inertia::render($this->files['index'], compact('mutualFunds'));
    }

    public function list($fields = '')
    {
        if (empty($fields)) {
            return Mutualfund::active()->get();
        }
        return Mutualfund::select(explode(',', $fields))->active()->get();

    }

    public function create()
    {
        return Inertia::render($this->files['create']);
    }

    public function store(MutualStoreRequest $request)
    {
        Mutualfund::create($request->only('name', 'type', 'market_cap', 'expense_ratio', 'is_index_fund', 'note', 'active'));

        return redirect(route($this->routes['index']))->with('type', 'success')->with('message', 'Stock Added Successfully !!');
    }

    public function show(MutualFund $mutualFund)
    {
        abort(404); 
        // return Inertia::render($this->files['show'], compact('mutualFund'));
    }

    public function edit(MutualFund $mutualFund)
    {
        return Inertia::render($this->files['create'], compact('mutualFund'));
    }

    public function update(MutualUpdateRequest $request, MutualFund $mutualFund)
    {
        $mutualFund->update($request->only('name', 'type', 'market_cap', 'expense_ratio', 'is_index_fund', 'note', 'active'));
        return redirect(route($this->routes['index']))->with('type', 'success')->with('message', 'Stock Updated Successfully !!');
    }

    public function destroy(MutualFund $mutualFund)
    {
        abort(404);
        // $mutualFund->delete();
        // return redirect(route($this->routes['index']))->with('type', 'success')->with('message', 'Client Deleted Successfully !!');
    }
}
