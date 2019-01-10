[![Build Status](https://travis-ci.org/voku/email-check.svg)](https://travis-ci.org/voku/email-check)
[![codecov.io](http://codecov.io/github/voku/email-check/coverage.svg?branch=master)](http://codecov.io/github/voku/email-check?branch=master)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/512a3dc264b745b18baa1b238470b1d0)](https://www.codacy.com/app/voku/email-check)
[![Latest Stable Version](https://poser.pugx.org/voku/email-check/v/stable)](https://packagist.org/packages/voku/email-check) 
[![Total Downloads](https://poser.pugx.org/voku/email-check/downloads)](https://packagist.org/packages/voku/email-check) 
[![License](https://poser.pugx.org/voku/email-check/license)](https://packagist.org/packages/voku/email-check)
[![Donate to this project using Paypal](https://img.shields.io/badge/paypal-donate-yellow.svg)](https://www.paypal.me/moelleken)
[![Donate to this project using Patreon](https://img.shields.io/badge/patreon-donate-yellow.svg)](https://www.patreon.com/voku)

# :envelope: E-Mail Address Validator for PHP

### Warning

The best way to validate an e-mail address is still to send a duplicate opt-in-mail, when the user clicks on the link, it was a valid e-mail address!

### Installation

The recommended installation way is through [Composer](https://getcomposer.org).

```bash
$ composer require voku/email-check
```

### Usage:

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

### Unit Test:

1) [Composer](https://getcomposer.org) is a prerequisite for running the tests.

```
composer install
```

2) The tests can be executed by running this command from the root directory:

```bash
./vendor/bin/phpunit
```

### Support

For support and donations please visit [Github](https://github.com/voku/email-check/) | [Issues](https://github.com/voku/email-check/issues) | [PayPal](https://paypal.me/moelleken) | [Patreon](https://www.patreon.com/voku).

For status updates and release announcements please visit [Releases](https://github.com/voku/email-check/releases) | [Twitter](https://twitter.com/suckup_de) | [Patreon](https://www.patreon.com/voku/posts).

For professional support please contact [me](https://about.me/voku).

### Thanks

- Thanks to [GitHub](https://github.com) (Microsoft) for hosting the code and a good infrastructure including Issues-Managment, etc.
- Thanks to [IntelliJ](https://www.jetbrains.com) as they make the best IDEs for PHP and they gave me an open source license for PhpStorm!
- Thanks to [Travis CI](https://travis-ci.com/) for being the most awesome, easiest continous integration tool out there!
- Thanks to [StyleCI](https://styleci.io/) for the simple but powerfull code style check.
- Thanks to [PHPStan](https://github.com/phpstan/phpstan) && [Psalm](https://github.com/vimeo/psalm) for relly great Static analysis tools and for discover bugs in the code!
