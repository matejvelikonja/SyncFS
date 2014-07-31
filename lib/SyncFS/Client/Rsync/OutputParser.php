<?php

namespace SyncFS\Client\Rsync;

use SyncFS\Bag;
use SyncFS\Client\Output;

/**
 * Class OutputParser
 *
 * @package SyncFS\Client\Rsync
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class OutputParser
{
    /**
     * Reads 11 and 20 from this line:
     * Example data: 1.86K 100%    1.77MB/s    0:00:00 (xfer#5, to-check=11/20)
     *
     * @var string
     */
    private $toCheckPattern = '/to-check=(\d+)\/(\d+)/';

    /**
     * @var Bag
     */
    private $completedFiles;

    /**
     * @var \SyncFS\Client\Output
     */
    private $output;

    /**
     * Constructor.
     *
     * @param Output $output
     */
    public function __construct(Output $output = null)
    {
        if (!$output) {
            $output = new Output();
        }

        $this->completedFiles  = new Bag();
        $this->output          = $output;

        $this->recalculate();
    }

    /**
     * Recalculate all properties.
     *
     * @return $this
     */
    public function recalculate()
    {
        if ($this->output->isEmpty()) {
            return $this;
        }

        $files = $this->determineFiles();

        foreach ($files as $file) {
            if (! $this->completedFiles->exists($file)) {
                $this->completedFiles->add($file);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getLastFile()
    {
        $all = $this->completedFiles->all();

        return end($all);
    }

    /**
     * Tries to determine file that is syncing.
     * This is a very basic implementation. It does not know about files in current directory (without any /).
     *
     * @return array
     */
    private function determineFiles()
    {
        //TODO: change regexp prefix
        preg_match_all('/sync-from-here\/(.*)/', $this->output->__toString(), $matches);

        if (isset($matches[0])) {
            return $matches[0];
        }

        return array();
    }

    /**
     * @return int
     */
    public function getFilesCount()
    {
        preg_match($this->toCheckPattern, $this->output->__toString(), $matches);

        if (count($matches) < 3) {
            return null;
        }

        return $matches[2];
    }

    /**
     * @return \SyncFS\Bag
     */
    public function getCompletedFiles()
    {
        return $this->completedFiles;
    }

    /**
     * @param \SyncFS\Client\Output $output
     *
     * @return $this
     */
    public function setOutput(Output $output)
    {
        $this->output = $output;

        return $this;
    }

    /**
     * @return \SyncFS\Client\Output
     */
    public function getOutput()
    {
        return $this->output;
    }
}
