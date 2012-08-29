# Assay Depot

PHP interface for Assay Depot's online laboratory
(http://www.assaydepot.com).

See http://assaydepot.github.com/api/json for API usage information.

## Assay Depot Developer Program

An authentication token is required for the API to function. If you
would like access to the API, please email cpetersen@assaydepot.com.

## Setup

Place the assaydepot.php file in your apps 'include' directory. I
recommend using the PHP class autoload function to include this (and
all) classes whenever possible:

```php
function __autoload($class_name) {
    include $class_name . '.php';
}

$access_token = '1a234bcd5678e91fgh234ijkl56mn789';
$url = 'https://www.assaydepot.com/api';

$ad_api = new assaydepot($access_token, $url);
```

## Using this PHP SDK

A number of functions are available to the developer:

*  search($search_type, $query="")
*  get($search_type, $id, $query="")
*  option_set($option, $value)
*  option_unset($option)
*  facet_set($facet, $value)
*  facet_unset($facet)
*  json_output()
