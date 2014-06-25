# SyncFS

[![Build Status](https://travis-ci.org/matejvelikonja/SyncFS.svg?branch=master)](https://travis-ci.org/matejvelikonja/SyncFS)
[![Code Coverage](https://scrutinizer-ci.com/g/matejvelikonja/SyncFS/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/matejvelikonja/SyncFS/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/matejvelikonja/SyncFS/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/matejvelikonja/SyncFS/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/9049a67f-a78c-4366-8712-5bed46f02156/mini.png)](https://insight.sensiolabs.com/projects/9049a67f-a78c-4366-8712-5bed46f02156)

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
