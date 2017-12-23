<?php

declare(strict_types=1);

namespace voku\helper;

use TrueBV\Exception\LabelOutOfBoundsException;
use TrueBV\Punycode;

/**
 * E-Mail Check Class
 *
 * -> use "EmailCheck::isValid()" to validate a email-address
 *
 * @author      Lars Moelleken
 * @copyright   Copyright (c) 2017, Lars Moelleken (http://moelleken.org/)
 * @license     http://opensource.org/licenses/MIT	MIT License
 */
class EmailCheck
{
  /**
   * @var null|array
   */
  protected static $domainsExample = null;

  /**
   * @var null|array
   */
  protected static $domainsTemporary = null;

  /**
   * @var null|array
   */
  protected static $domainsTypo = null;

  /**
   * @var bool
   */
  protected static $useDnsCheck = true;

  /**
   * Check if the email is valid.
   *
   * @param string $email
   * @param bool   $useExampleDomainCheck
   * @param bool   $useTypoInDomainCheck
   * @param bool   $useTemporaryDomainCheck
   * @param bool   $useDnsCheck (do not use, if you don't need it)
   *
   * @return bool
   */
  public static function isValid(string $email, bool $useExampleDomainCheck = false, bool $useTypoInDomainCheck = false, bool $useTemporaryDomainCheck = false, bool $useDnsCheck = false): bool
  {
    // must be a string
    if (!\is_string($email)) {
      return false;
    }

    // make sure string length is limited to avoid DOS attacks
    $emailStringLength = \strlen($email);
    if (
        $emailStringLength >= 320
        ||
        $emailStringLength <= 2 // i@y //
    ) {
      return false;
    }
    unset($emailStringLength);

    $email = \str_replace(
        [
            '.', // non-Latin chars are also allowed | https://tools.ietf.org/html/rfc6530
            '＠', // non-Latin chars are also allowed | https://tools.ietf.org/html/rfc6530
        ],
        [
            '.',
            '@',
        ],
        $email
    );

    if (
        (\strpos($email, '@') === false) // "at" is needed
        ||
        (\strpos($email, '.') === false && \strpos($email, ':') === false) // "dot" or "colon" is needed
    ) {
      return false;
    }

    if (!\preg_match('/^(?<local>.*<?)(?:.*)@(?<domain>.*)(?:>?)$/', $email, $parts)) {
      return false;
    }

    $local = $parts['local'];
    $domain = $parts['domain'];

    if (!$local) {
      return false;
    }

    if (!$domain) {
      return false;
    }

    // Escaped spaces are allowed in the "local"-part.
    $local = \str_replace('\\ ', '', $local);

    // Spaces in quotes e.g. "firstname lastname"@foo.bar are also allowed in the "local"-part.
    $quoteHelperForIdn = false;
    if (\preg_match('/^"(?<inner>[^"]*)"$/mU', $local, $parts)) {
      $quoteHelperForIdn = true;
      $local = \trim(
          \str_replace(
              $parts['inner'],
              \str_replace(' ', '', $parts['inner']),
              $local
          ),
          '"'
      );
    }

    if (
        \strpos($local, ' ') !== false // no spaces allowed, anymore
        ||
        \strpos($local, '".') !== false // no quote + dot allowed
    ) {
      return false;
    }

    list($local, $domain) = self::punnycode($local, $domain);

    if ($quoteHelperForIdn === true) {
      $local = '"' . $local . '"';
    }

    $email = $local . '@' . $domain;

    if (!\filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return false;
    }

    if ($useExampleDomainCheck === true && self::isExampleDomain($domain) === true) {
      return false;
    }

    if ($useTypoInDomainCheck === true && self::isTypoInDomain($domain) === true) {
      return false;
    }

    if ($useTemporaryDomainCheck === true && self::isTemporaryDomain($domain) === true) {
      return false;
    }

    if ($useDnsCheck === true && self::isDnsError($domain) === true) {
      return false;
    }

    return true;
  }

