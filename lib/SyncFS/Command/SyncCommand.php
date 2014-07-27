<?php

namespace SyncFS\Command;

use SyncFS\Client\MockClient;
use SyncFS\Client\RsyncClient;
use SyncFS\Configuration\Configuration;
use SyncFS\Configuration\Reader;
use SyncFS\EventInterface;
use SyncFS\Map\FileSystemMapFactory;
use SyncFS\Syncer\FolderSyncer;
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
            )
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Uses mock classes for syncing.')
            ->addOption('debug', 'd', InputOption::VALUE_NONE, 'Enable debug mode.');
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
        $debug      = $input->getOption('debug');

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
        $folderSyncer->sync($folders, function (EventInterface $event) use ($output, $debug) {
            if ($debug) {
                $output->writeln($event->getOutput()->last());
            }
//            $output->writeln($event->getFile());
//            $output->writeln($event->getOverallProgress());
//            $output->writeln($event->getMap());
        });

        $output->writeln('<info>Syncing folders succeeded!</info>');
    }
}