[![Build Status](https://travis-ci.com/mhauri/lotto-parser.svg?branch=main)](https://travis-ci.com/mhauri/lotto-parser)



# Lotto Parser

Php library for parsing Swiss Lotto and Euro Millions results.

## Installation
```
composer require mhauri/lotto-parser
```
## Usage

To get the latest results  from Swiss Lotto
```php
<?php
    
    use LottoParser\Client\SiwssLotto
    
    $lotto = new SwissLotto();  
    
    $data = $lotto->current()->get();
    
    // to Array
    $data = $lotto->current()->toArray();
    
    // to JSON
    $data = $lotto->current()->toJson();
```

To get the results from a specific date

```php
<?php
    
    use Carbon\Carbon;
    use LottoParser\Client\SiwssLotto
    
    $lotto = new SwissLotto();  
    
    $date = Carbon::create(2021,02,13); 
    $data = $lotto->byDate($date)->get();
    
    // to Array
    $data = $lotto->byDate($date)->toArray();
    
    // to JSON
    $data = $lotto->byDate($date)->toJson();
```

The same applies for Euro Millions, just replace `$lotto = new SwissLotto()` with
`$lotto = new EuroMillions();`

Support
-------
If you have any issues with this library, open an issue on [GitHub](https://github.com/mhauri/lotto-parser/issues).

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developer
---------
[Marcel Hauri](https://github.com/mhauri), and all other [contributors](https://github.com/mhauri/lotto-parser/contributors)

License
-------
[MIT](https://opensource.org/licenses/MIT)

    
    