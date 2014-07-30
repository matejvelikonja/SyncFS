<?php

namespace SyncFS\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Command
 *
 * @package SyncFS\Command
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class Command extends BaseCommand
{
    const ARG_CONFIG_PATH = 'config-path';

    /**
     * @var string
     */
    private $defaultConfigPath;

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * Constructor.
     *
     * @param string|null $name The name of the command; passing null means it must be set in configure()
     *
     * @throws \LogicException When the command name is empty
     */
    public function __construct($name = null)
    {
        $this->defaultConfigPath = getenv("HOME") . '/.syncfs.yml';

        parent::__construct($name);
    }

    /**
     * @return string
     */
    protected function getDefaultConfiguration()
    {
        return $this->defaultConfigPath;
    }

    /**
     * @param string $name
     * @param array  $args
     *
     * @return int
     * @throws \LogicException
     */
    protected function runCommand($name, array $args)
    {
        if (! $this->output) {
            throw new \LogicException('Output is needed for running other command. Sent it via class property.');
        }

        $defaults = array(
            'command' => $name,
        );

        $mergedArgs = array_merge($defaults, $args);

        $command = $this->getApplication()->find($name);
        $input   = new ArrayInput($mergedArgs);

        return $command->run($input, $this->output);
    }
}
