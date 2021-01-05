<?php

namespace App\Http\Controllers;

use App\Models\PlateCode;

class CorporationController extends Controller
{
    public function index()
    {
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
            CURLOPT_POSTFIELDS => '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.reference.its/">
            <soapenv:Header/>
            <soapenv:Body>
               <ser:request>
                  <stakeholderType>hastane</stakeholderType>
                  <getAll>false</getAll>
                  <cityPlate></cityPlate>
               </ser:request>
            </soapenv:Body>
         </soapenv:Envelope>',
            CURLOPT_HTTPHEADER => [
                'Content-Type: text/xml',
                'SOAPAction: http://tempuri.org/Radyosformatik/SSO',
                'Cookie: NSC_WT-MC-L12OFU=ffffffff09081e1545525d5f4f58455e445a4a423660'
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:', 's:'], '', $response);
        dump($clean_xml);
        dump('---');
        $xml = json_decode(json_encode(simplexml_load_string($clean_xml)), true);
        dump($xml);
        $sso_code = $xml['Body'];
        dd($sso_code);
    }

    public function plates()
    {
        return PlateCode::all();
    }
}
