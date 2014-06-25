# SyncFS

[![Build Status](https://travis-ci.org/matejvelikonja/SyncFS.svg?branch=master)](https://travis-ci.org/matejvelikonja/SyncFS)
[![Code Coverage](https://scrutinizer-ci.com/g/matejvelikonja/SyncFS/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/matejvelikonja/SyncFS/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/matejvelikonja/SyncFS/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/matejvelikonja/SyncFS/?branch=master)

PHP Library for syncing folders.

## Install development

Install dependencies
```bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install --dev
```

### Tests

PHPUnit tests
```bash
$ vendor/bin/phpunit
```

Coding standards tests
```bash
$ phpcs --standard=Symfony2 --ignore=/vendor --ignore=/log ./
```
