<?php

namespace App\Services;

use Monday;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class MondayService {

    public function request($query){
        $headers = ['Content-Type: application/json', 'Authorization: ' . config('monday.monday_token')];
        $data = @file_get_contents(config('monday.monday_url'), false, stream_context_create([
         'http' => [
          'method' => 'POST',
          'header' => $headers,
          'content' => json_encode(['query' => $query]),  
         ]
        ]));

        return $this->response($data);
    }

    public function response($data){
      if(!$data) return false;

      $json = json_decode($data, true);

      return $json;
    }

    public function addSubItem($parentId, $items){

      foreach($items as $item){
        $query = 'mutation {
          create_subitem (
            parent_item_id: '.$parentId.', 
            item_name: "'.$item['name'].'", 
            column_values:"{
              \"dropdown9\": \"'.$item['name'].'\", 
              \"numbers4\":'.$item['quantity'].', 
              \"numbers\":'.$item['price'].', 
              \"numbers5\":'.$item['discount'].'
            }"
          ) {
            id
            board {
                id
            }
          }
        }';

        $this->request($query);

      }
      
    }

}

