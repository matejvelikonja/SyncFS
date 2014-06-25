<?php

namespace SyncFS\Test\Functional;

use SyncFS\Command\Command;
use SyncFS\Command\InitCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use SyncFS\Command\ShowCommand;

/**
 * Class ShowCommandTest
 *
 * @package SyncFS\Test\Functional
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class ShowCommandTest extends TestCase
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
        $this->initCommand = new ShowCommand();

        $application->add($this->initCommand);

        $this->command = $application->find(ShowCommand::COMMAND_NAME);
        $this->tester  = new CommandTester($this->command);
    }

    /**
     * Tests basic sync command with config.example.yml file.
     */
    public function testBasicExecute()
    {
        $path    = $this->getConfigExampleFilePath();
        $content = file_get_contents($path);

        $this->tester->execute(array(
           'command'                     => $this->command->getName(),
            InitCommand::ARG_CONFIG_PATH => $path,
        ));

        $display = $this->tester->getDisplay();

        $this->assertRegExp(sprintf("/%s/", preg_quote($content, '/')), $display);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testIfCommandFailsWhenCannotWrite()
    {
        $configFilePath = '/this/should/be/non-readable.yml';

        $this->tester->execute(array(
            'command'                    => $this->command->getName(),
            InitCommand::ARG_CONFIG_PATH => $configFilePath,
        ));
    }
}
