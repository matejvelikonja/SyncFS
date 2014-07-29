# SyncFS

[![Build Status](https://travis-ci.org/matejvelikonja/SyncFS.svg?branch=master)](https://travis-ci.org/matejvelikonja/SyncFS)
[![Code Coverage](https://scrutinizer-ci.com/g/matejvelikonja/SyncFS/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/matejvelikonja/SyncFS/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/matejvelikonja/SyncFS/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/matejvelikonja/SyncFS/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/aeee8e02-6ad1-47eb-924b-1d1be6844ad8/mini.png)](https://insight.sensiolabs.com/projects/aeee8e02-6ad1-47eb-924b-1d1be6844ad8)

PHP Library for syncing folders.

## Install development

Install dependencies
```bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install --dev
```
## Building

```bash
$ vendor/bin/box build
```

### Tests

PHPUnit tests
```bash
$ vendor/bin/phpunit
```

Coding standards tests
```bash
$ phpcs --standard=PSR2 --ignore=/vendor --ignore=/log ./
```
