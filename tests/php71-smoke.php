<?php

declare(strict_types=1);

use voku\helper\EmailCheck;

$autoload = \dirname(__DIR__) . '/vendor/autoload.php';
if (\file_exists($autoload)) {
    require_once $autoload;
} else {
    require_once \dirname(__DIR__) . '/src/voku/helper/EmailCheck.php';
}

$checks = [
    ['lars@moelleken.org', true],
    ['Lars@Mölleken.ORG', true],
    ['example@example.com', true],
    ['example@example.com', false, true, false, false],
    ['lall', false],
    ['test@-tonline.de.de', false],
];

foreach ($checks as $check) {
    $email = $check[0];
    $expected = $check[1];
    $useExampleDomainCheck = $check[2] ?? false;
    $useTypoInDomainCheck = $check[3] ?? false;
    $useTemporaryDomainCheck = $check[4] ?? false;
    $useDnsCheck = $check[5] ?? false;

    $actual = EmailCheck::isValid($email, $useExampleDomainCheck, $useTypoInDomainCheck, $useTemporaryDomainCheck, $useDnsCheck);
    if ($actual !== $expected) {
        throw new RuntimeException('Unexpected validation result for: ' . $email);
    }
}

if (EmailCheck::isExampleDomain('example.com') !== true) {
    throw new RuntimeException('Expected example.com to be detected as an example domain.');
}

if (EmailCheck::isTemporaryDomain('10minutemail.com') !== true) {
    throw new RuntimeException('Expected 10minutemail.com to be detected as temporary.');
}

if (EmailCheck::isTypoInDomain('aol.con') !== true) {
    throw new RuntimeException('Expected aol.con to be detected as a typo domain.');
}

fwrite(STDOUT, "PHP 7.1 smoke tests passed.\n");
