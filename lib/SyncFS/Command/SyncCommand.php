<?php

namespace SyncFS\Command;

use SyncFS\Client\MockClient;
use SyncFS\Client\RsyncClient;
use SyncFS\Command\Helper\ProgressBar;
use SyncFS\Configuration\Configuration;
use SyncFS\Configuration\Reader;
use SyncFS\Event;
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
    const OPT_PROGRESS = 'progress';

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
            ->addOption(self::OPT_PROGRESS, 'p', InputOption::VALUE_NONE, 'Shows progress bar.');
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
        $configPath      = $input->getArgument('config-path');
        $dryRun          = $input->getOption('dry-run');
        $progressEnabled = $input->getOption(self::OPT_PROGRESS);
        $progress        = null;

        if ($progressEnabled) {
            $progress = new ProgressBar($output);
        }

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

        $output->writeln('<info>Syncing folders...</info>' . PHP_EOL);

        $lastEvent    = new Event('');
        $folderSyncer = new FolderSyncer($client);
        $folderSyncer->sync(
            $folders,
            function (EventInterface $event) use ($output, $progress, &$lastEvent) {
                if ($progress) {
                    if (! $progress->isStarted() && $event->getFilesCount()) {
                        $progress->setMax($event->getFilesCount());
                        $progress->start();
                    }

                    if ($progress->isStarted()) {
                        $progress->setCurrent($event->getCompletedFiles()->count());
                        $progress->setMessage($event->getFile());
                    }
                } else {
                    $output->write($event->getBuffer());
                }

                $lastEvent = $event;
            }
        );

        if ($progress && $progress->isStarted()) {
            $progress->finish();
            $output->writeln('');
        }

        $output->writeln(
            sprintf(
                '<info>Syncing folders succeeded! Synced %d files.</info>',
                $lastEvent->getCompletedFiles()->count()
            )
        );
    }
}
