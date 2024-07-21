<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\XeroService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Webfox\Xero\OauthCredentialManager;

class QuoteController extends Controller
{
    public function index(Request $request, OauthCredentialManager $xeroCredentials, XeroService $xeroService){
        $access = $xeroCredentials->getAccessToken();
        $fileName = $request->quoteNumber.".pdf";
        $quoteId = $request->quoteId;
        $xeroService->getQuoteAsPDF($access,$fileName,$quoteId);
        return Storage::disk('google')->url($fileName);
    }


    public function store(Request $request, OauthCredentialManager $xeroCredentials, XeroService $xeroService){
        $access = $xeroCredentials->getAccessToken();
        if( request()->type == 'Quote' ){
            $return = $xeroService->generateQuote($access);
        } else {
            $return = $xeroService->generateInvoice($access);
        }
        return $return;
    }
}
