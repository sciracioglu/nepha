<?php

namespace App\Http\Controllers;

use App\Models\Products;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Products::all();
    }
}
