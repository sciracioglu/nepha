<?php

namespace App\Http\Controllers;

use App\Models\PlateCode;
use App\Models\Products;

class ProductController extends Controller
{
    private $codes;

    public function __construct()
    {
        $this->middleware('auth');
        $this->codes = [
            '00000' => 'Ürün üzerinde gerçekleştirilen işlem başarılıdır.',
            '11005' => 'Bu ürüne ait bildirim yapma yetkiniz yok',
            '10204' => 'Belirtilen ürün daha önce satılmış',
            '10202' => 'Ürünün Son Kullanma Tarihi geçmiştir',
            '11004' => 'Yanlış GTIN numarası',
            '10206' => 'Veri tabanı kayıt hatası',
            '10201' => 'Belirtilen ürün sistemde kayıtlı değil',
            '15029' => 'Geçersiz (Kalibrasyon/Yüklenen Aktivite) birim değeri',
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
                    'loaded_unit_id' => $product->loaded_unit_id,
                    'calibration_activity' => $product->calibration_activity,
                    'calibration_unit_id' => $product->calibration_unit_id,
                    'load_date' => $product->load_date,
                    'dt' => $product->dt,
                    'uc' => $this->codes[$product->uc],
                    'bildirim_id' => $product->bildirim_id,
                    'cancel_date' => $product->cancel_date,
                ];
            });
    }
}
