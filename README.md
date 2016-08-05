# Slim 3 Skeleton

A skeleton for [Slim 3 Framework](http://slimframework.com/).

This skeleton followes several PHP Standards Recommendations (PSR):
- PSR-1 / PSR-2 (Coding standards)
- PSR-3 (Logging) via Monolog
- PSR-4 (Autoloading) via Composer
- PSR-7 (HTTP message) via Slim

## Included components
* Slim 3.x
* Flash messages
* Twig template engine 1.x
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
|   |-- Handler
|   |-- Middleware
|   |-- Model
|   |-- Provider
|   `-- Tests
`-- tmp              <- Temporary files
    |-- session
    `-- twig
```

## Requirements

* PHP 7
* [Composer](https://getcomposer.org/)

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
