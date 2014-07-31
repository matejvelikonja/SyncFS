<?php

namespace SyncFS\Test\Functional\Helper;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * Class FileSystemHelper.
 *
 * Helper assists with creating test filesystem structure.
 *
 * @package SyncFS\Test\Functional\Helper
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class FileSystemHelper
{
    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $fs;

    public function __construct()
    {
        $this->fs  = new Filesystem();
    }

    /**
     * Creates directory and some random files inside.
     *
     * @param string $dir
     *
     * @throws \RuntimeException
     */
    public function create($dir)
    {
        if ($this->fs->exists($dir)) {
            throw new \RuntimeException("Directory `$dir` should not exists.");
        }

        $folders = array(
            $dir,
            $dir . DIRECTORY_SEPARATOR . 'sub1',
            $dir . DIRECTORY_SEPARATOR . 'sub-2',
        );

        foreach ($folders as $folder) {
            $this->fs->mkdir($folder);

            foreach (range(0, 10) as $i) {
                $name = sprintf(
                    '%03d-%s.txt',
                    $i,
                    $this->getRandomString(rand(3, 10))
                );

                $this->createRandomFile($folder . DIRECTORY_SEPARATOR . $name);
            }
        }


        $this->createRandomBigFile($dir . "/biiiiiiiig_200MB.dat", 200);
    }

    /**
     * Cleans up temporary created files and folders.
     *
     * @param string $dir
     */
    public function cleanUp($dir)
    {
        $this->fs->remove($dir);
    }

    /**
     * @param string $path
     * @param int    $size
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return int|null
     */
    private function createRandomBigFile($path, $size)
    {
        if (! is_int($size) || $size < 1) {
            throw new \InvalidArgumentException('Size argument is not properly defined.');
        }

        $process = new Process(
            sprintf(
                'dd if=/dev/urandom of="%s" bs=1048576 count=%d',
                $path,
                $size
            )
        );

        $process->run();

        if (! $process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        return $process->getExitCode();
    }

    /**
     * Create random small file.
     *
     * @param string $path
     */
    private function createRandomFile($path)
    {
        $content = $this->getRandomString(rand(1000, 20000), true);

        $this->fs->dumpFile($path, $content . PHP_EOL);
    }

    /**
     * @param int  $length
     * @param bool $allowWhitespaceChars
     *
     * @return string
     */
    private function getRandomString($length, $allowWhitespaceChars = false)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $content    = '';

        if ($allowWhitespaceChars) {
            $characters .= "\n\t ";
        }

        for ($i = 0; $i < $length; $i++) {
            $content .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $content;
    }
}
