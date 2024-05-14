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
        $quoteId = $request->quoteId;
        $tenant = $request->tenant;
        $this->getQuoteAsPDF($xeroCredentials->getAccessToken(),$fileName,$quoteId,$tenant);
        return Storage::disk('google')->url($fileName);
    }

    public function getQuoteAsPDF($access,$fileName,$quoteId,$tenant){

        $postdata = Http::withHeaders([
            'xero-tenant-id' => "3467cfc-8512-4016-9d72-166bca5516fd",
            'Authorization' => "Bearer {$access}",
            'Accept' => 'application/pdf',
            'Content-Type' => 'application/pdf'
        ])
        ->get("https://api.xero.com/api.xro/2.0/Quotes/{$quoteId}")
        ->getBody()
        ->getContents();

        return Storage::disk('local')->put($fileName, $postdata);

    }
}
