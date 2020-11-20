<?php

namespace App\Http\Controllers;

use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Support\Facades\Http;
use SoapClient;
use SoapHeader;

class SoapController
{
    /**
     * @var SoapWrapper
     */
    protected $soapWrapper;

    /**
     * SoapController constructor.
     *
     * @param SoapWrapper $soapWrapper
     */
    public function __construct(SoapWrapper $soapWrapper)
    {
        $this->soapWrapper = $soapWrapper;
    }

    /**
     * Use the SoapWrapper
     */
    public function show()
    {
        $wsdlUrl = 'https://its.saglik.gov.tr/ReferenceServices/Stakeholder?wsdl';
        $soap = new SoapClient($wsdlUrl, ['username' => env('ITS_ID'), 'password' => env('ITS_PASS')]);
        dd($soap);
        $header = new SoapHeader($wsdlUrl, 'ApiCredentials', false);
        $result = $soap->__soapCall('stakeholderResponse', [], null, $header);
        dd($result);
        $data = Http::withBasicAuth(env('ITS_ID'), env('ITS_PASS'))
            ->get($wsdlUrl)
            ->body();
        dd($data);
    }
}
