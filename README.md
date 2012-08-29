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

$access_token = '1234abcd5678efgh9';
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

## Sample Usage Code

```php
// Autoloads classes on instantiation
function __autoload($class_name) {
    include $class_name . '.php';
}

// Set config variables for class
$access_token = '1234abcd5678efgh9';
$url = 'https://www.assaydepot.com/api';

// Instantiate the class
$ad_api = new assaydepot($access_token, $url);

// Set options and facets as needed
$ad_api->option_set('per_page', '10');
$ad_api->facet_set('countries_facet', 'United Kingdom');

// Pass required args to search (builds the search URL, doesn't perform it)
$ad_api->search('providers', 'antibody purification');

// Make API call and receive back associative array with results
$search_output = $ad_api->json_output();

echo "<pre>";
print_r($search_output);
echo "<pre>";
```