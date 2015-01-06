Head Tags Manager
==============
[![Travis Status](http://img.shields.io/travis/ARCANEDEV/Head.svg?style=flat-square)](https://travis-ci.org/ARCANEDEV/Head)
[![Github Release](http://img.shields.io/github/release/ARCANEDEV/Head.svg?style=flat-square)](https://github.com/ARCANEDEV/Head/releases)
[![Coverage Status](http://img.shields.io/coveralls/ARCANEDEV/Head.svg?style=flat-square)](https://coveralls.io/r/ARCANEDEV/Head?branch=master)
[![Packagist License](http://img.shields.io/packagist/l/ARCANEDEV/Head.svg?style=flat-square)](https://github.com/ARCANEDEV/Head/blob/master/LICENSE)
[![Packagist Downloads](https://img.shields.io/packagist/dt/arcanedev/head.svg?style=flat-square)](https://packagist.org/packages/arcanedev/head)
[![Github Issues](http://img.shields.io/github/issues/ARCANEDEV/Head.svg?style=flat-square)](https://github.com/ARCANEDEV/Head/issues)

*By [ARCANEDEV&copy;](http://www.arcanedev.net/)*

### Requirements
    
    - PHP >= 5.4.0
    
### Composer

You can install the package via [Composer](http://getcomposer.org/). Add this to your `composer.json`:

```json
    {
      "require": {
        ...
        "arcanedev/head": "~1.0"
        ...
      }
    }
```
    
Then install via `composer install` or `composer update`.

### Laravel Installation
Once the package is installed, you can register the service provider in `app/config/app.php` in the `providers` array:

```php
'providers' => array(
    ...
    'Arcanedev\Head\Laravel\ServiceProvider',
    ...
)
```

And the facade in the `aliases` array:

```php
'aliases' => array(
    ...
    'Arcanedev\Head\Laravel\Facade',
    ...
)
```

### TODOS:

  - [ ] Documentation
  - [ ] Examples
  - [ ] More tests and code coverage.
  - [ ] Refactoring.
