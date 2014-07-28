<?php

namespace SyncFS\Client\Rsync;
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
     * @var float | null
     */
    private $overallProgress;

    /**
     * @var array
     */
    private $files;

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

        $this->overallProgress = null;
        $this->files           = array();
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

        if ($this->hasFinished()) {
            $this->overallProgress = 1;

            return $this;
        }

        $progress = $this->determineOverallProgress();

        if ($progress) {
            $this->overallProgress = $progress;
        } else {
            $file = $this->determineFile();

            if ($file) {
                $this->files[] = $file;
            }
        }

        return $this;
    }

    /**
     * Returns overall progress. If returns null, syncing has not started yet.
     *
     * @return float | null
     */
    public function getOverallProgress()
    {
        return $this->overallProgress;
    }

    /**
     * @return string
     */
    public function getLastFile()
    {
        return end($this->files);
    }

    /**
     * Returns progress read from rsync output.
     * If parser cannot read progress it returns null.
     *
     * @return float | null
     */
    private function determineOverallProgress()
    {
        preg_match($this->toCheckPattern, $this->output->last(), $matches);

        if (count($matches) < 3) {
            return null;
        }

        $remaining = $matches[1];
        $all       = $matches[2];
        $completed = $all - $remaining;

        $result = round($completed / $all, 2);

        return $result;
    }

    /**
     * Tries to determine if rsync has finished.
     *
     * @return bool
     */
    private function hasFinished()
    {
        if (preg_match('/sent (.+) bytes received/', $this->output->last())) {
            return true;
        }

        if (preg_match('/total size is (.+) speedup is/', $this->output->last())) {
            return true;
        }

        return false;
    }

    /**
     * Tries to determine file that is syncing.
     * This is a very basic implementation. It does not know about files in current directory (without any /).
     *
     * @return string | null
     */
    private function determineFile()
    {
        if (strpos($this->output->last(), '/')) {
            return $this->output->last();
        }

        return null;
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