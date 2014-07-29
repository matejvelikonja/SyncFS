<?php

namespace SyncFS\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ShowCommand
 *
 * @package SyncFS\Command
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class ShowCommand extends Command
{
    const COMMAND_NAME = 'show';

    /**
     * Configure command.
     */
    protected function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription("Show configuration.")
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
     * @throws \RuntimeException
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument(self::ARG_CONFIG_PATH);

        if (! is_readable($file)) {
            throw new \RuntimeException(sprintf('<error>File `%s` cannot be read!</error>', $file));
        }

        $content = file_get_contents($file);

        $output->writeln(sprintf('<info>Configuration located in `%s`.</info>', $file));
        $output->writeln($content);
    }
}
