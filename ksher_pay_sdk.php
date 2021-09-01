<?php
class KsherPay{
    public $gateway_domain;
    public $apiType ; //ksher appid
    public $token ;// 私钥
    public $provider;//ksher
    public $timeout;
    public $time;
    public $apiEndpoint;

    public function __construct($gateway_domain='', $token='', $apiType='redirect', $provider='Ksher', $timeout=15){
        
        $this->gateway_domain = $gateway_domain;
        $this->apiType = $apiType;
        $this->token = $token;
        $this->provider = $provider;
        $this->timeout = $timeout;
        if($apiType == 'cscanb'){
            $this->apiEndpoint='/api/v1/cscanb/orders';
        }
        else{
            $this->apiEndpoint='/api/v1/redirect/orders';
        }
        $this->time = date("YmdHis", time());

    }

    /**
     * 生成sign
     * @param $data
     * @param $private_key_content
     */
    public function ksher_sign($endpoint, $data){
     

        $message = $endpoint . self::paramData( $data );
        $encoded_sign = hash_hmac(
            "sha256",
            $message,
            $this->token
        );
        // echo "<p>";
        // echo "endpoint:" . $endpoint . "<br/>";
        // echo "message:" . $message . "<br/>";
        // echo "sigature:" . $encoded_sign . "<br/>";
        // echo "</p>";
        return $encoded_sign;
    }
    /**
     * 验证签名
     */
    public function verify_ksher_sign($url, $data){
        // in api reponse url will be the api endpoit 
        // in webhook request url will be the whole url string of webhook

        $resp_sign = $data["signature"];
        unset($data["signature"]);
        unset($data["log_entry_url"]);

        $message = $url . self::paramData( $data );

        $encoded_sign = strtoupper(hash_hmac(
            "sha256",
            $message,
            $this->token
        ));
        
        // echo "<p>";
        // echo "verify_ksher_sign <br/>";
        // echo "url:" . $url . "<br/>";
        // echo "message:" . $message . "<br/>";
        // echo "sigature:" . $encoded_sign . "<br/>";
        // echo "resp signature:" . $resp_sign . "<br/>";
        // echo "</p>";
        // $res = openssl_get_publickey($this->pubkey);
        // $result = openssl_verify($message, $sign, $res,OPENSSL_ALGO_MD5);
        // openssl_free_key($res);
        return $encoded_sign == $resp_sign;
    }
    /**
     * 处理待加密的数据
     */
    private static function paramData($data){
        ksort($data);
        $message = '';
        foreach ($data as $key => $value) {
            if(is_bool($value)){
                if($value){
                    $value = "True";
                } else{
                    $value = "False";
                }
            }
                
            $message .= $key . $value;
        }
        $message = mb_convert_encoding($message, "UTF-8");
        return $message;
    }
    /**
     * @access get方式请求数据
     * @params url //请求地址
     * @params data //请求的数据，数组格式
     * */
    public function _request($endpoint, $method, $data=array()){

        try {
            
            $url = $this->gateway_domain . $endpoint;
            $http = curl_init();
            curl_setopt($http, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $data['signature'] = $this->ksher_sign($endpoint,$data);
            $postdata = json_encode($data);


            curl_setopt($http,CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($http,CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($http, CURLOPT_URL, $url);
            curl_setopt($http, CURLOPT_RETURNTRANSFER, TRUE);

            $output = curl_exec($http);
            $http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);

            curl_close($http);


            
            if($http_status == 200){
                $response_array = (json_decode($output, true));

            
                if(!$this->verify_ksher_sign($endpoint, $response_array)){
                    $temp = array(
                                "err_code"=> "VERIFY_KSHER_SIGN_FAIL",
                                "err_msg"=> "verify signature failed",
                                "result"=> "FAIL"
                    );
                    return json_encode($temp);
                }

            }
       
            
            
            return $output;
        } catch (Exception $e) {
            echo 'curl error';
            return false;
        }
    }
   


    public function create($data){
        $data['timestamp'] = $this->time;
        $response = $this->_request($this->apiEndpoint, 'POST', $data);
        return $response;
    }

    public function query($order_id, $data){
        $data['timestamp'] = $this->time;
        $queryURL = $this->apiEndpoint . '/' . $order_id;
        $response = $this->_request($queryURL, 'GET', $data);
        return $response;
    }

    public function refund($order_id, $data){
        $data['timestamp'] = $this->time;
        $queryURL =$this->apiEndpoint . '/' . $order_id;
        $response = $this->_request($queryURL, 'PUT', $data);
        return $response;
    }
    public function void($order_id, $data){
        $data['timestamp'] = $this->time;
        $queryURL = $this->apiEndpoint . '/' . $order_id;
        $response = $this->_request($queryURL, 'DELETE', $data);
        return $response;
    }
}