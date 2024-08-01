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
        $quoteId = $request->quoteId;

        if(request()->path() == 'api/get-quote-as-pdf'){
            $fileName = $request->quoteNumber.".pdf";
            $xeroService->getQuoteAsPDF($access,$fileName,$quoteId);
            return Storage::disk('google')->url($fileName);
        } else {
            $quoteNumber = request()->quoteNumber;
            return $xeroService->getQuote($access,$quoteNumber);
        }
    }

    public function updateQuote(OauthCredentialManager $xeroCredentials, XeroService $xeroService){
        $access = $xeroCredentials->getAccessToken();
        return $xeroService->updateQuote($access);
    }

    public function store(Request $request, OauthCredentialManager $xeroCredentials, XeroService $xeroService){
        $access = $xeroCredentials->getAccessToken();
        if( request()->Type == 'Quote' ){
            $return = $xeroService->generateQuote($access);
        } else {
            $return = $xeroService->generateInvoice($access);
        }
        return $return;
    }

    public function getInvoice(OauthCredentialManager $xeroCredentials, XeroService $xeroService){
        $access = $xeroCredentials->getAccessToken();
        return $xeroService->getInvoice($access);
    }

    public function updateInvoice(OauthCredentialManager $xeroCredentials, XeroService $xeroService){
        $access = $xeroCredentials->getAccessToken();
        return $xeroService->updateInvoice($access);
    }
}
