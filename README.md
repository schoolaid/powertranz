# Powertranz Client
This package is a minimal client for BAC Powertranz, now it's just a simple client.

## Actions supported
✅ Alive<br>
```php
use SchoolAid\Powertranz\Actions\Alive;

$response = Alive::getInstance()->submit()
```
✅ Capture<br>
```php
use SchoolAid\Powertranz\Requests\PowertranzBody;
use SchoolAid\Powertranz\Actions\Capture;

$body = PowertranzBody::capturePowertranzBody($transactionIdentifier, $amount, $externalIdentifier)
$response = Capture::getInstance()->setBody($body)->submit()
```
✅ Refund<br>
Used to rollback a transaction.
```php
use SchoolAid\Powertranz\Requests\PowertranzBody;
use SchoolAid\Powertranz\Actions\Refund;

$body = PowertranzBody::refundPowertranzBody($transactionIdentifier, $amount, $externalIdentifier)
$response = Refund::getInstance()->setBody($body)->submit()
```
✅ Revert<br>
Used to rollback an authorization, on the api as: api/void

```php
use SchoolAid\Powertranz\Requests\PowertranzBody;
use SchoolAid\Powertranz\Actions\Revert;

$body = PowertranzBody::voidPowertranzBody($transactionIdentifier, $cardId)
$response = Revert::getInstance()->setBody($body)->submit()
```
✅ Sale<br>
```php
use SchoolAid\Powertranz\Requests\PowertranzBody;
use SchoolAid\Powertranz\Actions\Sale;

$body = PowertranzBody::powertranzBody(
    $transactionId,
    $orderId,
    $cardPan,
    $cardCvv, //yyMM format
    $cardExpiration,
    $cardName,
    $billingAddress
)
$response = Sale::getInstance()->setBody($body)->submit()
```
✅ SPIAuth<br>
```php
use SchoolAid\Powertranz\Requests\PowertranzBody;
use SchoolAid\Powertranz\Actions\SPIAuth;

$body = PowertranzBody::powertranzBody(
    $transactionId,
    $orderId,
    $cardPan,
    $cardCvv, //yyMM format
    $cardExpiration,
    $cardName,
    $billingAddress
)
$response = SPIAuth::getInstance()->setBody($body)->submit()
```
✅ SPIPayment<br>
```php
use SchoolAid\Powertranz\Requests\PowertranzBody;
use SchoolAid\Powertranz\Actions\SPIPayment;

$spiToken = '...';
$response = SPIPayment::getInstance()->setToken($token)->submit()
```
✅ SPISale
```php
use SchoolAid\Powertranz\Requests\PowertranzBody;
use SchoolAid\Powertranz\Actions\SPISale;

$body = PowertranzBody::powertranzBody(
    $transactionId,
    $orderId,
    $cardPan,
    $cardCvv, //yyMM format
    $cardExpiration,
    $cardName,
    $billingAddress
)
$response = SPISale::getInstance()->setBody($body)->submit()
```
❌ SPIRiskMgmt<br>

## Other ways to build the body
PowertranzBody class provides another way to generate sales body from other ways.

```php
use Schoolaid\Powertranz\Entities\PowertranzCreditCard;
use SchoolAid\Powertranz\Requests\PowertranzBody;

$cc = new PowertranzCreditCard($id, $pan, $cvv, $expDate, $name, ?$billingAddress)

$body = PowertranzBody::fromCreditCard($cc);
$voidBody = PowertranzBody::fromCreditCard($cc, $transactionId, true);

```

## Env variables to set:
```
POWERTRANZ_URL=https://staging.ptranz.com/
POWERTRANZ_ID=0000000
POWERTRANZ_PASSWORD=xxxxxxxx
POWERTRANZ_GATEWAY_KEY=xxxxxxx //set only if provided
POWERTRANZ_CALLBACK=https://localhost/authorize
```
