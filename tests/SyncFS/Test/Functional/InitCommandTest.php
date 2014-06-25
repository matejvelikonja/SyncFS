<?php

namespace SyncFS\Test\Functional;

use Symfony\Component\Console\Command\Command;
use SyncFS\Command\InitCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class InitCommandTest
 *
 * @package SyncFS\Test\Functional
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class InitCommandTest extends TestCase
{

    /**
     * @var Command
     */
    private $command;

    /**
     * @var CommandTester
     */
    private $tester;

    /**
     * @var InitCommand
     */
    private $initCommand;

    /**
     * Called before every test.
     */
    public function setUp()
    {
        $application       = new Application();
        $this->initCommand = new InitCommand();

        $application->add($this->initCommand);

        $this->command = $application->find(InitCommand::COMMAND_NAME);
        $this->tester  = new CommandTester($this->command);
    }

    /**
     * Tests basic sync command with config.example.yml file.
     */
    public function testBasicExecute()
    {
        $configFilePath = 'test.yml';

        $this->tester->execute(array(
           'command'                     => $this->command->getName(),
            InitCommand::ARG_CONFIG_PATH => $configFilePath,
        ));

        $this->assertTrue(file_exists($configFilePath), 'Config file was not created.');

        unlink($configFilePath);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testIfCommandFailsWhenCannotWrite()
    {
        $configFilePath = '/this/should/be/non-writable.yml';

        $this->tester->execute(array(
            'command'                    => $this->command->getName(),
            InitCommand::ARG_CONFIG_PATH => $configFilePath,
        ));
    }
}
