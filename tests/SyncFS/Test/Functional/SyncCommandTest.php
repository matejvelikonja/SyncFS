<?php

namespace SyncFS\Test\Functional;

use SyncFS\Command\SyncCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * Class SyncCommandTest
 *
 * @package SyncFS\Test\Functional
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class SyncCommandTest extends TestCase
{
    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $fs;

    /**
     * @var string
     */
    private $tmpDir;

    /**
     * @var array
     */
    private $maps;
    /**
     * @var string
     */
    private $configPath;

    /**
     * Creates temporary folder.
     */
    public function setUp()
    {
        $this->fs         = new Filesystem();
        $this->tmpDir     = $this->getTmpDir();
        $this->configPath = $this->getConfigExampleFilePath();

        // same folders as in tests/SyncFS/Test/Resources/data/config.example.yml
        $this->maps = array(
            array(
                'src' => $this->tmpDir . '/functional/src/',
                'dst' => $this->tmpDir . '/functional/dst/',
            ),
            array(
                'src' => $this->tmpDir . '/functional/src2/',
                'dst' => $this->tmpDir . '/functional/dst2/',
            ),
        );

        $this->createTestDirs();
    }

    /**
     * Cleanup after tests run.
     */
    public function tearDown()
    {
        $this->fs->remove($this->tmpDir);
    }

    /**
     * Tests basic sync command with config.example.yml file.
     */
    public function testBasicExecute()
    {
        $application = new Application();
        $syncCommand = new SyncCommand();

        $application->add($syncCommand);

        $command = $application->find($syncCommand::COMMAND_NAME);
        $tester  = new CommandTester($command);

        $tester->execute(
            array(
               'command'                      => $command->getName(),
                $syncCommand::ARG_CONFIG_PATH => $this->configPath,
            )
        );

        foreach ($this->maps as $dir) {
            $this->assertTrue(
                $this->foldersEqual($dir['src'], $dir['dst']),
                sprintf('Folders `%` and `%s` are not equal.', $dir['src'], $dir['dst'])
            );
        }
    }

    /**
     * A simple algorithm to determine if folders are equal.
     * Implementation is not nearly 100%.
     *
     * @param string $sourceFolder
     * @param string $destinationFolder
     *
     * @return bool
     */
    private function foldersEqual($sourceFolder, $destinationFolder)
    {
        if ($this->getDirSize($sourceFolder) !== $this->getDirSize($destinationFolder)) {
            return false;
        }

        $sourceCount      = $this->countNumberOfFilesAndFolders($sourceFolder);
        $destinationCount = $this->countNumberOfFilesAndFolders($destinationFolder);

        if ($sourceCount !== $destinationCount) {
            return false;
        }

        return true;
    }

    /**
     * @param string $dir
     *
     * @throws \Exception
     *
     * @return int
     */
    public function getDirSize($dir)
    {
        $output = $this->runCommand(sprintf('du -s %s', $dir));
        $size   = (int) $output;

        return $size;
    }

    /**
     * @param string $dir
     *
     * @return int
     */
    private function countNumberOfFilesAndFolders($dir)
    {
        $output = $this->runCommand(sprintf('find %s | wc -l', $dir));

        $count = (int) $output;

        return $count;
    }

    /**
     * @param string $command
     *
     * @throws \Exception
     *
     * @return string
     */
    private function runCommand($command)
    {
        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \Exception($process->getErrorOutput());
        }

        return $process->getOutput();
    }

    /**
     * Create test dirs from maps property and
     * populates source folders with some data.
     */
    private function createTestDirs()
    {
        foreach ($this->maps as $dir) {
            $this->fs->mkdir(
                array(
                $dir['src'],
                $dir['dst'],
                )
            );

            $this->fs->mirror(TEST_DIR . '/SyncFS', $dir['src']);
        }
    }

    /**
     * @return string
     */
    protected function getCommandName()
    {
        return SyncCommand::COMMAND_NAME;
    }
}
