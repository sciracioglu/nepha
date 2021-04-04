<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Products;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['sales_6'] = Products::where('load_date','>=', Carbon::now()->subMonths(6)->format('Y-m-d'))
            ->whereNull('cancel_date')->count();
        $data['sales_3'] =  Products::where('load_date','>=', Carbon::now()->subMonths(3)->format('Y-m-d'))
            ->whereNull('cancel_date')->count();
        $data['sales_count'] = Products::whereNull('cancel_date')->count();
        $data['canceled_count'] = Products::whereNotNull('cancel_date')->count();
        $data['cancel_percent'] = round($data['sales_count'] > 0 ? (100 * $data['canceled_count']) / $data['sales_count'] : 0,2);
        $data['medicine_sales_count'] = Products::with('medicine')->whereNull('cancel_date')
            ->groupBy('gtin')
            ->get(['gtin', DB::raw('count(*) as Say')]);
        $data['cities'] = $this->cities();
        $data['medicines'] = $this->medicines();

        return view('dashboard', $data);
    }

    private function cities()
    {
        return Products::whereNull('cancel_user')
            ->groupBy('city')
            ->get(['city',DB::raw('count(*) as Say')])
            ->map(function($product){
                return [
                    'name' => $product->city,
                    'y' => $product->Say,
                ];
            });

    }

    private function medicines()
    {
        return Products::whereNull('cancel_user')
            ->with('medicine')
            ->groupBy('gtin')
            ->get(['gtin',DB::raw('count(*) as Say')])
            ->map(function($product){
                return [
                    'name' => $product->medicine[0]->medicine,
                    'y' => $product->Say,
                ];
            });

    }
}
