<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Medicine;
use App\Models\PlateCode;
use App\Models\Products;
use Carbon\Carbon;

class ProductController extends SalesController
{
    private array $units;
    private array $dt;


    public function __construct()
    {
        $this->middleware('auth');
        $this->units = [
            1 => '&#181;ci',
            2 => 'mci',
            3 => 'mbq',
            4 => 'gbq',
            5 => 'kutu/vial',
        ];
        $this->dt = [
            'I' => 'İthalat',
            'M' => 'Yurt İçi',
            'E' => 'İhracat',
        ];
    }

    public function index()
    {

        $codes = (new SalesController())->codes;
        return Products::with('medicine')->get()
            ->map(function ($product) use ($codes) {
                return [
                    'id' => $product->id,
                    'gtin' => Medicine::where('gtin', $product->gtin)->first()->medicine,
                    'stakeholderType' => $product->stakeholderType,
                    'city' => PlateCode::where('code', $product->plate)->first(),
                    'medicine' => $product->medicine[0]->medicine,
                    'corp' => $product->corp,
                    'bn' => $product->bn,
                    'production_identifier' => $product->production_identifier,
                    'loaded_activity' => $product->loaded_activity,
                    'loaded_unit_id' => $this->units[$product->loaded_unit_id],
                    'calibration_activity' => $product->calibration_activity,
                    'calibration_unit_id' => $this->units[$product->calibration_unit_id],
                    'load_date' => Carbon::parse($product->load_date)->format('d/m/Y'),
                    'delivery' => Carbon::parse($product->delivery)->format('d/m/Y'),
                    'dt' => $this->dt[$product->dt],
                    'uc' => $codes[$product->uc] ?? '',
                    'bildirim_id' => $product->bildirim_id,
                    'cancel_date' => $product->cancel_date,
                    'country_code' => Country::where('code2', $product->country_code)->first()->country,
                    'xd' => Carbon::parse($product->xd)->format('d/m/Y'),
                ];
            });
    }
}
