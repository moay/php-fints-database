## PHP FinTS Database [![Build Status](https://travis-ci.org/moay/php-fints-database.svg?branch=master)](https://travis-ci.org/moay/php-fints-database)

This repo intends to provide a quick and easy database to search for FinTS/HBCI capabilities and specifications of German banks.

Please be aware that the entire library is provided as is without any warranty of any kind. We don't guarantee completeness or correctness of the contained data. Use on your own risk.

### Setup

The package can be installed via composer:

    composer install moay/php-fints-database

There will be chances related to the bank specifications, make sure to update the package every once in a while. New versions will be released when specifications change.

### Usage

In order to provide a quick way to search for banks and get them, two methods are recommended:

```php
// Get an array of banks with their data. Search is performed on
// BLZ, name, location and organization.
$banks = moay\FintsDatabase\FintsDatabase::search('xyz');

// Get the first bank
$bank = $banks[0];

// Get a bank directly by it's ID
$bank = moay\FintsDatabase\FintsDatabase::getBankById(12);
```

#### Searching

If you wanted to search for the bank 'DBK', you could do all of those:

```php
// Search by short name
$banks = moay\FintsDatabase\FintsDatabase::search('DKB');

// Search by name
$banks = moay\FintsDatabase\FintsDatabase::search('Deutsche Kreditbank');

// Search by BLZ
$banks = moay\FintsDatabase\FintsDatabase::search('12030000');
$banks = moay\FintsDatabase\FintsDatabase::search('120 300 00');
$banks = moay\FintsDatabase\FintsDatabase::search('120-300-00');

You will allways get an array of banks that match your query
```

#### Getting bank details

```php
$banks = moay\FintsDatabase\FintsDatabase::search('12345678');
if (count($banks) == 1) {
    $bank = $banks[0];
    
    $id = $bank->getId();
    $blz = $bank->getBlz();
    $name = $bank->getName();
    $organization = $bank->getOrganization(); // Probably the banks short name or organization
    $location = $bank->getLocation();
    
    $hbciUrl = $bank->getHbciUrl();
    $hbciIp = $bank->getHbciIp();
    $hbciVersion = $bank->getHbciVersion();
    $hbciUrlWithFallback = $bank->getHbciUrlOrIp();
    
    $pinTanUrl = $bank->getPinTanUrl();
    $fintsVersion = $bank->getFintsVersion();
    
    $supportedTechnologies = $bank->getSupportedTechnologies();
    
    // Check for supported security mechanisms:
    if ($bank->supports('pinTan') {
        //...
    }
}
```

There is a wide range of possibly supported security mechanisms. You can check for:
- pinTan
- ddv
- rdh1
- rdh2
- rdh3
- rdh4
- rdh5
- rdh6
- rdh7
- rdh8
- rdh9
- rdh10
- rah7
- rah9
- rah10

### Advanced usage

You can use the library directly and have some more search options or even provide your own database of banks.

#### Advanced search

```php
   $database = new moay\FintsDatabase\Database\Database();
   
   // Use search parameters to exclude fields from search. All 4 parameters default to true.
   $banks = $database->search(string, [searchBlz], [searchName], [searchLocation], [searchOrganization]);
```

#### Custom database

```php    
   $database = new moay\FintsDatabase\Database\Database('absolute/path/database.json');
```

Make sure to have your database fit the default layout. You can find the raw database [here](https://raw.githubusercontent.com/moay/fints-institute-db/master/fints-institutes.json).