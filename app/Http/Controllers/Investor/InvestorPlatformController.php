<?php

namespace App\Http\Controllers\Investor;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Models\Investors\InvestorPlatform;
use App\Http\Requests\Investor\InvestorPlatformStoreRequest;
use App\Http\Requests\Investor\InvestorPlatformUpdateRequest;

class InvestorPlatformController extends Controller
{
    protected $files = [
        'index' => 'Investor/InvestorPlatform/Index',
        'create' => 'Investor/InvestorPlatform/Create',
        'show' => 'Investor/InvestorPlatform/Show',

    ];

     protected $routes = [
        'index' => 'investors.stockTransactions.index',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Inertia::render($this->files['index'], compact('')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // return Inertia::render($this->files['create'], compact(''));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvestorPlatformStoreRequest $request)
    {
        $data = $request->only('platform_id');
        $data['user_id'] = auth()->user()->id; 
        $platform = InvestorPlatform::create($data);
        return redirect()->back()->with('type', 'success')->with('message', 'Investor Platform Added Successfully !!');
    }

    /**
     * Display the specified resource.
     */
    public function show(InvestorPlatform $investorPlatform)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvestorPlatform $investorPlatform)
    {
        //
        return Inertia::render($this->files['create'], compact('{{ modelVariable}}'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvestorPlatformUpdateRequest $request, InvestorPlatform $investorPlatform)
    {
        //
        return redirect(route($this->routes['index']))->with('type', 'success')->with('message', 'InvestorPlatform Updated Successfully !!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvestorPlatform $investorPlatform)
    {
        //
        return redirect(route($this->routes['index']))->with('type', 'success')->with('message', 'InvestorPlatform deleted successfully !!');
    }
}
