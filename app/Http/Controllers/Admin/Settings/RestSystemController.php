<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdvanceSetups\SystemResetRequest;
use Illuminate\Support\Facades\Artisan;

class RestSystemController extends Controller
{
    // this is for empty the system
    public function productionReset(SystemResetRequest $request)
    {
        Artisan::call('migrate:fresh');
        Artisan::call('db:seed ProductionSeeder');

        return redirect(route('login'));
        exit('System test reset successfull');
    }

    // reset with dummy data
    public function testRest(SystemResetRequest $request)
    {
        Artisan::call('migrate:fresh', ['--seed' => true]);

        return redirect(route('login'));
    }
}
