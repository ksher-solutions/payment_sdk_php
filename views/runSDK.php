<?php $title = 'Ksher Demo'; include("partials/header.php");?>

<div class="p-3">
<!-- <p>Method: <?php print_r($_POST) ;?></p> -->
<?php
    include_once '../ksher_pay_sdk.php';
    // $gateway_domain='https://sandboxbkk.vip.ksher.net';
    // $token='';
    set_time_limit(0);

    // if create order on csanb
    if($_POST["api_type"]=='cscanb'){
        $gateway_pay_data = array('merchant_order_id'=>$_POST["merchant_order_id"],
        "amount" => round($_POST["amount"], 2)*100,
        "channel" => $_POST["payment_ch"]);
        $class = new KsherPay($gateway_domain, $token, 'cscanb');
        $gateway_pay_response = $class->create($gateway_pay_data);

        $gateway_pay_array = json_decode($gateway_pay_response, true);
        if($gateway_pay_array["status"] == 'Available'){
            echo "<h2> Successfully Create C Scan B Order</h2>";

            echo "\n<img src='" . $gateway_pay_array["reserved1"] . "'alt='payment qr code'>\n" ;
        }
        else{
            echo "<h2> Fail to Create C Scan B Order</h2>";
            echo "<p1> Here's the raw response</p1>";
            print_r(gateway_pay_array);
        }
        
    }else{
        // create redirect order
        $gateway_pay_data = array('merchant_order_id'=>$_POST["merchant_order_id"],
            "amount" => round($_POST["amount"], 2)*100,
            "channel" => 'bbl_promptpay,wechat,alipay,truemoney,airpay,linepay,ktbcard',
            'redirect_url' => 'https://www.google.com',
            'redirect_url_fail' => 'http://www.yahoo.com'
            );
        $class = new KsherPay($gateway_domain, $token, 'redirect');
        $gateway_pay_response = $class->create($gateway_pay_data);

        $gateway_pay_array = json_decode($gateway_pay_response, true);
        if($gateway_pay_array["status"] == 'Available'){
            echo "<h2> Successfully Create Redirect Order</h2>";

            echo "\n<a href='" . $gateway_pay_array["reference"] . "' alt='payment link'> Payment Link </a>\n" ;
        }
        else{
            echo "<h2> Fail to create Redirect Order</h2>";
            echo "<p1> Here's the raw response</p1>";
            print_r(gateway_pay_array);


        }
    }
    
    
    
    
?>

<article>
<br style="clear: both" />
</article>

<!-- <?php include("partials/footer.php");?> -->