<?php

namespace SyncFS\Test\Configuration;

use SyncFS\Configuration\Configuration;
use SyncFS\Test\TestCase;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ConfigurationTest
 *
 * @package SyncFS\Test\Configuration
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class ConfigurationTest extends TestCase
{
    /**
     * Tests example configuration. Will throw exception if does not validate.
     */
    public function testReadingExampleConfiguration()
    {
        $config        = Yaml::parse($this->getConfigExampleFilePath());
        $processor     = new Processor();
        $configuration = new Configuration();

        $processor->processConfiguration(
            $configuration,
            $config
        );
    }
}
