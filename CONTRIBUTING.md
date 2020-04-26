# Contributing

 * Coding standard for the project is [Symfony](https://symfony.com/doc/current/contributing/code/standards.html)

## Installation

To install the project and run the tests, you need to clone it first:

```sh
$ git clone https://github.com/notFloran/mjml-bundle.git
```

You will then need to run a composer installation and install MJML:

```sh
$ cd mjml-bundle
$ composer update
$ npm install mjml@4
```

## Coding standard

You can check and fix the code with EasyCodingStandard :

Check:

```sh
$ composer run cs-check
```

Fix:

```sh
$ composer run cs-fix
```

## Testing

The PHPUnit version to be used is the one installed as a dev- dependency via composer.

Then:

```sh
$ ./vendor/bin/phpunit
```
