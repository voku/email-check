[![Build Status](https://travis-ci.org/voku/email-check.svg)](https://travis-ci.org/voku/email-check)
[![codecov.io](http://codecov.io/github/voku/email-check/coverage.svg?branch=master)](http://codecov.io/github/voku/email-check?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/voku/email-check/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/voku/email-check/?branch=master)
[![Codacy Badge](https://www.codacy.com/project/badge/512a3dc264b745b18baa1b238470b1d0)](https://www.codacy.com/app/voku/email-check)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a9eca36c-3410-4291-958d-a18e7d852109/mini.png)](https://insight.sensiolabs.com/projects/a9eca36c-3410-4291-958d-a18e7d852109)
[![Latest Stable Version](https://poser.pugx.org/voku/email-check/v/stable)](https://packagist.org/packages/voku/email-check) [![Total Downloads](https://poser.pugx.org/voku/email-check/downloads)](https://packagist.org/packages/voku/email-check) [![Latest Unstable Version](https://poser.pugx.org/voku/email-check/v/unstable)](https://packagist.org/packages/voku/email-check) [![License](https://poser.pugx.org/voku/email-check/license)](https://packagist.org/packages/voku/email-check)

# E-Mail Check for PHP

## Installation

The recommended installation way is through [Composer](https://getcomposer.org).

```bash
$ composer require voku/email-check
```

## Usage:

Example 1:

    $emailCheck = EmailCheck::isValid("lars@moelleken.org");
    
    // true

Example 2: (check for example-domain)

    $emailCheck = EmailCheck::isValid("lars@example.com", true);
    
    // false

Example 3: (check for typo in domain)

    $emailCheck = EmailCheck::isValid("lars@-tonline.de", false, true);
    
    // false

Example 4: (check for temporary-domain)

    $emailCheck = EmailCheck::isValid("lars@30minutemail.com", false, false, true);
    
    // false

Unit Test:
==========

1) [Composer](https://getcomposer.org) is a prerequisite for running the tests.

```
composer install
```

2) The tests can be executed by running this command from the root directory:

```bash
./vendor/bin/phpunit
```
