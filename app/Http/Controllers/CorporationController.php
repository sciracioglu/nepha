<?php

namespace App\Http\Controllers;

use App\Models\PlateCode;

class CorporationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = request()->validate([
            'stakeholderType' => 'required',
            'cityPlate' => 'required',
        ]);
        $data['getAll'] = request('getAll') ?? false;
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://its.saglik.gov.tr/ReferenceServices/Stakeholder?wsdl',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => '86989140000120000:Nepha*2019',
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
             xmlns:ser=\"http://services.reference.its/\">\n
            <soapenv:Header/>\n
            <soapenv:Body>\n
               <ser:request>\n
                  <stakeholderType>{$data['stakeholderType']}</stakeholderType>\n
                  <getAll>{$data['getAll']}</getAll>\n
                  <cityPlate>{$data['cityPlate']}</cityPlate>\n
               </ser:request>\n
            </soapenv:Body>\n
         </soapenv:Envelope>",
            CURLOPT_HTTPHEADER => [
                'Content-Type: text/xml',
                'SOAPAction: http://tempuri.org/Corps/SSO',
                'Cookie: NSC_WT-MC-L12OFU=ffffffff09081e1545525d5f4f58455e445a4a423660'
            ],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:', 's:'], '', $response);
        libxml_use_internal_errors(true);
        $xml = json_decode(json_encode(simplexml_load_string($clean_xml)), true);
        $companies = $xml['Body']['ns2:response']['companies'];
        $comp = [];

        foreach ($companies['company'] as $company) {
            array_push($comp, [
                'gln' => $company['gln'],
                'label' => '(' . $company['gln'] . ') ' . $company['companyName'],
                'companyName' => $company['companyName'],
                'authorized' => $company['authorized'] ?? '',
                'email' => $company['email'],
                'phone' => $company['phone'] ?? '',
                'city' => $company['city'],
                'town' => $company['town'],
                'address' => $company['address'] ?? '',
            ]);
        }
        sort($comp);
        return collect($comp);
//        if (isset($companies['company'])) {
//            return collect($companies['company']);
//        }
//
//        return [];
    }

    public function plates()
    {
        return PlateCode::all();
    }
}
