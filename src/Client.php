<?php 

namespace Ubitcorp\DebugHost;

class Client{

    protected $api_url  = "https://debughost/logs";
    protected $api_key, $api_secret;
    protected $error;
    
    public function __construct($api_key, $api_secret)
    {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
        
        return $this;
    }

    public function storeLogs(){
        $data =  array(
            "project_id"  => $this->request->data['project_id'],
            "message"     => $this->request->data['message'],
            "detail"      => array(
                                "code" => $this->request->data['detail']['code'],
                                "file" => $this->request->data['detail']['file'],
                                "line" => $this->request->data['detail']['line']
                            ),
            "from"        => $this->request->data['from'],
            "class"       => $this->request->data['class'],
            "status_code" => $this->request->data['status_code']
        );

        $make_call = callAPI('POST', 'https://debughost/logs', json_encode($data));
        $response = json_decode($make_call, true);
        $errors   = $response['response']['errors'];
        $data     = $response['response']['data'][0];
 
        return $data;
    }

    private function callAPI($method, $url, $data){
       $curl = curl_init();

       $header = [
            'Accept: application/json',
            'api_key: '.$this->api_key,
            'api_secret: '.$this->api_secret          
        ];

       curl_setopt_array($curl, [
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POST => 1,
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => 1
        ]);

       // EXECUTE:
       $result = curl_exec($curl);

       if(!$result)
            {die("Connection Failure");}

       curl_close($curl);

       return $result;
    }

}