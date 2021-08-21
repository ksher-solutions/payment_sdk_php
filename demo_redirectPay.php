<?php
include_once 'ksher_pay_sdk.php';
// $gateway_domain='https://sandboxbkk.vip.ksher.net';
// $token=;
$local_total_fee = 10;//10 bath
$merchant_order_id='phpsdk000001';


set_time_limit(0);


echo "gateway_pay \n";
$class = new KsherPay($gateway_domain, $token, 'redirect');
$gateway_pay_data = array('merchant_order_id'=>$merchant_order_id,
    "amount" => round($local_total_fee, 2)*100,
    "channel" => 'bbl_promptpay,wechat,alipay,truemoney,airpay,linepay,ktbcard',
    'redirect_url' => 'https://www.google.cn',
    'redirect_url_fail' => 'http://www.yahoo.cn');
$gateway_pay_response = $class->create($gateway_pay_data);
echo 'gateway_pay_response:' . $gateway_pay_response;
$gateway_pay_array = json_decode($gateway_pay_response, true);
echo '<br />返回参数：<br />';
if (isset($gateway_pay_array['data']['pay_content'])){
    echo '<a href='.$gateway_pay_array['data']['pay_content'].'>pay 去支付</a>';
}else{
    print_r($gateway_pay_response);
}
exit();

