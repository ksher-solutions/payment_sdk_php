<?php $title = '1914'; include("partials/header.php");?>

<div class="p-3">
<h1>Create CScanB Order</h1>
<form name="cscanbCreate" action="./runSDK.php" method='post'>
  <div class="mb-3">
    <label for="merchant_order_id" class="form-label">mch_order_no</label>
    <input type="text" name="merchant_order_id" class="form-control" id="merchant_order_id" aria-describedby="mch_order_no_help">
    <div id="mch_order_no_help" class="form-text">merchant_order_id to be query</div>
  </div>
  <div class="mb-3">
    <label for="api_id" class="form-label">Select API</label>
    <select id="api_id" name="api_type" class="form-select" aria-label="api_select" onchange="apiSelectChange()">
      <option selected value='redirect'>Redirect</option>
      <option value="cscanb">Cscanb</option>
    </select>
  </div>



  <input type="hidden" name="crud" value="read">
  <button type="submit" class="btn btn-primary">Submit</button>
  
</form>
</div>



<article>
<br style="clear: both" />
</article>

<!-- <?php include("partials/footer.php");?> -->