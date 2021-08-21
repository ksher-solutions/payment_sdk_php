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
    public function ksher_sign($data){
     

        $message = $this->apiEndpoint . self::paramData( $data );
        $encoded_sign = hash_hmac(
            "sha256",
            $message,
            $this->token
        );
        // $encoded_sign = bin2hex($encoded_sign);
        echo "message:" . $message . "\n";
        echo "sigature:" . $encoded_sign . "\n";
        return $encoded_sign;
    }
    /**
     * 验证签名
     */
    public function verify_ksher_sign( $data, $sign){
        // $sign = pack("H*",$sign);
        echo "\n verify_ksher_sign \n";
        echo 'data:' . $data;
        echo "\n'";
        $message = self::paramData( $data );
        $encoded_sign = hash_hmac(
            "sha256",
            $message,
            $this->token
        );
        // $res = openssl_get_publickey($this->pubkey);
        // $result = openssl_verify($message, $sign, $res,OPENSSL_ALGO_MD5);
        // openssl_free_key($res);
        return $encoded_sign == $sign;
    }
    /**
     * 处理待加密的数据
     */
    private static function paramData($data){
        ksort($data);
        $message = '';
        foreach ($data as $key => $value) {
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
    public function _request($url, $method, $data=array()){

        try {
            
            
            $http = curl_init();
            curl_setopt($http, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            
            if($method='POST'){
 
                $data['signature'] = $this->ksher_sign($data);
                $postdata = json_encode($data);
                // $fields_string = http_build_query($data);
                echo "postdata:".$postdata."/n";
                curl_setopt($http,CURLOPT_POST, true);
                curl_setopt($http,CURLOPT_POSTFIELDS, $postdata);
            }else{
                if(!empty($data) && is_array($data)){
                    $params = '';
                    $data['signature'] = $this->ksher_sign($data);
                    foreach($data as $temp_key =>$temp_value){
                        $params .= ($temp_key."=".urlencode($temp_value)."&");
                    }
                    if(strpos($url, '?') === false){
                        $url .= "?";
                    }
                    $url .= "&".$params;
                }
                curl_setopt($http, CURLOPT_URL, $url);
            }
            
            curl_setopt($http, CURLOPT_URL, $url);
            curl_setopt($http, CURLOPT_RETURNTRANSFER, TRUE);

            $output = curl_exec($http);
            $http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
            curl_close($http);
            echo "\n";
            echo "status_code" . $http_status . "\n";
            echo 'output:' . $output . "/n";

            
            if($status_code == 200){
                $response_array = json_decode($output, true);
                echo "response_array;\n\n";
                print_r($response_array);
                echo "\n";
                $resp_sign = $response_array["signature"];
                unset($response_array["signature"]);
                if(!$this->verify_ksher_sign($response_array, $resp_sign)){
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
        $response = $this->_request($this->gateway_domain . $this->apiEndpoint, 'POST', $data);
        return $response;
    }
}