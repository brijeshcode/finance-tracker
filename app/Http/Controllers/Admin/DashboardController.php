<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Dashboards\AdminDashboardController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (isRole('admin')) {
            return $this->adminDashboard($request);
        }
        if (isRole('operator')) {
            return $this->operatorDashboard($request);
        }

        if (isRole('investor')) {
            return $this->investorDashboard();
        }

        return Inertia::render('Dashboard');

    }

    public function adminDashboard($request)
    {
        return (new AdminDashboardController())->index($request);
    }

    public function operatorDashboard()
    {
        return Inertia::render('Admin/Dashboard');
    }

    public function investorDashboard()
    {
        return Inertia::render('Investor/Dashboard');
    }
}