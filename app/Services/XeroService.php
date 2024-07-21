<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class XeroService {

    public function getQuoteAsPDF($access,$fileName,$quoteId){
        
        $postdata = Http::withHeaders([
            'xero-tenant-id' => "33467cfc-8512-4016-9d72-166bca5516fd",
            'Authorization' => "Bearer {$access}",
            'Accept' => 'application/pdf',
            'Content-Type' => 'application/pdf'
        ])
        ->get("https://api.xero.com/api.xro/2.0/Quotes/{$quoteId}")
        ->getBody()
        ->getContents();

        return Storage::disk('google')->put($fileName, $postdata);

    }

    public function generateQuote($access){

        $postdata = Http::withHeaders([
            'xero-tenant-id' => "33467cfc-8512-4016-9d72-166bca5516fd",
            'Authorization' => "Bearer {$access}",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
        ->put('https://api.xero.com/api.xro/2.0/Quotes', [
            'Contact' => [
                'ContactID' => request()->ContactID
            ],
            'Reference' => request()->Reference,
            'LineItems' => json_decode(request()->LineItems, true),
            'Date'      => request()->Date,
            'Expiry'    => request()->Expiry,
            'Status'    => 'SENT',
            'LineAmountTypes' => 'EXCLUSIVE',
            'BrandingThemeID' => request()->BrandingTheme
        ]);

        return json_decode($postdata->getBody()->getContents());

    }

}

