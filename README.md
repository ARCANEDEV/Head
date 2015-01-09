Head Tags Manager
==============
[![Travis Status](http://img.shields.io/travis/ARCANEDEV/Head.svg?style=flat-square)](https://travis-ci.org/ARCANEDEV/Head)
[![Coverage Status](http://img.shields.io/coveralls/ARCANEDEV/Head.svg?style=flat-square)](https://coveralls.io/r/ARCANEDEV/Head?branch=master)
[![Github Release](http://img.shields.io/github/release/ARCANEDEV/Head.svg?style=flat-square)](https://github.com/ARCANEDEV/Head/releases)
[![Packagist License](http://img.shields.io/packagist/l/ARCANEDEV/Head.svg?style=flat-square)](https://github.com/ARCANEDEV/Head/blob/master/LICENSE)
[![Packagist Downloads](https://img.shields.io/packagist/dt/arcanedev/head.svg?style=flat-square)](https://packagist.org/packages/arcanedev/head)
[![Github Issues](http://img.shields.io/github/issues/ARCANEDEV/Head.svg?style=flat-square)](https://github.com/ARCANEDEV/Head/issues)

*By [ARCANEDEV&copy;](http://www.arcanedev.net/)*

### Requirements

    - PHP >= 5.4.0
    
## Installation
### Composer
You can install the package via [Composer](http://getcomposer.org/). Add this to your `composer.json`:
```json
{
    "require": {
        "arcanedev/head": "~1.1"
    }
}
```
And install it via `composer install` or `composer update`.

### Laravel
Once the package is installed, you can register the service provider in `app/config/app.php` in the `providers` array:

```php
'providers' => [
    ...
    'Arcanedev\Head\Laravel\ServiceProvider',
],
```

And the facade in the `aliases` array:

```php
'aliases' => [
    ...
    'Head' => 'Arcanedev\Head\Laravel\Facade',
],
```

## USAGE
Coming soon...

## TODO

  - [ ] Documentation
  - [ ] Examples
  - [x] More tests and code coverage (~99%)
  - [x] Laravel support
  - [ ] Refactoring

## Contribution

Any ideas are welcome. Feel free the submit any issues or pull requests.
  
## License

Head package is licenced under the [MIT license](https://github.com/ARCANEDEV/Head/blob/master/LICENSE).
