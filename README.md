# SyncFS

[![Build Status](https://travis-ci.org/matejvelikonja/SyncFS.svg?branch=master)](https://travis-ci.org/matejvelikonja/SyncFS)
[![Code Coverage](https://scrutinizer-ci.com/g/matejvelikonja/SyncFS/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/matejvelikonja/SyncFS/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/matejvelikonja/SyncFS/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/matejvelikonja/SyncFS/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/aeee8e02-6ad1-47eb-924b-1d1be6844ad8/mini.png)](https://insight.sensiolabs.com/projects/aeee8e02-6ad1-47eb-924b-1d1be6844ad8)

PHP Library with command line tool for simple syncing folders via configuration file.

SyncFS is PHP5 library build on Symfony2 components. Via simple configuration file written in YAML, you can define
folders that you would like to sync, locally or remotely.

**Usage examples**

* Backing up local folder to external hard drive.
* Backing up local folder to remote machine.
* Syncing production assets to local machine for easier development.
* Syncing production assets to staging / beta environment for better mimicking of production.

**Dependencies**

* Rsync - command line tool
* Linux or OSX machine.

## Install as tool

### Via as composer

```bash
$ composer global require "velikonja/sync-fs=dev-master"
```

#### Usage

```bash
$ ~/.composer/vendor/bin/syncfs
```

Add folder `~/.composer/vendor/bin/` to `$PATH` variable for global usage.

### Phar

*TODO*

## Install as library

```bash
$ composer require "velikonja/sync-fs=dev-master"
```

*TODO*: improve

## Setup and usage of tool

* First run `syncfs init` to create example config file in home folder (you can change config path via command arguments).
* Edit config file.
* Run `syncfs sync`.
* Explore other possibilities with `syncfs list`.

## Contributing

Install dependencies
```bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install --dev
```

## Building PHAR file

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
