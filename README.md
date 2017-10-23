# PHP Lazada API Wrapper

Unofficial PHP Wrapper for Lazada API

# Overview
* Wraps Lazada API in PHP according to example shown [here](https://lazada-sellercenter.readme.io/docs/signing-requests)
* For complete API reference, including how to obtain API key, please go to [the official documentation](https://lazada-sellercenter.readme.io)

# Installation
```
~$ composer require zuragan/lazada-api-php
```

# Example Usage

* GET

```php
//Create API instance
$api = new LazadaAPI($baseUrl);

//Create action using factory, get or post action is supported
$factory = new ActionFactory($userEmail, $userAPIKey);
$action = $factory->getAction('ActionName', [ 'Parameter' => 'ParamValue' ]);

//Execute API Command
$response = $api->get($action);

//debug: dump response
var_dump($response);
```

* POST

```php
//Create API instance
$api = new LazadaAPI($baseUrl);

//Create action using factory, get or post action is supported
$factory = new ActionFactory($userEmail, $userAPIKey);
$payload = [
    "Attributes" => [
        "name" => "Example",
        "description" => "Short description",
    ],
];
$action = $factory->postAction('ActionName', [ 'Parameter' => 'ParamValue' ], $payload);

//Execute API Command
$response = $api->post($action);

//debug: dump response
var_dump($response);
```

# Known Limitation(s)
* Due to PHP array limitation used in post payload when converting to XML format, multiple child element with same name cannot be generated (because PHP array keys must be unique)

# Disclaimer
* This is not an official SDK from Lazada
* This library may be changed without notice to keep it updated with Lazada's API
* This library is provided as is, without any warranty and can be broken anytime Lazada create breaking changes in their API.

# Contributing
* Error reporting/issues
    * Use Github's issue tracker
* Code contribution
    * Fork this repository
    * Create pull request

# License
* MIT
