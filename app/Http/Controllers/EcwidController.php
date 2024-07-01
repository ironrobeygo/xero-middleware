<?php

namespace App\Http\Controllers;

use Monday;
use Illuminate\Http\Request;
use App\Services\EcwidService;
use App\Services\MondayService;

class EcwidController extends Controller
{
    public function index(Request $request, EcwidService $ecwidService, MondayService $mondayService){

        $courses = $ecwidService->parseOrder(request()->orderId);
        return $mondayService->addSubItem(request()->parentId, $courses);
        
    }
}