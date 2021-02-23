[![Build Status](https://img.shields.io/travis/com/mhauri/lotto-parser?style=flat-square)](https://travis-ci.com/mhauri/lotto-parser)
[![Codacy Badge](https://img.shields.io/codacy/grade/5219b287ca0f4393b392688a8daa1919?style=flat-square)](https://www.codacy.com/gh/mhauri/lotto-parser/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=mhauri/lotto-parser&amp;utm_campaign=Badge_Grade)
[![Codacy Badge](https://img.shields.io/codacy/coverage/5219b287ca0f4393b392688a8daa1919?label=code%20coverage&style=flat-square)](https://www.codacy.com/gh/mhauri/lotto-parser/dashboard?utm_source=github.com&utm_medium=referral&utm_content=mhauri/lotto-parser&utm_campaign=Badge_Coverage)

# Lotto Parser

PHP library for parsing [Swiss Lotto](https://www.swisslos.ch/en/swisslotto/information/winning-numbers/winning-numbers.html) and [Euro Millions](https://www.swisslos.ch/en/euromillions/information/winning-numbers/winning-numbers.html) results from [Swisslos](https://www.swisslos.ch/en/home.html).

## Installation

```  
composer require mhauri/lotto-parser  
```  

## Usage

To get the latest results from Swiss Lotto

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
Any contribution is highly appreciated. The best way to contribute code is to open
a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developer
---------  
[Marcel Hauri](https://github.com/mhauri), and all
other [contributors](https://github.com/mhauri/lotto-parser/contributors)

License
-------  
[MIT](https://opensource.org/licenses/MIT)