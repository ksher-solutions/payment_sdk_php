<?php $title = 'Ksher Demo'; include("partials/header.php");?>

<div class="p-3">
<p>Welcome to Ksher Payment PHP SDK Demo</p>
<p>Please navigate to the API You want to try out</p>
</div>

<?php 
$token = getenv('TOKEN');
$gateway_domain = getenv("GATEWAT_DOMAIN");
echo 'hellllll';
print_r($token);
print_r($gateway_domain);
?>
<article>
<br style="clear: both" />
</article>

<!-- <?php include("partials/footer.php");?> -->