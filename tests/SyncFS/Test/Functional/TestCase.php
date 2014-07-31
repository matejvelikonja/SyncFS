<?php

namespace SyncFS\Test\Functional;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use SyncFS\AutoLoader;
use SyncFS\Test\TestCase as BaseTestCase;

/**
 * Class TestCase
 *
 * @package SyncFS\Test\Functional
 * @author  Matej Velikonja <matej@velikonja.si>
 */
abstract class TestCase extends BaseTestCase
{
    /**
     * @var CommandTester
     */
    protected $tester;

    /**
     * @var Command
     */
    protected $command;

    /**
     * @return string
     */
    abstract protected function getCommandName();

    /**
     * Called before every test.
     */
    public function setUp()
    {
        $commandName = $this->getCommandName();
        $application = new Application();
        $autoLoader  = new AutoLoader($this->getLibDir());

        $application->addCommands($autoLoader->getCommands());

        $this->command = $application->find($commandName);
        $this->tester  = new CommandTester($this->command);
    }
}
