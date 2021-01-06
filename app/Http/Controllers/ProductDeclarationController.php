<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Carbon\Carbon;

class ProductDeclarationController extends Controller
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
        return view('home');
    }

    public function store()
    {
        $response = [];
        $data = request()->validate([
            'cityPlate' => 'required',
            'stakeholderType' => 'required',
            'togln' => 'required',
            'gtin' => 'required',
            'bn' => 'required',
            'production_identifier' => 'required',
            'loaded_activity' => 'required',
            'loaded_unit_id' => 'required',
            'calibration_activity' => 'required',
            'calibration_unit_id' => 'required',
            'load_date' => 'required',
            'dt' => 'required',
            'country_code' => 'required',
            'xd' => 'required',
        ]);
        $data['city'] = $data['cityPlate']['city'];
        $data['plate'] = $data['cityPlate']['code'];
        $data['corp'] = $data['togln']['companyName'];
        $data['togln'] = $data['togln']['gln'];
        unset($data['cityPlate']);
        $data['load_date'] = Carbon::parse(request('load_date'))->format('Y-m-d');
        $data['xd'] = Carbon::parse(request('xd'))->format('Y-m-d');
        $code = $this->addITS($data);
        if ($code === '00000') {
            Products::create($data);
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
            $responce['message'] = $this->codes[$code];
        }

        return $response;
    }

    private function addITS($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://its.saglik.gov.tr/RadyofarmasotikBildirim/RadyofarmasotikBildirimReceiverService?wsdl',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => '86989140000120000:Nepha*2019',
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
            xmlns:rad=\"http://its.iegm.gov.tr/bildirim/BR/v1/Radyofarma\">\n
            <soapenv:Header/>\n
            <soapenv:Body>\n
            <rad:Radyofarma>\n
            <TOGLN>{$data['togln']}</TOGLN>\n
            <URUNLER>\n
               <!--1 or more repetitions:-->
               <URUN>\n
                  <GTIN>{$data['gtin']}</GTIN>\n
                  <BN>{$data['bn']}</BN>\n
                  <PRODUCTION_IDENTIFIER>{$data['production_identifier']}</PRODUCTION_IDENTIFIER>\n
                  <LOADED_ACTIVITY>{$data['loaded_activity']}</LOADED_ACTIVITY>\n
                  <LOADED_UNIT_ID>{$data['loaded_unit_id']}</LOADED_UNIT_ID>\n
                  <CALIBRATION_ACTIVITY>{$data['calibration_activity']}</CALIBRATION_ACTIVITY>\n
                  <CALIBRATION_UNIT_ID>{$data['calibration_unit_id']}</CALIBRATION_UNIT_ID>\n
                  <LOAD_DATE>{$data['load_date']}</LOAD_DATE>\n
                  <DT>{$data['dt']}</DT>\n
                  <COUNTRY_CODE>{$data['country_code']}</COUNTRY_CODE>\n
                  <XD>{$data['xd']}</XD>\n
               </URUN>\n
            </URUNLER>\n
         </rad:Radyofarma>\n
         </soapenv:Body>\n
         </soapenv:Envelope>",
            CURLOPT_HTTPHEADER => [
                'Content-Type: text/xml',
                'SOAPAction: http://tempuri.org/Radyosformatik/SSO',
                'Cookie: NSC_WT-MC-L12OFU=ffffffff09081e1545525d5f4f58455e445a4a423660'
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:', 's:'], '', $response);
        libxml_use_internal_errors(true);
        $xml = json_decode(json_encode(simplexml_load_string($clean_xml)), true);
        $sso_code = $xml['Body'];
        dd($sso_code);
    }
}
