<?php

namespace App\Http\Controllers;

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
        $data['groups'] = Medicine::groupBy('group')
            ->get(['group'])
            ->map(function ($group) {
                return [
                    'group' => $group->group,
                    'name' => $this->group[$group->group],
                ];
            });

        $data['medicines'] = Medicine::orderBy('group')
            ->orderBy('medicine')
            ->get()
            ->map(function ($medicine) {
                return [
                    'group' => $medicine->group,
                    'barcode' => $medicine->gtin,
                    'medicine' => $medicine->medicine,
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
        ]);

        Medicine::create($data);
    }

    public function destroy($gtin)
    {
        Medicine::where('gtin', $gtin)
            ->delete();
    }
}
