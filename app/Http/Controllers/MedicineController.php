<?php

namespace App\Http\Controllers;

use App\Models\Medicine;

class MedicineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('medicine');
    }

    public function list()
    {
        return Medicine::orderBy('medicine')->get();
    }

    public function store()
    {
        $data = request()->validate([
            'gtin' => 'required',
            'medicine' => 'required',
        ]);

        Medicine::create($data);
    }

    public function destroy($gtin)
    {
        Medicine::where('gtin', $gtin)
            ->delete();
    }
}
