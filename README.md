# payment_sdk_php

> Ksher will shut down the API connection via .vip.ksher.net. That make new register merchant will unable to use system over .vip.ksher.net.
>
> Merchants are currently connected, Please change the API to connection http://api.ksher.net.

php sdk to communicate with ksher payment gateway

## How to Demo
1. open runSDK.php
2. uncomment and adjust gateway_domain and token to the one given to you by ksher
```php
$gateway_domain='https://sandboxbkk.vip.ksher.net';
$token=token123;
```
3. run php 
```shell
php -S localhost:5000 -t ./views/
```
