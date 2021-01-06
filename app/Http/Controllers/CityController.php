<?php

namespace App\Http\Controllers;

use App\Models\PlateCode;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return PlateCode::all();
    }
}
