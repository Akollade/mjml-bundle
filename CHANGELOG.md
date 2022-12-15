# Changelog

## 3.5.2 (2022-12-15)

* Add "mjml_version" as an optional parameter in configuration

## 3.5.1 (2021-01-23)

* Allow PHP 8 #70

## 3.5.0 (2021-01-19)

* A new option to set the path to the node binary is available #35

## 3.4.1 (2020-04-26)

* Remove suggest of SwiftMailer

## 3.4.0 (2020-04-26)

* Better examples in README #57
* Add PHP 7.4 in continuous integration #55
* Replace PHP-CS-Fixer with EasyCodingStandard #54
* Use SF Mailer syntax for examples in README #58
* The Swiftmailer integration is deprecated #69
* Add CONTRIBUTING #61

## 3.3.0 (2019-12-08)

* Supports Symfony 5 #45 #46
* Fix issue with the last version of Twig #48

## 3.2.0 (2019-10-09)

* Allow setting validation level in config when using the binary renderer #44

## 3.1.2 (2019-09-16)

* Supports MJML 4.5 by using --version instead -V #42

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
