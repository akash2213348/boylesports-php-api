Boylesports PHP API
======================

This is a simple PHP implementation for [Boylesports API](https://boylesports.com/).

Installation
------------

You can either get the files from GIT or you can install the library via [Composer](getcomposer.org). To use Composer, simply add the following to your `composer.json` file.

```json
{
    "require": {
        "sharapov/boylesports-php-api": "dev-master"
    }
}
```

How to use it?
--------------

```php
require_once "../vendor/autoload.php";

$api = new \Sharapov\BoylesportsPHP\BoylesportsAPI();

// Request examples

// get sports list
$response = $api->index()->json();

// get FOOTBALL bets
$response = $api->EURFOOTBALL()->json();

print '<pre>';
print_r( json_decode($response->getBody()->getContents()) );
print '</pre>';
```