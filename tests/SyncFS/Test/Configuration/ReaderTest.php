<?php

namespace SyncFS\Test\Configuration;

use SyncFS\Configuration\Configuration;
use SyncFS\Configuration\Reader;
use SyncFS\Test\TestCase;

/**
 * Class ReaderTest
 *
 * @package SyncFS\Test\Configuration
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class ReaderTest extends TestCase
{
    /**
     * Reader should thrown exception if configuration cannot be read.
     *
     * @expectedException \SyncFS\Configuration\ReaderException
     */
    public function testIfExceptionIsThrownWhenConfigurationCannotBeRead()
    {
        $reader = new Reader(new Configuration());
        $reader->read('/does-not-exists-i-guess');
    }

    /**
     * Reader should thrown exception if configuration is not valid.
     *
     * @expectedException \SyncFS\Configuration\ReaderException
     */
    public function testIfExceptionIsThrownWhenConfigurationIsNotValid()
    {
        $path = $this->getTestDataDir() . '/config.invalid.yml';

        $this->assertTrue(is_readable($path), 'Invalid configuration file is missing.');

        $reader = new Reader(new Configuration());
        $reader->read($path);
    }

    /**
     * Test reading of simple yaml file.
     */
    public function testIfItReadsLocalFile()
    {
        $path   = $this->getConfigExampleFilePath();
        $reader = new Reader(new Configuration());
        $data   = $reader->read($path);

        $this->assertInternalType('array', $data);
    }
}
