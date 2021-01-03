<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Carbon\Carbon;

class ProductDeclarationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function store()
    {
        $data = request()->validate([
            'gtin' => 'required',
            'bn' => 'required',
            'production_identifier' => 'required',
            'loaded_activity' => 'required',
            'loaded_unit_id' => 'required',
            'calibration_activity' => 'required',
            'calibration_unit_id' => 'required',
            'load_date' => 'required',
            'dt' => 'required',
            'country_code' => 'required',
            'xd' => 'required',
        ]);
        $data['load_date'] = Carbon::parse(request('load_date'))->format('Y-m-d');
        $data['xd'] = Carbon::parse(request('xd'))->format('Y-m-d');
        Products::create($data);
    }
}
