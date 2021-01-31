<?php

namespace App\Http\Controllers;

use App\Models\PlateCode;
use App\Models\Products;

class ProductController extends SalesController
{
    private $units;

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
    }

    public function index()
    {
        return Products::with('medicine')->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'stakeholderType' => $product->stakeholderType,
                    'city' => PlateCode::find($product->plate),
                    'medicine' => $product->medicine->medicine,
                    'corp' => $product->corp,
                    'bn' => $product->bn,
                    'product_identifier' => $product->identifier,
                    'loaded_activity' => $product->loaded_activity,
                    'loaded_unit_id' => $this->units[$product->loaded_unit_id],
                    'calibration_activity' => $product->calibration_activity,
                    'calibration_unit_id' => $this->units[$product->calibration_unit_id],
                    'load_date' => $product->load_date,
                    'delivery' => $product->delivery,
                    'dt' => $product->dt,
                    'uc' => $this->codes[$product->uc],
                    'bildirim_id' => $product->bildirim_id,
                    'cancel_date' => $product->cancel_date,
                ];
            });
    }
}
