<?php

namespace SyncFS\Test\Functional;

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
     * Tests basic sync command with config.example.yml file.
     */
    public function testBasicExecute()
    {
        $path    = $this->getConfigExampleFilePath();
        $content = file_get_contents($path);

        $this->tester->execute(
            array(
               'command'                    => $this->command->getName(),
               ShowCommand::ARG_CONFIG_PATH => $path,
            )
        );

        $display = $this->tester->getDisplay();

        $this->assertRegExp(sprintf("/%s/", preg_quote($content, '/')), $display);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testIfCommandFailsWhenCannotWrite()
    {
        $configFilePath = '/this/should/be/non-readable.yml';

        $this->tester->execute(
            array(
                'command'                    => $this->command->getName(),
                ShowCommand::ARG_CONFIG_PATH => $configFilePath,
            )
        );
    }

    /**
     * @return string
     */
    protected function getCommandName()
    {
        return ShowCommand::COMMAND_NAME;
    }
}
