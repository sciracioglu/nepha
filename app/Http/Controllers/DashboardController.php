<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Products;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['user_count'] = User::count();
        $data['medicine_count'] = Medicine::count();
        $data['sales_count'] = Products::whereNull('cancel_date')->count();
        $data['canceled_count'] = Products::whereNotNull('cancel_date')->count();
        $data['cancel_percent'] = $data['sales_count'] > 0 ? (100 * $data['canceled_count']) / $data['sales_count'] : 0;
        $data['medicine_sales_count'] = Products::with('medicine')->whereNull('cancel_date')
            ->groupBy('gtin')
            ->get(['gtin', DB::raw('count(*) as Say')]);

        return view('dashboard', $data);
    }
}
