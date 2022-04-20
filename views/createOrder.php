<?php $title = '1914'; include("partials/header.php");?>

<div class="p-3">
<h1>Create Order</h1>
<form name="createOrder" action="./runSDK.php" method='post'>
  <div class="mb-3">
    <label for="merchant_order_id" class="form-label">merchant_order_id</label>
    <input type="text" name="merchant_order_id" class="form-control" id="merchant_order_id" aria-describedby="mch_order_no_help">
    <div id="mch_order_no_help" class="form-text">A unique order id to identifie a particular order</div>
  </div>
  <div class="mb-3">
    <label for="amount_id" class="form-label">Amount(THB)</label>
    <input type="text" name="amount" class="form-control" id="amount_id" aria-describedby="mch_order_no_help">
    <div id="mch_order_no_help" class="form-text">a amount to be charge on this order eg: 100 (charging 100 bath)</div>
  </div>
  <div class="mb-3">
    <label for="api_id" class="form-label">Select API</label>
    <select id="api_id" name="api_type" class="form-select" aria-label="api_select" onchange="apiSelectChange()" onload="apiSelectChange()">
      <option selected value="redirect">Redirect</option>
      <option value="cscanb">Cscanb</option>
      <option value="bscanc">BscanC</option>
      <option value="miniapp">MiniApp</option>
    </select>
  </div>

  <div class="mb-3" id="MenuAuth_code" style="display: none;">
    <label for="auth_code" class="form-label">auth_code</label>
    <input type="text" name="auth_code" class="form-control" id="auth_code" aria-describedby="mch_order_no_help">
  </div>

  <div class="mb-3" id="MenuMiniapp" style="display: none;">
    <label for="miniapp_openid" class="form-label">miniapp_openid</label>
    <input type="text" name="miniapp_openid" class="form-control" id="miniapp_openid_id" aria-describedby="mch_order_no_help">
    <label for="miniapp_appid" class="form-label">miniapp_appid</label>
    <input type="text" name="miniapp_appid" class="form-control" id="miniapp_appid_id" aria-describedby="mch_order_no_help">
  </div>


  <div class="mb-3" id="MenuPayment_ch" style="display: none;">
  <label for="payment_id" class="form-label">Select Payment Channel</label>
  <select id="payment_id" name="payment_ch" class="form-select" aria-label="payment_select"></select>
  </div>

  <input type="hidden" name="crud" value="create">
  <button type="submit" class="btn btn-primary">Submit</button>
  
</form>
</div>


<script type="text/javascript">
    function apiSelectChange() {
      var channel = {};
      channel["cscanb"] = ["promptpay","truemoney","airpay","alipay","wechat"];
      channel["bscanc"] = ["truemoney","linepay","airpay","alipay","wechat"];
      channel["miniapp"] = ["wechat","alipay"];

      var payment = document.getElementById("payment_id")
            var api = document.getElementById("api_id").value;
            while (payment.options.length) {
              payment.remove(0);
            }
            var channel_api = channel[api];
            if (channel_api) {
              var i;
              for (i = 0; i < channel_api.length; i++) {
                var channel_value = new Option(channel_api[i], channel_api[i]);
                payment.options.add(channel_value);
              }
            }

        if (document.getElementById("api_id").value == 'cscanb') {
            document.getElementById("MenuAuth_code").style.display = "none";
            document.getElementById("MenuMiniapp").style.display = "none";
            document.getElementById("MenuPayment_ch").style.display = "block";
            
        } else if(document.getElementById("api_id").value == 'bscanc'){
            document.getElementById("MenuAuth_code").style.display = "block";
            document.getElementById("MenuMiniapp").style.display = "none";
            document.getElementById("MenuPayment_ch").style.display = "block";
        } else if(document.getElementById("api_id").value == 'miniapp'){
            document.getElementById("MenuAuth_code").style.display = "none";
            document.getElementById("selectMiniapp").style.display = "block";
            document.getElementById("MenuPayment_ch").style.display = "block";
        }
        else {
            document.getElementById("MenuAuth_code").style.display = "none";
            document.getElementById("MenuMiniapp").style.display = "none";
            document.getElementById("MenuPayment_ch").style.display = "none";
        }
    }
  </script>
<article>
<br style="clear: both" />
</article>

<!-- <?php include("partials/footer.php");?> -->