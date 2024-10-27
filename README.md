# Quixotify
================


A PHP package to generate lorem ipsum text from Don Quixote.


## Installation
---------------


### Composer


```bash
composer require justinlawrencems/quixotify
```


## Usage
-----


### Basic Example


```php
use Quixotify\Controller;
use Quixotify\Generator;

$generator = new Generator(new Controller);
$text = $quixotify->generate('characters', 500);

echo $text;
```


### Available Methods


* `generate($type, $amount)`: Generate text by `$type` (`characters`, `words`, or `sentences`) and `$amount`.


## Contributing
------------


Pull requests and issues welcome!


## License
-------


MIT License


## Author
------


Justin Lawrence, MS


### v1.0.3-beta
