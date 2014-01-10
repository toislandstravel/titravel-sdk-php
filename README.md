# TiTravel API SDK for PHP

[![Latest Stable Version](https://poser.pugx.org/titravel/api-sdk-php/v/stable.png)](https://packagist.org/packages/titravel/api-sdk-php) [![Total Downloads](https://poser.pugx.org/titravel/api-sdk-php/downloads.png)](https://packagist.org/packages/titravel/api-sdk-php)

This repository contains To Islands Travel's PHP SDK and samples for our API

## Prerequisites

   * PHP 5.3 or above
   * curl extension must be enabled
   * json extension must be enabled
   * composer for fetching dependencies (See http://getcomposer.org)

## Samples

   * [Running the samples](samples/)

## Usage

To write an app that uses the SDK:

    * add 'titravel/api-sdk-php' to your 'composer.json' require list or copy the [samples/composer.json] to your project's root
    * run 'composer update --no-dev' to fetch dependencies
    * obtain API credentials from [To Islands Travel](http://www.titravel.hr/)
    * now you are all set to make your first API call

```php
$apiCredentials = new \TiTravel\Auth\Credentials($config['b2b'], $config['code']);

try {
    $params = array(
        'city_id' => null,
        'category_id' => null,
    );
    $properties = PropertiesInfo::all($params, $apiCredentials);
} catch (Exception $ex) {
    echo 'Exception:', $ex->getMessage(), PHP_EOL;
    exit(1);
}

print_r($properties->toArray());
```