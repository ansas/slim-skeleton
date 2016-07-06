# Slim 3 Skeleton

A skeleton for [Slim 3 Framework](http://slimframework.com/).

## Included libraries
* Slim 3.x
 * Slim Flash messages
 * Slim Twig integration
* Twig 1.x
 * Twig extensions

## Directory structure
```
path/to/project
|-- app
|   |-- slim
|   `-- twig
|-- public
|-- src
|-- tests
|-- tmp
|   |-- cache
|   `-- log
|   `-- session
|   `-- twig
`-- vendor
```

## Requirements

* PHP 7
* [Composer][compoer]

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

### Test / Check coding style and test code

```shell
$ cd path/to/project
$ composer test
```
