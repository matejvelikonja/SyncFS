<?php

namespace SyncFS\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class InitCommand
 *
 * @package SyncFS\Command
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class InitCommand extends Command
{
    const COMMAND_NAME    = 'init';

    /**
     * Configure command.
     */
    protected function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription("Initialize empty config file.")
            ->addArgument(
                self::ARG_CONFIG_PATH,
                InputArgument::OPTIONAL,
                'Path to config file. Default ' . $this->getDefaultConfiguration(),
                $this->getDefaultConfiguration()
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws \RuntimeException
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file        = $input->getArgument(self::ARG_CONFIG_PATH);
        $exampleFile = __DIR__ . '/../../../tests/SyncFS/Test/Resources/data/config.example.yml';

        if (! $content = @file_get_contents($exampleFile)) {
            throw new \RuntimeException(sprintf('<error>File `%s` cannot be read!</error>', $exampleFile));
        }

        if (file_exists($file)) {
            $output->writeln(sprintf('<error>File `%s` already exists.</error>', realpath($file)));

            return;
        }

        if (! is_writable(dirname($file))) {
            throw new \RuntimeException(sprintf('<error>File `%s` cannot be created!</error>', $file));
        }

        $fs = new Filesystem();
        $fs->dumpFile($file, $content);

        $output->writeln(sprintf('<info>Successfully created config file in `%s`.</info>', $file));
    }
}
