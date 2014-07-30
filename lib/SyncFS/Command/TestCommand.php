<?php

namespace SyncFS\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use SyncFS\Test\Functional\Helper\FileSystemHelper;

/**
 * Class TestCommand
 *
 * @package SyncFS\Command
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class TestCommand extends Command
{
    const COMMAND_NAME = 'test';

    /**
     * Configure command.
     */
    protected function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Execute simple test sync. It creates temporary test folders.')
            ->addOption('no-clean-up', 'c', InputOption::VALUE_NONE, 'Do no clean up after finish.');
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
        $this->input  = $input;
        $this->output = $output;

        $testDir    = sys_get_temp_dir() . '/' . uniqid('SyncFS_tests');
        $configPath = $testDir . '/config.yml';
        $srcDir     = $testDir . '/sync-from-here';
        $dstDir     = $testDir . '/sync-to-here';
        $fsHelper   = new FileSystemHelper($srcDir);


        $output->writeln(sprintf('<info>Creating temporary files in dir `%s`.</info>', $testDir));
        $fsHelper->create();

        $this->createConfig(
            $configPath,
            array(
                'sync-fs' => array(
                    'maps' => array(
                        'random-folders-sync' => array(
                            'src' => $srcDir,
                            'dst' => $dstDir,
                        )
                    )
                )
            )
        );

        $this->runCommand(
            ShowCommand::COMMAND_NAME,
            array(
                self::ARG_CONFIG_PATH => $configPath,
            )
        );

        $this->runCommand(
            SyncCommand::COMMAND_NAME,
            array(
                self::ARG_CONFIG_PATH => $configPath,
            )
        );

        $output->writeln(sprintf('<info>Cleaning up...</info>'));
        $fsHelper->cleanUp();

    }

    /**
     * @param string $configPath
     * @param array  $data
     *
     * @return int
     */
    private function createConfig($configPath, array $data)
    {
        $content = Yaml::dump($data);

        return file_put_contents($configPath, $content);
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
        $this->writeSeparator('command: ' . $name);

        parent::runCommand($name, $args);

        $this->writeSeparator('end ' . $name);
    }

    /**
     * @param string $title
     */
    private function writeSeparator($title)
    {
        $output = strtoupper("*************** - $title - ***************");
        $this->output->writeln("<comment>$output</comment>");
        $this->output->writeln('');
    }
}
