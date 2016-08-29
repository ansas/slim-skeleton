# Slim 3 Skeleton

[![Latest Stable Version](https://poser.pugx.org/ansas/slim-skeleton/v/stable)](https://packagist.org/packages/ansas/slim-skeleton)
[![Total Downloads](https://poser.pugx.org/ansas/slim-skeleton/downloads)](https://packagist.org/packages/ansas/slim-skeleton)
[![Latest Unstable Version](https://poser.pugx.org/ansas/slim-skeleton/v/unstable)](https://packagist.org/packages/ansas/slim-skeleton)
[![License](https://poser.pugx.org/ansas/slim-skeleton/license)](https://packagist.org/packages/ansas/slim-skeleton)

A skeleton for [Slim 3 Framework](http://slimframework.com/).

This skeleton follows several PHP Standards Recommendations (PSR):
- [x] PSR-1 / PSR-2 (Coding standards)
- [x] PSR-3 (Logging) via Monolog
- [x] PSR-4 (Autoloading) via Composer
- [x] PSR-7 (HTTP message) via Slim

## Included components
* Slim 3.x incl. Flash messages & Twig view ([MIT License](https://github.com/slimphp/Slim/blob/3.x/LICENSE.md))
* Twig template engine 1.x ([BSD License](https://github.com/twigphp/Twig/blob/1.x/LICENSE))
* Monolog logger 1.x ([MIT License](https://github.com/Seldaek/monolog/blob/master/LICENSE))
* Custom Error and NotFound handler
* Middlewares: Cors, ForceRoute, Runtime, NoTrailingSlash, etc.
* Provider: ConsoleLoggerProvider, ExtendedRequestProvider, PdoProvider, ProfilerProvider, etc.

## Directory structure
```
path/to/project
|-- app              <- Application config files
|   |-- slim         <- Slim config files
|   `-- twig         <- Twig templates
|-- bin              <- Own scripts
|-- etc              <- Own config files (like Apache)
|-- lib              <- Vendor files (for composer)
|-- log              <- Log files
|-- pub              <- Webserver document root
|   |-- css
|   |-- img
|   |-- js
|   `-- lib
|-- src              <- Application classes (\App namespace)
|   |-- Controller
|   |-- Handler      <- Put custom handlers here
|   |-- Middleware   <- Put custom middlewares here
|   |-- Model
|   |-- Provider     <- Put custom providers here
|   `-- Tests
`-- tmp              <- Temporary files
|   |-- session
|   `-- twig
`-- var              <- Put other data in here
```

## Requirements

* PHP 7
* [Composer](https://getcomposer.org/) ([MIT License](https://github.com/composer/composer/blob/master/LICENSE))

## Usage

### Install / Create project

```shell
$ composer create-project ansas/slim-skeleton path/to/project
```

### Develop / Run PHP build-in server

```shell
$ cd path/to/project
$ composer server
```
Open web browser with address http://any-domain-pointing-to-server:8888

### Call controller from console

```shell
$ cd path/to/project
$ composer run The\Controller\YouWantToRun <- calls __invoke()
$ composer run The\Controller\YouWantToRun:methodWanted
$ composer run The\Controller\YouWantToRun:methodWanted parem1=yes param2=hi
```

### Test / Check coding style and test code

```shell
$ cd path/to/project
$ composer test
```

## Contribute

Everybody can contribute to this package. Just:

1. fork it, 
2. make your changes and 
3. send a pull request.

Please make sure to follow [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md) and [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) coding conventions.


## License

See the [LICENSE](LICENSE.md) file.
