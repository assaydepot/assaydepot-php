# Assay Depot

PHP interface for Assay Depot's online laboratory
(http://www.assaydepot.com).

See http://assaydepot.github.com/api/json for API usage information.

See https://github.com/assaydepot/assaydepot-php/wiki for more in-depth
examples on accessing the API via OAuth2.

## Assay Depot Developer Program

Assay Depot's API authenticates using OAuth2. You will need to log in
to your Assay Depot account, click **Dashboard**, and then click
**Edit My Profile**. Choose the **Applications** tab and create a new
application. Once created, click **Show** to obtain your client ID and
client secret.

## Setup

This library is available via
[Packgist.org](https://packagist.org/packages/assaydepot/assaydepot "assaydepot/assaydepot")
and can be installed with [Composer](http://getcomposer.org/download/ "Composer").
Use Composer's autload feature to load this along with any other required
packages.

**Please Note:** Using this library requires the use of an OAuth2
client as well. The package available on Packagist suggests a package
for this purpose, but feel free to use any OAuth2 package you are
comfortable with. It must support Authorization Code and Client
Credentials grant types.

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

/**
 * Use the PHP OAuth2 Library of your choice to retrieve the access
 * token.
 * We have tested and used https://github.com/adoy/PHP-OAuth2
 */

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

##Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Added some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request

##License

The Assay Depot PHP SDK is released under the MIT license.