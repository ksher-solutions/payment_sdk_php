<?php $title = '1914'; include("partials/header.php");?>

<div class="p-3">
<h1>query Order</h1>
<form name="queryOrder" action="./runSDK.php" method='post'>
  <div class="mb-3">
    <label for="merchant_order_id" class="form-label">merchant_order_id</label>
    <input type="text" name="merchant_order_id" class="form-control" id="merchant_order_id" aria-describedby="mch_order_no_help">
    <div id="mch_order_no_help" class="form-text">a order id that you want to refund</div>
  </div>
  <div class="mb-3">
    <label for="refund_order_id" class="form-label">refund_order_id</label>
    <input type="text" name="refund_order_id" class="form-control" id="refund_order_id" aria-describedby="refund_order_id_help">
    <div id="refund_order_id_help" class="form-text">Another unique id to identify this refund transaction</div>
  </div>
  <div class="mb-3">
    <label for="refund_amount_id" class="form-label">Refund Amount(THB)</label>
    <input type="text" name="refund_amount" class="form-control" id="refund_amount_id" aria-describedby="refund_amount_help">
    <div id="refund_amount_help" class="form-text">an amount you want to refund eg: 100 (refunding 100 bath)</div>
  </div>
  <div class="mb-3">
    <label for="api_id" class="form-label">Select API</label>
    <select id="api_id" name="api_type" class="form-select" aria-label="api_select" onchange="apiSelectChange()">
      <option selected value='redirect'>Redirect</option>
      <option value="cscanb">Cscanb</option>
    </select>
  </div>




  <input type="hidden" name="crud" value="update">
  <button type="submit" class="btn btn-primary">Submit</button>
  
</form>
</div>


<script type="text/javascript">
    function apiSelectChange() {
        if (document.getElementById("api_id").value == 'cscanb') {
            document.getElementById("selectCscanb").style.display = "block";
        } else {
            document.getElementById("selectCscanb").style.display = "none";
        }
    }
  </script>
<article>
<br style="clear: both" />
</article>

<!-- <?php include("partials/footer.php");?> -->