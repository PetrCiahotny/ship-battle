<?php

class BattleApi
{
    public function process(){
        $response = [
            'status' => 'OK'
        ];
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
}

$api = new BattleApi();
$api->process();