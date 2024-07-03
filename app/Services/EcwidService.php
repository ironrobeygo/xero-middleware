<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class EcwidService {

    public function parseOrder($orderId){

        $response = Http::get(config('ecwid.ecwid_url').$orderId.'?token='.config('ecwid.ecwid_token'));
        $order = json_decode($response->getBody());

        // dd($order);

        $discount = $order->volumeDiscount > 0 ? $this->getOrderPercentage($order->volumeDiscount,$order->subtotal) : 0;

        $courses = [];

        foreach($order->items as $item){
            if(str_contains($item->name, 'RePL')){

                $courses[] = array(
                    'name' => '7kg RePL Commercial Course (RePL)',
                    'price' => 1350,
                    'quantity' => $item->quantity,
                    'discount' => isset($item->couponAmount) ? $this->getOrderPercentage($item->couponAmount) : $discount
                );

                if(in_array($item->name, ['RePL Commercial Professional', 'RePL Commercial Essentials'])){
                    $courses[] = array(
                        'name' => 'Aeronautical Radio Operator Certificate (AROC)',
                        'price' => 400,
                        'quantity' => $item->quantity,
                        'discount' => isset($item->couponAmount) ? $this->getOrderPercentage($item->couponAmount) : $discount
                    );
                }

                if($item->name == 'RePL Commercial Professional'){
                    $courses[] = array(
                        'name' => 'Remote Operator Certificate (ReOC)',
                        'price' => 2000,
                        'quantity' => $item->quantity,
                        'discount' => isset($item->couponAmount) ? $this->getOrderPercentage($item->couponAmount) : $discount
                    );
                }
            } else if($item->name == 'ReOC - Student Upgrade') {
                $courses[] = array(
                    'name' => 'Remote Operator Certificate (ReOC)',
                    'price' => 2000,
                    'quantity' => $item->quantity,
                    'discount' => isset($item->couponAmount) ? $this->getOrderPercentage($item->couponAmount) : $discount
                );
            } else {
                $courses[] = array(
                    'name' => $item->name,
                    'price' => $item->productPrice == $item->price ? $item->productPrice : $item->price,
                    'quantity' => $item->quantity,
                    'discount' => isset($item->couponAmount) ? $this->getOrderPercentage($item->couponAmount) : $discount
                );
            }

            if(!empty($item->selectedOptions[0]->selections)){
                foreach($item->selectedOptions as $selectedOption){
                    if($selectedOption->name == 'Alumni') break;
                    foreach($selectedOption->selections as $selection){
                        $selectionName = str_replace(['Add ','Upgrade to ', ' (save $250)'], '', $selection->selectionTitle);
                        $courses[] = array(
                            'name' => $selectionName,
                            'price' => $selection->selectionModifier,
                            'quantity' => 1,
                            'discount' => 0
                        );
                    }
                }
            }
        }
        return $courses;
    }

    private function getOrderPercentage($discount,$price){

        return ($discount/$price)*100;

    }

}

