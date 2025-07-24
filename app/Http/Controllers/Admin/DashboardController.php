<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dealer;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\MainInventory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = ([
            'inventory' => MainInventory::where('status', 1)->count(),
            'dealer' => Dealer::where('status', 1)->count(),
            'leads' => Lead::where('status', 1)->count(),
            'invoice' => Invoice::where('is_cart', 1)->count(),
        ]);
        return view('Admin.dashboard', $data);
    }

    public function blank()
    {
        return view('Admin.blank');
    }
}
