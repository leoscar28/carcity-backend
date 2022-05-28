<?php

namespace App\Helpers;

class Curl
{
    public function verifyData($signature)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "14579",
            CURLOPT_URL => "http://127.0.0.1:14579/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n    \"version\": \"1.0\",\n    \"method\": \"XML.verify\",\n    \"params\": {\n        \"xml\":\"".addslashes($signature)."\"\n    }\n}",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 7cba8c1b-29d5-5728-868f-26a35b218aa8"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return $err;
        }
        return json_decode($response,true);
    }
}
