<?php

namespace App\Http\Controllers\Investor;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Admin\Platform;
use App\Http\Controllers\Controller;
use App\Http\Requests\Investor\StockTransactionStoreRequest;
use App\Http\Requests\Investor\StockTransactionUpdateRequest;
use App\Models\Admin\Stock;
use App\Models\Investors\StockTransaction;
use Illuminate\Support\Facades\DB;

class StockTransactionController extends Controller
{
    protected $files = [
        'index' => 'Investor/StockTransactions/Index',
        'create' => 'Investor/StockTransactions/Create',
        'show' => 'Investor/StockTransactions/Show',

    ];

    protected $routes = [
        'index' => 'investors.stockTransactions.index',
    ];


    public function index(){
        // return $this->holdings();
       $stockTransactions = StockTransaction::where('user_id', auth()->user()->id)
       ->with('stock:id,name' )
       ->orderBy('date', 'desc')->paginate(pageSize())->withQueryString();
        return Inertia::render($this->files['index'], compact('stockTransactions')); 
    }

    public function holdings(){
        $stockTransactions = StockTransaction::where('user_id', auth()->user()->id)
        ->with('stock:id,name' )->get();
        $holdings = [];
        $investedValue = 0;
        foreach($stockTransactions as $stockTransaction){
            if(!isset($holdings[$stockTransaction->stock_id])){

                $holdings[$stockTransaction->stock_id] = [
                    'name' => $stockTransaction->stock->name,
                    'quantity' => 0,
                    'currenct_avg_rate' => 0,
                    'total' => 0
                ];
            }

            if($stockTransaction->is_buy){
                $holdings[$stockTransaction->stock_id]['quantity'] += $stockTransaction->quantity;
                $holdings[$stockTransaction->stock_id]['total'] += $stockTransaction->price;
                $holdings[$stockTransaction->stock_id]['currenct_avg_rate'] += 0;
                $investedValue += $stockTransaction->price;
            }else{
                $holdings[$stockTransaction->stock_id]['quantity'] -= $stockTransaction->quantity;
                $holdings[$stockTransaction->stock_id]['total'] -= $stockTransaction->price;
                $investedValue -= $stockTransaction->price;
            }

        } 
         return Inertia::render($this->files['index'], compact('stockTransaction')); 
     }

    
     public function create(){
        $platforms = Platform::get(['id', 'name']);
        $stocks = Stock::active()->get(['id', 'name']);
        $reinvestmentLables = ['dividend', 'capital gains'];
        return Inertia::render($this->files['create'], compact('platforms', 'stocks', 'reinvestmentLables'));
    }

    public function store(StockTransactionStoreRequest $request){

        $data = $request->only('date', 'stock_id', 'platform_id', 'exchange', 'quantity', 'rate', 'price', 'is_buy', 'transaciton_charge',  'note');
        $data['user_id'] = auth()->user()->id;
        $data['price'] = $data['rate'] * $data['quantity'];
        
        try {
            DB::beginTransaction();
            StockTransaction::create($data);
            DB::commit();
            return redirect()->back()->with('type', 'success')->with('message', 'Stock Transaction Added Successfully !!');
        }catch (\Exception $e) {
         
            DB::rollback();
            info('Stock transaction controller create ERROR');
            info($e->getMessage());

            return redirect()->back()->with('type', 'fail')->with('message', $e->getMessage());
        }
    }


    public function edit(StockTransaction $stockTransaction){
        $platforms = Platform::get(['id', 'name']);
        $stocks = Stock::active()->get(['id', 'name']);
        $reinvestmentLables = ['dividend', 'capital gains'];

        return Inertia::render($this->files['create'], compact('stockTransaction', 'platforms', 'stocks', 'reinvestmentLables'));
    }

    public function update(StockTransactionUpdateRequest $request, StockTransaction $stockTransaction){
        $data = $request->only('date', 'stock_id', 'platform_id', 'exchange', 'quantity', 'rate', 'price', 'is_buy', 'transaciton_charge',  'note');
        $data['price'] = $data['rate'] * $data['quantity'];

        try {
            DB::beginTransaction();
            $stockTransaction->update($data);
            DB::commit();
            return redirect()->back()->with('type', 'success')->with('message', 'Stock Transaction Updated Successfully !!');
        }catch (\Exception $e) {
         
            DB::rollback();
            info('Stock transaction controller update fail');
            info($e->getMessage());
            return redirect()->back()->with('type', 'fail')->with('message', $e->getMessage());
        }
    }
    
    public function destroy(StockTransaction $stockTransaction){
        $stockTransaction->delete();
        return redirect(route($this->routes['index']))->with('type', 'success')->with('message', 'Transaction Deleted Successfully !!');
    }
}
