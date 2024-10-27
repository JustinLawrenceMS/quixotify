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
use Quixotify\Quixotify;

$quixotify = new Quixotify();
$text = $quixotify->generate('characters', 500);

echo $text;
```


### Available Methods


* `generate($type, $amount)`: Generate text by `$type` (`characters`, `words`, or `sentences`) and `$amount`.
* `getApiUrl()`: Get the API URL used for text generation.
* `setApiUrl($url)`: Set a custom API URL.


## API Documentation
-------------------


### Endpoints


* `GET /characters?characters={number}`: Generate text by character count.
* `GET /words?words={number}`: Generate text by word count.
* `GET /sentences?sentences={number}`: Generate text by sentence count.


## Contributing
------------


Pull requests and issues welcome!


## License
-------


MIT License


## Author
------


Justin Lawrence, MS


## Changelog
-----------


### 1.0.0


* Initial release