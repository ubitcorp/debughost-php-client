<?php 

namespace Ubitcorp\DebugHost;

class Client{

    // Properties
    protected $api_url  = "https://dh.kuzen.net/api/logs";
    protected $api_key, $api_secret;

    // Auth with Api Key and Api Secret
    public function __construct($api_key, $api_secret)
    {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
        
        return $this;
    }

    // Receive data from client
    public function storeLogs($message, $status_code, $detail = null, $from = null, $class = null)
    {
        $data = [
            "message" => $message,
            "status_code" => $status_code,
            "detail" => json_decode($detail),
            "from" => $from,
            "class" => $class
        ];

        $header = [
            'Accept: application/json',
            'Api-Key: '.$this->api_key,
            'Api-Secret: '.$this->api_secret          
        ];

        return $this->callAPI($this->api_url, 'POST', $header, $data);
    }

    // Post data to Debughost
    private function callAPI($url, $method, $header, $data)
    {
        
       $curl = curl_init();

       curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ]);

        $response = curl_exec($curl);        
       
        if(!$response)
            throw new \Exception("Connection Failure");

        $result = json_decode($response);

        curl_close($curl);

        return $result;
    }

}
