<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class XeroService {

    public function getQuoteAsPDF($access,$fileName,$quoteId){
        
        $postdata = Http::withHeaders([
            'xero-tenant-id' => config('xero.xero_tenant_id'),
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
            'xero-tenant-id' => config('xero.xero_tenant_id'),
            'Authorization' => "Bearer {$access}",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
        ->put('https://api.xero.com/api.xro/2.0/Quotes', [
            'Contact' => [
                'ContactID' => request()->ContactID
            ],
            'Reference' => request()->Reference,
            'LineItems' => request()->LineItems,
            'Date'      => request()->Date,
            'Expiry'    => request()->Expiry,
            'Status'    => 'SENT',
            'LineAmountTypes' => 'INCLUSIVE',
            'BrandingThemeID' => request()->BrandingTheme
        ]);

        return json_decode($postdata->getBody()->getContents());

    }

    public function generateInvoice($access){
        $postdata = Http::withHeaders([
            'xero-tenant-id' => config('xero.xero_tenant_id'),
            'Authorization' => "Bearer {$access}",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
        ->put('https://api.xero.com/api.xro/2.0/Invoices', [
            "Type" => "ACCREC",
            'Contact' => [
                'ContactID' => request()->ContactID
            ],
            'Reference' => request()->Reference,
            'LineItems' => request()->LineItems,
            'Date'      => request()->Date,
            'DueDate'   => request()->Expiry,
            'Status'    => 'AUTHORISED',
            'LineAmountTypes' => 'INCLUSIVE',
            'BrandingThemeID' => request()->BrandingTheme
        ]);

        return json_decode($postdata->getBody()->getContents());
    }

}

