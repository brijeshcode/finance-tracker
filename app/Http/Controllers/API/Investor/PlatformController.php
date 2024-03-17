<?php

namespace App\Http\Controllers\API\Investor;

use App\Http\Controllers\Controller;
use App\Models\Admin\Platform;
use App\Models\Admin\Stock;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    public function platfroms(){
        return Platform::get(['id','name']);
    }

    public function stocks(){
        return  Stock::active()->get(['id','name']);
    }
}
