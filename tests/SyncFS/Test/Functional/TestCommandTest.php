<?php

namespace SyncFS\Test\Functional;

use SyncFS\Command\TestCommand;

/**
 * Class TestCommandTest
 *
 * @package SyncFS\Test\Functional
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class TestCommandTest extends TestCase
{
    /**
     * @return string
     */
    protected function getCommandName()
    {
        return TestCommand::COMMAND_NAME;
    }

    /**
     * Tests basic sync command with config.example.yml file.
     */
    public function testBasicExecute()
    {
        $this->tester->execute(
            array(
               'command' => $this->command->getName(),
                '--fast'
            )
        );

        $this->assertRegExp('/Syncing folders succeeded!/', $this->tester->getDisplay());
    }
}
