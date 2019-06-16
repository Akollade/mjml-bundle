# Changelog

## 3.1.1 (2019-06-16)

* Better exceptions for failed commands in BinaryRenderer #37
* Fix deprecation for symfony/config 4.2+ #40

## 3.1.0 (2019-05-23)

* Add Symfony ^3.4 support #31
* Use gitattributes to keep tests out of production #32

## 3.0.1 (2019-04-11)

* Fix Twig deprecations #29

## 3.0.0 (2018-11-18)

* Add RendererInterface to allow new implementation
* Check MJML version only one time in BinaryRenderer
* Fix typo with "mimify" -> "minify"

## 2.1.2 (2018-08-30)

* Add option to SwiftMailer plugin to ignore spool transport

## 2.1.1 (2018-08-23)

* Fix detection of MJML 4.1

## 2.1.0 (2018-07-17)

* Add plugin to integrate MJML with SwiftMailer 

## 2.0.1 (2018-06-09)

* Fix validation level for MJML 4
* Throw exception when MJML binary is not found
* Examples are now valid with MJML 4

## 2.0.0 (2018-03-13)

* Compatibility with Symfony 4
* Big cleanup

## 1.0.0 (2017-11-07)

* First release
