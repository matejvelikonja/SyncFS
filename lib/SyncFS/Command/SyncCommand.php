<?php

namespace SyncFS\Command;

use SyncFS\Configuration\Configuration;
use SyncFS\Configuration\Reader;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use SyncFS\Syncer;

/**
 * Class SyncCommand
 *
 * @package SyncFS\Command
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class SyncCommand extends Command
{
    const COMMAND_NAME = 'sync';

    /**
     * Configure command.
     */
    protected function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription("Run synchronization.")
            ->addArgument(
                self::ARG_CONFIG_PATH,
                InputArgument::OPTIONAL,
                'Path to config file.',
                $this->getDefaultConfiguration()
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws \Exception
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configPath = $input->getArgument('config-path');

        if (! file_exists($configPath)) {
            throw new \Exception(sprintf('Configuration file %s does not exists.', $configPath));
        }

        $configPath = realpath($configPath);

        $output->writeln(sprintf('Reading configuration from file %s.', $configPath));

        $reader = new Reader(new Configuration());
        $config = $reader->read($configPath);

        $output->writeln(sprintf('<info>Configuration read.</info>'));

        $syncer = new Syncer($config);

        $output->writeln('<info>Syncing folders...</info>' . PHP_EOL);

        $syncer->sync($output);

        $output->writeln(
            '<info>Syncing folders succeeded!</info>'
        );
    }
}
