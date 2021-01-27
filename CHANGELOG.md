Changelog
=========

3.1.0 (2020-01-27)

- add "getMailParts()"


3.0.2 (2019-01-03)

- replace "true/punycode" with "symfony/polyfill-intl-idn"
- use phpcs fixer


3.0.1 (2018-10-19)

- fix "isDnsError()"
- update "isTemporaryDomain()"


3.0.0 (2017-12-23)

- remove "Portable UTF8"

  -> this is a breaking change without API-changes - but the requirement
  from "Portable UTF8" has been removed


2.0.0 (2017-12-01)

- "php": ">=7.0" 
  * drop support for PHP < 7.0
  * use "strict_types"
