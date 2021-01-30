<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Medicine;

class MedicineController extends Controller
{
    private array $group;

    public function __construct()
    {
        $this->middleware('auth');
        $this->group = [
            'soguk_kit' => 'Soğuk Kit',
            'radyofarmasotik' => 'Radyofarmasötikler',
        ];
    }

    public function index()
    {
        return view('medicine');
    }

    public function list()
    {
        $data['country'] = Country::orderBy('country')->get();
        $data['medicine'] = Medicine::orderBy('medicine')
            ->get()
            ->map(function ($medicine) {
                return [
                    'barcode' => $medicine->gtin,
                    'medicine' => $medicine->medicine,
                    'group' => $this->group[$medicine->group],
                    'country' => json_decode($medicine->country, true),
                ];
            });

        return $data;
    }

    public function store()
    {
        $data = request()->validate([
            'gtin' => 'required',
            'medicine' => 'required',
            'group' => 'required',
            'country' => 'required',
        ]);
        $data['country'] = json_encode(request('country'), JSON_UNESCAPED_UNICODE);

        Medicine::create($data);
    }

    public function destroy($gtin)
    {
        Medicine::where('gtin', $gtin)
            ->delete();
    }
}
