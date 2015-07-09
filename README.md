Head Tags Manager [![Packagist License](http://img.shields.io/packagist/l/ARCANEDEV/Head.svg?style=flat-square)](https://github.com/ARCANEDEV/Head/blob/master/LICENSE)
==============
[![Travis Status](http://img.shields.io/travis/ARCANEDEV/Head.svg?style=flat-square)](https://travis-ci.org/ARCANEDEV/Head)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/ARCANEDEV/Head.svg?style=flat-square)](https://scrutinizer-ci.com/g/ARCANEDEV/Head/?branch=master)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/ARCANEDEV/Head.svg?style=flat-square)](https://scrutinizer-ci.com/g/ARCANEDEV/Head/?branch=master)
[![Github Issues](http://img.shields.io/github/issues/ARCANEDEV/Head.svg?style=flat-square)](https://github.com/ARCANEDEV/Head/issues)
[![Packagist Release](https://img.shields.io/packagist/v/ARCANEDEV/Head.svg?style=flat-square)](https://packagist.org/packages/arcanedev/head)
[![Packagist Downloads](https://img.shields.io/packagist/dt/arcanedev/head.svg?style=flat-square)](https://packagist.org/packages/arcanedev/head)

*By [ARCANEDEV&copy;](http://www.arcanedev.net/)*

### Requirements

    - PHP >= 5.4.0
    
## Installation
### Composer
You can install the package via [Composer](http://getcomposer.org/). Add this to your `composer.json`:
```json
{
    "require": {
        "arcanedev/head": "~2.0"
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

## Contribution

Any ideas are welcome. Feel free the submit any issues or pull requests.

## TODO

  - [ ] Documentation
  - [ ] Examples
  - [x] More tests and code coverage
  - [x] Laravel support (v4.2)
  - [ ] Laravel support (v5.0)
  - [x] Laravel support (v5.1)

  
## License

Head package is licenced under the [MIT license](https://github.com/ARCANEDEV/Head/blob/master/LICENSE).
