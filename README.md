# middlewares/www

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-scrutinizer]][link-scrutinizer]
[![Total Downloads][ico-downloads]][link-downloads]
[![SensioLabs Insight][ico-sensiolabs]][link-sensiolabs]

Middleware to add or remove the `www` subdomain in the host uri and returns a redirect response. The following types of hosts wont be changed:

* The one word hosts, for example: `http://localhost`.
* The ip based hosts, for example: `http://0.0.0.0`.

## Requirements

* PHP >= 7.0
* A [PSR-7 http library](https://github.com/middlewares/awesome-psr15-middlewares#psr-7-implementations)
* A [PSR-15 middleware dispatcher](https://github.com/middlewares/awesome-psr15-middlewares#dispatcher)

## Installation

This package is installable and autoloadable via Composer as [middlewares/www](https://packagist.org/packages/middlewares/www).

```sh
composer require middlewares/www
```

## Example

```php
$dispatcher = new Dispatcher([
	new Middlewares\Www(false)
]);

$response = $dispatcher->dispatch(new ServerRequest());
```

## Options

#### `__construct(bool $www)`

Set `true` to add the www subdomain and `false` to remove it.

---

Please see [CHANGELOG](CHANGELOG.md) for more information about recent changes and [CONTRIBUTING](CONTRIBUTING.md) for contributing details.

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/middlewares/www.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/middlewares/www/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/g/middlewares/www.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/middlewares/www.svg?style=flat-square
[ico-sensiolabs]: https://img.shields.io/sensiolabs/i/68cf669f-15ca-4bfa-8cb2-7400f984a228.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/middlewares/www
[link-travis]: https://travis-ci.org/middlewares/www
[link-scrutinizer]: https://scrutinizer-ci.com/g/middlewares/www
[link-downloads]: https://packagist.org/packages/middlewares/www
[link-sensiolabs]: https://insight.sensiolabs.com/projects/68cf669f-15ca-4bfa-8cb2-7400f984a228
