# payment_sdk_php
php sdk to communicate with ksher payment gateway

## How to Demo
1. open demo_redirectPay.php
2. uncomment and adjust gateway_domain and token to the one given to you by ksher
```php
$gateway_domain='https://sandboxbkk.vip.ksher.net';
$token=token123;
```
3. adjust merchant_order_id to some unique id
```php
$merchant_order_id='phpsdk000001';
```
4. run the scipt
```shell
php demo_redirectPay.php

```