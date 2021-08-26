<?php $title = 'Ksher Demo'; include("partials/header.php");?>

<div class="p-3">
<!-- <p>Method: <?php print_r($_POST) ;?></p> -->
<?php
    include_once '../ksher_pay_sdk.php';
    $gateway_domain='https://sandboxbkk.vip.ksher.net';
    $token='186d6c953c90f39c2973e6dd2e110d4057194996ef08fb4b3338180517b509c7';
    set_time_limit(0);

    // for Cscanb API
    if($_POST["api_type"]=='cscanb'){
        
        $class = new KsherPay($gateway_domain, $token, 'cscanb');
        
        if($_POST["crud"]=='create'){

            $gateway_pay_data = array('merchant_order_id'=>$_POST["merchant_order_id"],
            "amount" => round($_POST["amount"], 2)*100,
            "channel" => $_POST["payment_ch"]);

            $gateway_pay_response = $class->create($gateway_pay_data);

            $gateway_pay_array = json_decode($gateway_pay_response, true);
            if($gateway_pay_array["status"] == 'Available'){
                echo "<h2> Successfully Create C Scan B Order</h2>";

                echo "\n<img src='" . $gateway_pay_array["reserved1"] . "'alt='payment qr code'>\n" ;
            }
            else{
                echo "<h2> Fail to Create C Scan B Order</h2>";
                echo "<p1> Here's the raw response</p1>";
                print_r($gateway_pay_response);
            }
        } else {
            $merchant_order_id = $_POST["merchant_order_id"];

            if($_POST["crud"]=='read'){
                $gateway_pay_response = $class->query($merchant_order_id,$gateway_pay_data);
                echo "<h2>gateway_pay_response:</h2>";
                echo "<p>";
                print_r($gateway_pay_response);
                echo "</p>";
            } else if($_POST["crud"]=='update'){
                $gateway_pay_response = $class->refund($merchant_order_id,$gateway_pay_data);
                $gateway_pay_data = array('refund_order_id'=>$_POST["refund_order_id"],
                "refund_amount" => round($_POST["refund_amount"], 2)*100);
                echo "<h2>gateway_pay_response:</h2>";
                echo "<p>";
                print_r($gateway_pay_response);
                echo "</p>";
                return;
            } else if($_POST["crud"]=='delete'){
                $gateway_pay_response = $class->void($merchant_order_id,$gateway_pay_data);
                echo "<h2>gateway_pay_response:</h2>";
                echo "<p>";
                print_r($gateway_pay_response);
                echo "</p>";
                return;
            }
            else{
                echo '<h2>ERROR Unknow Crud Command</h2>';
                return;
            }

        }
        
    
        // for Redirect API
    }else{
        // create redirect order
        
        $class = new KsherPay($gateway_domain, $token, 'redirect');
        if($_POST["crud"]=='create'){
            $gateway_pay_data = array('merchant_order_id'=>$_POST["merchant_order_id"],
                "amount" => round($_POST["amount"], 2)*100,
                "channel" => 'bbl_promptpay,wechat,alipay,truemoney,airpay,linepay,ktbcard',
                'redirect_url' => 'https://www.google.com',
                'redirect_url_fail' => 'http://www.yahoo.com'
                );
            $gateway_pay_response = $class->create($gateway_pay_data);

            $gateway_pay_array = json_decode($gateway_pay_response, true);
            if($gateway_pay_array["status"] == 'Available'){
                echo "<h2> Successfully Create Redirect Order</h2>";
    
                echo "\n<a href='" . $gateway_pay_array["reference"] . "' alt='payment link'> Payment Link </a>\n" ;
            }
            else{
                echo "<h2> Fail to create Redirect Order</h2>";
                echo "<p1> Here's the raw response </p1>";
                echo $gateway_pay_response;
                print_r($gateway_pay_response);
                // echo "---------------------";
    
    
            }
        }
        else {
            $merchant_order_id = $_POST["merchant_order_id"];
            $gateway_pay_data = array();
            if($_POST["crud"]=='read'){
                $gateway_pay_response = $class->query($merchant_order_id, $gateway_pay_data);
                echo "<h2>gateway_pay_response:</h2>";
                echo "<p>";
                print_r($gateway_pay_response);
                echo "</p>";
                // echo "---------------------";
            } else if($_POST["crud"]=='update'){
                $gateway_pay_data['refund_order_id'] = $_POST["refund_order_id"];
                $gateway_pay_data['refund_amount'] = round($_POST["refund_amount"], 2)*100 ;

                $gateway_pay_response = $class->refund($merchant_order_id,$gateway_pay_data);
                
                echo "<h2>gateway_pay_response:</h2>";
                echo "<p>";
                print_r($gateway_pay_response);
                echo "</p>";

            } else if($_POST["crud"]=='delete'){
                $gateway_pay_response = $class->void($merchant_order_id,$gateway_pay_data);
                echo "<h2>gateway_pay_response:</h2>";
                echo "<p>";
                print_r($gateway_pay_response);
                echo "</p>";
            }
            else{
                echo '<h2>ERROR Unknow Crud Command</h2>';
            }

        }

    }
    
    
    
    
?>

<article>
<br style="clear: both" />
</article>

<!-- <?php include("partials/footer.php");?> -->