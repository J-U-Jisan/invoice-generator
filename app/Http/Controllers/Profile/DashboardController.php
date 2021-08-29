<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Customer;
use Cassandra\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = Customer::where('user_id', Auth::id())->get();
        return view('profile/dashboard-invoice', compact('customers'));
    }
    public function  deleteInvoice()
    {

    }
}
