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
                $gateway_pay_response = $class->cancel($merchant_order_id,$gateway_pay_data);
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
        
    } else if($_POST["api_type"]=='bscanc'){
        
        $class = new KsherPay($gateway_domain, $token, 'bscanc');
        
        if($_POST["crud"]=='create'){

            $bscanc_data = array('merchant_order_id'=>$_POST["merchant_order_id"],
            "mid" => "mch38026",
            "amount" => round($_POST["amount"], 2)*100,
            "channel" => $_POST["payment_ch"],
            "auth_code" => $_POST["auth_code"]);

            $bscanc_response = $class->create($bscanc_data);

            $bscanc_array = json_decode($bscanc_response, true);
            if($bscanc_array["status"] == 'Available' || $bscanc_array["status"] == 'Paid') {
                echo "<h2> Successfully Create & Paid B Scan C Order</h2>";

                echo "\n<img src='" . $bscanc_array["reserved1"] . "'alt='payment qr code'>\n" ;
            }
            else{
                echo "<h2> Fail to Create B Scan C Order</h2>";
                echo "<p1> Here's the raw response</p1>";
                print_r($bscanc_response);
            }
        } else {
            $merchant_order_id = $_POST["merchant_order_id"];

            if($_POST["crud"]=='read'){
                $bscanc_response = $class->query($merchant_order_id,$bscanc_data);
                echo "<h2>gateway_pay_response:</h2>";
                echo "<p>";
                print_r($bscanc_response);
                echo "</p>";
            } else if($_POST["crud"]=='update'){
                $bscanc_data = array(
                    "mid" => "mch38026",
                    "refund_amount" => round($_POST["refund_amount"], 2)*100,
                    "refund_order_id" => $_POST["refund_order_id"]);
                $bscanc_response = $class->refund($merchant_order_id,$bscanc_data);
                echo "<h2>gateway_pay_response:</h2>";
                echo "<p>";
                print_r($bscanc_response);
                echo "</p>";
                return;
            } else if($_POST["crud"]=='delete'){
                $bscanc_response = $class->cancel($merchant_order_id,$bscanc_data);
                echo "<h2>gateway_pay_response:</h2>";
                echo "<p>";
                print_r($bscanc_response);
                echo "</p>";
                return;
            }
            else{
                echo '<h2>ERROR Unknow Crud Command</h2>';
                return;
            }

        }
    } else if($_POST["api_type"]=='channels'){
        $class = new KsherPay($gateway_domain, $token, 'finance');

        $channels_data = array("mid" => "mch35618");
        $channels_response = $class->channels($channels_data);
        $channels_array = json_decode($channels_response, true);
        if($channels_array["error_code"] == 'SUCCESS'){
            echo "<h2> Successfully Check channels</h2>";
            echo "<p1> Here's channels available to paid </p1>";
            echo "</br>";
            foreach($channels_array["data"]["channels"] as $value) {
                echo $value . "</br>";
            }
        } else{
            echo "<h2> Fail to Check channels</h2>";
            echo "<p1> Here's the raw response </p1>";
            print_r($channels_array);
        }

    } else if($_POST["api_type"]=='order'){
        $class = new KsherPay($gateway_domain, $token, 'finance');

        $finance_order_data = array("mid" => "mch35618",
        "offset" => 0,
        "limit" => 50);
        $yyyymmdd = $_POST["yyyymmdd"];
        echo "yyyymmdd: ".$yyyymmdd;
        $finance_order_response = $class->order($yyyymmdd, $finance_order_data);
        $finance_order_array = json_decode($finance_order_response, true);

        if($finance_order_array["error_code"] == 'SUCCESS'){
            echo "<h2> Successfully Check transaction report</h2>";
            echo "<p1> Here's transaction report </p1>";
            echo "<table>";
            foreach ($finance_order_array["data"]["data"] as $transaction) {
                echo "<tr>";
                foreach($transaction as $key => $val) {
                    echo "<td>$key = $val</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else{
            echo "<h2> Fail to Check transaction report</h2>";
            echo "<p1> Here's the raw response </p1>";
            print_r($finance_order_array);
        }


    } else if($_POST["api_type"]=='settlements'){
        $class = new KsherPay($gateway_domain, $token, 'finance');

        $settlements_data = array("mid" => "mch35618",
        "channel" => $_POST["payment_ch"]);
        $yyyymmdd = $_POST["yyyymmdd"];
        $settlements_response = $class->settlements($yyyymmdd, $settlements_data);
        $settlements_array = json_decode($settlements_response, true);

        echo "<h2> Successfully Check channels</h2>";
        echo "<p1> Here's the raw response </p1>";
        print_r($settlements_array);

    } else if($_POST["api_type"] == 'settlement_order'){
        $class = new KsherPay($gateway_domain, $token, 'finance');

        $settlement_order_data = array(
        "offset" => 0,
        "limit" => 50,
        "reference_id" => $_POST["reference"]);
        $settlement_order_response = $class->settlement_order($settlement_order_data);
        $settlement_order_array = json_decode($settlement_order_response, true);

        if($settlement_order_array["error_code"] == 'SUCCESS'){
            echo "<h2> Successfully send settlement_order</h2>";
            echo "<p1> Here's the raw response </p1>";
            echo "<table>";
            foreach ($settlement_order_array["data"]["data"] as $transaction) {
                echo "<tr>";
                foreach($transaction as $key => $val) {
                    echo "<td>$key = $val</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<h2> Fail to send settlement_order</h2>";
            echo "<p1> Here's the raw response </p1>";
            print_r($settlement_order_response);
            }
     } else if($_POST["api_type"]=='miniapp'){
        
        $class = new KsherPay($gateway_domain, $token, 'miniapp');
        if($_POST["crud"]=='create'){

            $miniapp_data = array('merchant_order_id'=>$_POST["merchant_order_id"],
            "amount" => round($_POST["amount"], 2)*100,
            "channel" => $_POST["payment_ch"],
            "miniapp_openid" => $_POST["miniapp_openid"],
            "miniapp_appid" => $_POST["miniapp_appid"]
        );
    
            $miniapp_response = $class->create($miniapp_data);

            $miniapp_array = json_decode($miniapp_response, true);
            if($miniapp_array["status"] == 'Available'){
                echo "<h2> Successfully Create miniapp Order</h2>";
                echo "<p1> Here's the raw response</p1>";
                print_r($miniapp_response);
            }
            else{
                echo "<h2> Fail to Create miniapp Order</h2>";
                echo "<p1> Here's the raw response</p1>";
                print_r($miniapp_response);
            }
        } else {
            $merchant_order_id = $_POST["merchant_order_id"];
            $miniapp_data = array();
            if($_POST["crud"]=='read'){
                $miniapp_response = $class->query($merchant_order_id,$miniapp_data);
                echo "<h2>miniapp_response:</h2>";
                echo "<p>";
                print_r($miniapp_response);
                echo "</p>";
            } else if($_POST["crud"]=='update'){
                $miniapp_response = $class->refund($merchant_order_id,$miniapp_data);
                $miniapp_data = array('refund_order_id'=>$_POST["refund_order_id"],
                "refund_amount" => round($_POST["refund_amount"], 2)*100);
                echo "<h2>miniapp_response:</h2>";
                echo "<p>";
                print_r($miniapp_response);
                echo "</p>";
                return;
            } else if($_POST["crud"]=='delete'){
                $miniapp_response = $class->cancel($merchant_order_id,$miniapp_data);
                echo "<h2>gateway_pay_response:</h2>";
                echo "<p>";
                print_r($miniapp_response);
                echo "</p>";
                return;
            }
            else{
                echo '<h2>ERROR Unknow Crud Command</h2>';
                return;
            }

        }
        
    } else{
        // create redirect order
        
        $class = new KsherPay($gateway_domain, $token, 'redirect');
        if($_POST["crud"]=='create'){
            $gateway_pay_data = array('merchant_order_id'=>$_POST["merchant_order_id"],
                "amount" => round($_POST["amount"], 2)*100,
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
                $gateway_pay_response = $class->cancel($merchant_order_id,$gateway_pay_data);
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