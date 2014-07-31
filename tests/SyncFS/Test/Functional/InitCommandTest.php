<?php

namespace SyncFS\Test\Functional;

use SyncFS\Command\InitCommand;

/**
 * Class InitCommandTest
 *
 * @package SyncFS\Test\Functional
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class InitCommandTest extends TestCase
{
    /**
     * Tests basic sync command with config.example.yml file.
     */
    public function testBasicExecute()
    {
        $configFilePath = 'test.yml';

        $this->tester->execute(
            array(
               'command'                     => $this->command->getName(),
                InitCommand::ARG_CONFIG_PATH => $configFilePath,
            )
        );

        $this->assertTrue(file_exists($configFilePath), 'Config file was not created.');

        unlink($configFilePath);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testIfCommandFailsWhenCannotWrite()
    {
        $configFilePath = '/this/should/be/non-writable.yml';

        $this->tester->execute(
            array(
                'command'                    => $this->command->getName(),
                InitCommand::ARG_CONFIG_PATH => $configFilePath,
            )
        );
    }

    /**
     * @return string
     */
    protected function getCommandName()
    {
        return InitCommand::COMMAND_NAME;
    }
}
