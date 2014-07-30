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

    /**
     * @var string
     */
    private $dir;

    /**
     * @param string $dir
     *
     * @throws \RuntimeException
     */
    public function __construct($dir)
    {
        $this->fs  = new Filesystem();
        $this->dir = $dir;

        if ($this->fs->exists($this->dir)) {
            throw new \RuntimeException("Directory `{$this->dir}` should not exists.");
        }
    }


    /**
     * Creates directory and some random files inside.
     */
    public function create()
    {
        $this->fs->mkdir($this->dir);

        foreach (range(0, 5) as $i) {
            $size = rand(1, 5) * ($i + 1);
            $this->createRandomFile($this->dir . "/{$i}_{$size}MB.txt", $size);
        }

    }

    /**
     * Cleans up temporary created files and folders.
     */
    public function cleanUp()
    {
        $this->fs->remove($this->dir);
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
    private function createRandomFile($path, $size)
    {
        if (! is_int($size) || $size < 1) {
            throw new \InvalidArgumentException('Size argument is properly defined.');
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
}
