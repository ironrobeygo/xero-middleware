<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Webfox\Xero\OauthCredentialManager;

class QuoteController extends Controller
{
    public function index(Request $request, OauthCredentialManager $xeroCredentials){
        $fileName = $request->quoteNumber.".pdf";
        $this->getQuoteAsPDF($xeroCredentials->getAccessToken(),$fileName);
        return Storage::disk('google')->url($fileName);
    }

    public function getQuoteAsPDF($access,$fileName){

        $postdata = Http::withHeaders([
            'xero-tenant-id' => '33467cfc-8512-4016-9d72-166bca5516fd',
            'Authorization' => "Bearer {$access}",
            'Accept' => 'application/pdf',
            'Content-Type' => 'application/pdf'
        ])
        ->get('https://api.xero.com/api.xro/2.0/Quotes/734639ca-5cc3-4c8d-b97d-0815096892b0')
        ->getBody()
        ->getContents();

        return Storage::disk('google')->put($fileName, $postdata);

    }
}
