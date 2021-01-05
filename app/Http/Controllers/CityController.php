<?php

namespace App\Http\Controllers;

use App\Models\PlateCode;

class CityController extends Controller
{
    public function index()
    {
        return PlateCode::all();
    }
}
