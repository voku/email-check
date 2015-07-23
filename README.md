E-Mail Check for PHP
=============

Usage:
======

Example 1:

    $emailCheck = EmailCheck::isValid("lars@moelleken.org");
    
    // true

Example 2:

    $emailCheck = EmailCheck::isValid("lars@example.com");
    
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
