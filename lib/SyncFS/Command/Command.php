<?php

namespace SyncFS\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;


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
}