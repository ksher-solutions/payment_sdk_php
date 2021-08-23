<?php $title = '1914'; include("partials/header.php");?>

<div class="p-3">
<h1>Create CScanB Order</h1>
<form name="cscanbCreate" action="./runSDK.php" method='post'>
  <div class="mb-3">
    <label for="merchant_order_id" class="form-label">mch_order_no</label>
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
    <select id="api_id" name="api_type" class="form-select" aria-label="api_select" onchange="apiSelectChange()">
      <option selected value='redirect'>Redirect</option>
      <option value="cscanb">Cscanb</option>
    </select>
  </div>

  <div class="mb-3" id="selectCscanb" style="display: none;">
    <label for="payment_id" class="form-label">Select Payment Channel</label>
    <select id="payment_id" name="payment_ch" class="form-select" aria-label="payment_select">
      <option selected value='promptpay'>promptpay</option>
      <option value="truemoney">truemoney</option>
    </select>
  </div>



  <input type="hidden" name="crud" value="create">
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