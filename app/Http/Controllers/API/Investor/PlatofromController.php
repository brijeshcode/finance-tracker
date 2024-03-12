<?php

namespace App\Http\Controllers\API\Investor;

use App\Http\Controllers\Controller;
use App\Models\Admin\Platform;
use Illuminate\Http\Request;

class PlatofromController extends Controller
{
    public function platfroms(){
        $platofroms = Platform::active()->get(['id','name']);
        return $platofroms;
    }
}
