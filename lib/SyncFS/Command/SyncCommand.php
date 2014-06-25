<?php

namespace SyncFS\Command;

use SyncFS\Client\MockClient;
use SyncFS\Client\RsyncClient;
use SyncFS\Configuration\Configuration;
use SyncFS\Configuration\Reader;
use SyncFS\Map\FileSystemMapFactory;
use SyncFS\Syncer\FolderSyncer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SyncCommand
 *
 * @package SyncFS\Command
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class SyncCommand extends Command
{
    const COMMAND_NAME    = 'sync';
    const ARG_CONFIG_PATH = 'config-path';

    /**
     * @var string
     */
    private $defaultConfigPath;

    /**
     * Configure command.
     */
    protected function configure()
    {
        $this->defaultConfigPath = getenv("HOME") . '/.syncfs.yml';

        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription("Sync")
            ->addArgument(
                self::ARG_CONFIG_PATH,
                InputArgument::OPTIONAL,
                'Path to config file. Default ' . $this->defaultConfigPath,
                $this->defaultConfigPath
            )
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Uses mock classes for syncing.');
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
        $dryRun     = $input->getOption('dry-run');

        if (! file_exists($configPath)) {
            throw new \Exception(sprintf('Configuration file %s does not exists.', $configPath));
        }

        $configPath = realpath($configPath);

        $output->writeln(sprintf('Reading configuration from file %s.', $configPath));

        $reader = new Reader(new Configuration());
        $config = $reader->read($configPath);

        $output->writeln(sprintf('<info>Configuration read.</info>'));

        $factory = new FileSystemMapFactory();
        $folders = $factory->create($config['maps']);

        $client = new MockClient();
        if (! $dryRun) {
            $client = new RsyncClient();
        }

        $output->writeln('<info>Syncing folders...</info>');

        $folderSyncer = new FolderSyncer($client);
        $folderSyncer->sync($folders);

        $output->writeln('<info>Syncing folders succeeded!</info>');
    }
}