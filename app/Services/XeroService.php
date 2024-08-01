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

    public function getQuote($access,$quoteNumber){

        $postdata = Http::withHeaders([
            'xero-tenant-id' => "33467cfc-8512-4016-9d72-166bca5516fd",
            'Authorization' => "Bearer {$access}",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
        ->get("https://api.xero.com/api.xro/2.0/Quotes?QuoteNumber={$quoteNumber}");

        return json_encode($postdata->getBody()->getContents());
    }

    public function updateQuote($access){
        $quoteId = request()->QuoteId;

        $postdata = Http::withHeaders([
            'xero-tenant-id' => "33467cfc-8512-4016-9d72-166bca5516fd",
            'Authorization' => "Bearer {$access}",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
        ->post("https://api.xero.com/api.xro/2.0/Quotes/{$quoteId}", [
            'Contact' => [
                'ContactID' => request()->ContactID
            ],
            'Reference' => request()->Reference,
            'LineItems' => request()->LineItems,
            'Date'      => request()->Date,
            'ExpiryDate'    => request()->Expiry,
            'Status'    => 'AUTHORISED',
            "LineAmountTypes" => "Inclusive",
            'BrandingThemeID' => request()->BrandingTheme
        ]);

        return json_decode($postdata->getBody()->getContents());
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
            'xero-tenant-id' => "33467cfc-8512-4016-9d72-166bca5516fd",
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
            'LineAmountTypes' => 'Inclusive',
            'BrandingThemeID' => request()->BrandingTheme
        ]);

        return json_decode($postdata->getBody()->getContents());
    }

    public function getInvoice($access){

        $params = request()->type=="url"?"/OnlineInvoice":"";
        $invoiceId = request()->invoiceId;

        $url = "https://api.xero.com/api.xro/2.0/Invoices/{$invoiceId}{$params}";

        $postdata = Http::withHeaders([
            'xero-tenant-id' => "33467cfc-8512-4016-9d72-166bca5516fd",
            'Authorization' => "Bearer {$access}",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
        ->get($url);

        return json_encode($postdata->getBody()->getContents());
    }

    public function updateInvoice($access){

        $invoiceId = request()->InvoiceID;

        $postdata = Http::withHeaders([
            'xero-tenant-id' => "33467cfc-8512-4016-9d72-166bca5516fd",
            'Authorization' => "Bearer {$access}",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
        ->post("https://api.xero.com/api.xro/2.0/Invoices/{$invoiceId}", [
            'Contact' => [
                'ContactID' => request()->ContactID
            ],
            'Type'      => 'ACCREC',
            'Reference' => request()->Reference,
            'LineItems' => request()->LineItems,
            'Date'      => request()->Date,
            'DueDate'    => request()->Expiry,
            'Status'    => 'AUTHORISED',
            "LineAmountTypes" => "Inclusive",
            'BrandingThemeID' => request()->BrandingTheme
        ]);

        return json_decode($postdata->getBody()->getContents());
    }

}