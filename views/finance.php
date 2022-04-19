<?php $title = '1914'; include("partials/header.php");?>

<div class="p-3">
<h1>Financial API</h1>
<form name="financialAPI" action="./runSDK.php" method='post'>
  <div class="mb-3">
  </div>
  <div class="mb-3">
    <label for="api_id" class="form-label">Select API</label>
    <select id="api_id" name="api_type" class="form-select" aria-label="api_select" onchange="apiSelectChange()">
      <option selected value="channels">channels</option>
      <option value="order">order</option>
      <option value="settlements">settlements</option>
      <option value="settlement_order">settlement_order</option>
    </select>
  </div>

  <div class="mb-3" id="MenuYyyymmdd" style="display: none;">
    <label for="yyyymmdd" class="form-label">yyyymmdd</label>
    <input type="text" name="yyyymmdd" class="form-control" id="yyyymmdd_id" aria-describedby="mch_order_no_help">
  </div>

  <div class="mb-3" id="MenuPayment_ch" style="display: none;">
    <label for="payment_id" class="form-label">Select Payment Channel</label>
    <select id="payment_id" name="payment_ch" class="form-select" aria-label="payment_select">
      <option selected value='promptpay'>promptpay</option>
      <option value="truemoney">truemoney</option>
      <option value="linepay">linepay</option>
      <option value="alipay">alipay</option>
      <option value="wechat">wechat</option>
      <option value="airpay">airpay</option>
    </select>
  </div>

  <div class="mb-3" id="selectSettlement_order" style="display: none;">
    
    <label for="reference_id" class="form-label">reference_id</label>
    <div class="form-text">reference_id from settlements API</div>
    <input type="text" name="reference" class="form-control" id="reference_id" aria-describedby="mch_order_no_help">
  </div>

  <input type="hidden" name="crud" value="read">
  <button type="submit" class="btn btn-primary">Submit</button>
  
</form>
</div>

<script type="text/javascript">
    function apiSelectChange() {
      if (document.getElementById("api_id").value == 'channels') {
          document.getElementById("MenuYyyymmdd").style.display = "none";
          document.getElementById("MenuPayment_ch").style.display = "none";
          document.getElementById("selectSettlement_order").style.display = "none";
      } else if (document.getElementById("api_id").value == 'order') {
          document.getElementById("MenuYyyymmdd").style.display = "block";
          document.getElementById("MenuPayment_ch").style.display = "none";
          document.getElementById("selectSettlement_order").style.display = "none";
      } else if (document.getElementById("api_id").value == 'settlements') {
          document.getElementById("MenuYyyymmdd").style.display = "block";
          document.getElementById("MenuPayment_ch").style.display = "block";
          document.getElementById("selectSettlement_order").style.display = "none";
      }
       else {
        document.getElementById("MenuYyyymmdd").style.display = "none";
          document.getElementById("MenuPayment_ch").style.display = "none";
          document.getElementById("selectSettlement_order").style.display = "block";
      }
    }
</script>

<article>
<br style="clear: both" />
</article>

<!-- <?php include("partials/footer.php");?> -->