  /**
   * Check if the domain is a example domain.
   *
   * @param string $domain
   *
   * @return bool
   */
  public static function isExampleDomain(string $domain): bool
  {
    if (self::$domainsExample === null) {
      self::$domainsExample = self::getData('domainsExample');
    }

    if (\in_array($domain, self::$domainsExample, true)) {
      return true;
    }

    return false;
  }

  /**
   * Check if the domain has a typo.
   *
   * @param string $domain
   *
   * @return bool
   */
  public static function isTypoInDomain(string $domain): bool
  {
    if (self::$domainsTypo === null) {
      self::$domainsTypo = self::getData('domainsTypo');
    }

    if (\in_array($domain, self::$domainsTypo, true)) {
      return true;
    }

    return false;
  }

  /**
   * Check if the domain is a temporary domain.
   *
   * @param string $domain
   *
   * @return bool
   */
  public static function isTemporaryDomain(string $domain): bool
  {
    if (self::$domainsTemporary === null) {
      self::$domainsTemporary = self::getData('domainsTemporary');
    }

    if (\in_array($domain, self::$domainsTemporary, true)) {
      return true;
    }

    return false;
  }

  /**
   * get data from "/data/*.php"
   *
   * @param string $file
   *
   * @return bool|string|array|int <p>Will return false on error.</p>
   */
  protected static function getData(string $file)
  {
    $file = __DIR__ . '/data/' . $file . '.php';
    if (\file_exists($file)) {
      /** @noinspection PhpIncludeInspection */
      return require $file;
    }

    return false;
  }

  /**
   * Check if the domain has a MX- or A-record in the DNS.
   *
   * @param string $domain
   *
   * @return bool
   *
   * @throws \Exception
   */
  public static function isDnsError(string $domain): bool
  {
    if (\function_exists('checkdnsrr')) {
      return !\checkdnsrr($domain . '.', 'MX') || !\checkdnsrr($domain, 'A');
    }

    throw new \Exception(' Can\'t call checkdnsrr');
  }

  /**
   * @param string $local
   * @param string $domain
   *
   * @return array
   */
  private static function punnycode(string $local, string $domain): array
  {
    if (\function_exists('idn_to_ascii')) {

      // https://git.ispconfig.org/ispconfig/ispconfig3/blob/master/interface/lib/classes/functions.inc.php#L305
      if (
          \defined('IDNA_NONTRANSITIONAL_TO_ASCII')
          &&
          \defined('INTL_IDNA_VARIANT_UTS46')
          &&
          \constant('IDNA_NONTRANSITIONAL_TO_ASCII')
      ) {
        $useIdnaUts46 = true;
      } else {
        $useIdnaUts46 = false;
      }

      if ($useIdnaUts46 === true) {
        $localTmp = idn_to_ascii($local, IDNA_NONTRANSITIONAL_TO_ASCII, INTL_IDNA_VARIANT_UTS46);
      } else {
        $localTmp = idn_to_ascii($local);
      }
      if ($localTmp) {
        $local = $localTmp;
      }
      unset($localTmp);

      if ($useIdnaUts46 === true) {
        $domainTmp = idn_to_ascii($domain, IDNA_NONTRANSITIONAL_TO_ASCII, INTL_IDNA_VARIANT_UTS46);
      } else {
        $domainTmp = idn_to_ascii($domain);
      }
      if ($domainTmp) {
        $domain = $domainTmp;
      }
      unset($domainTmp);

    } else {

      static $punycode = null;
      if ($punycode === null) {
        $punycode = new Punycode();
      }

      try {
        $local = $punycode->encode($local);
      } catch (LabelOutOfBoundsException $e) {
        $local = '';
      }

      try {
        $domain = $punycode->encode($domain);
      } catch (LabelOutOfBoundsException $e) {
        $domain = '';
      }

    }

    return [$local, $domain];
  }
}
