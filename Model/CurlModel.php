<?php

class CurlModel {

    private $curl_api_conn;
    private array $options = [];
    private $response;
    private $file;
    
    public function __construct(String $url, String $method){
        $this->curl_api_conn = curl_init();
        $this->options[CURLOPT_URL] = $url;
        $this->options[CURLOPT_RETURNTRANSFER] = true;
        $this->options[CURLOPT_FOLLOWLOCATION] = true;
        $this->options[CURLOPT_ENCODING] = "";
        $this->options[CURLOPT_MAXREDIRS] =10;
        $this->options[CURLOPT_HTTP_VERSION ]=CURL_HTTP_VERSION_1_1;
        $this->options[CURLOPT_TIMEOUT] =30;
        $this->options[CURLOPT_CUSTOMREQUEST] = strtoupper($method);
        if(!empty($_FILES) && $method=='post'){
            $this->file = new CURLFile($_FILES['foto']['tmp_name'], $_FILES['foto']['type'], $_FILES['foto']['name']);
            $_POST['foto']=$this->file;
        }
        if(strtoupper($method) === 'POST'){
            $this->options[CURLOPT_POSTFIELDS] = $_POST;
        }
        curl_setopt_array($this->curl_api_conn, $this->options);
    }

    public function peticion(){
        $this->response = curl_exec($this->curl_api_conn);
        curl_close($this->curl_api_conn);
        return $this->response;
    }

}

?>