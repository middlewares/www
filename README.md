# middlewares/www

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
![Testing][ico-ga]
[![Total Downloads][ico-downloads]][link-downloads]

Middleware to add or remove the `www` subdomain in the host uri and returns a redirect response. The following types of hosts wont be changed:

* The one word hosts, for example: `http://localhost`.
* The ip based hosts, for example: `http://0.0.0.0`.

## Requirements

* PHP >= 7.2
* A [PSR-7 http library](https://github.com/middlewares/awesome-psr15-middlewares#psr-7-implementations)
* A [PSR-15 middleware dispatcher](https://github.com/middlewares/awesome-psr15-middlewares#dispatcher)

## Installation

This package is installable and autoloadable via Composer as [middlewares/www](https://packagist.org/packages/middlewares/www).

```sh
composer require middlewares/www
```

## Usage

Set `true` to add the www subdomain and `false` to remove it.

```php
//Remove www
$www = new Middlewares\Www(false);

//Add www
$www = new Middlewares\Www(true);
```

Optionally, you can provide a `Psr\Http\Message\ResponseFactoryInterface` as the second argument to create the redirect response (`301`). If it's not defined, [Middleware\Utils\Factory](https://github.com/middlewares/utils#factory) will be used to detect it automatically.

```php
$responseFactory = new MyOwnResponseFactory();

$www = new Middlewares\Www(true, $responseFactory);
```

---

Please see [CHANGELOG](CHANGELOG.md) for more information about recent changes and [CONTRIBUTING](CONTRIBUTING.md) for contributing details.

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/middlewares/www.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-ga]: https://github.com/middlewares/www/workflows/testing/badge.svg
[ico-downloads]: https://img.shields.io/packagist/dt/middlewares/www.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/middlewares/www
[link-downloads]: https://packagist.org/packages/middlewares/www
