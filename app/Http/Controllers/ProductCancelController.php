<?php

namespace App\Http\Controllers;

class ProductCancelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
