<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class EcwidController extends Controller
{
    public function index(Request $request){

        $response = Http::get('https://app.ecwid.com/api/v3/31163355/orders/'.request()->orderId.'?token='.config('ecwid.ecwid_token'));
        return $response;
    }
}
