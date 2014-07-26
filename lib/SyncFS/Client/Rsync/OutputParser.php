<?php

namespace SyncFS\Client\Rsync;

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
     * @var array
     */
    private $lines;

    /**
     * @var float | null
     */
    private $overallProgress;

    /**
     * @var array
     */
    private $files;

    /**
     * Constructor.
     *
     * @param array $lines
     */
    public function __construct(array $lines = array())
    {
        $this->overallProgress = null;
        $this->files           = array();

        $this->setLines($lines);
    }

    /**
     * @param array $lines
     *
     * @return $this
     */
    public function setLines(array $lines)
    {
        foreach ($lines as $line) {
            $this->addLine($line);
        }

        return $this;
    }

    /**
     * @param string $line
     *
     * @return $this
     */
    public function addLine($line)
    {
        // removes new lines
        $line = trim(preg_replace('/\s+/', ' ', $line));

        $this->lines[] = $line;

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
     * @return string
     */
    private function getLastLine()
    {
        return end($this->lines);
    }

    /**
     * Returns progress read from rsync output.
     * If parser cannot read progress it returns null.
     *
     * @return float | null
     */
    private function determineOverallProgress()
    {
        preg_match($this->toCheckPattern, $this->getLastLine(), $matches);

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
        if (preg_match('/sent (.+) bytes received/', $this->getLastLine())) {
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
        if (strpos($this->getLastLine(), '/')) {
            return $this->getLastLine();
        }

        return null;
    }
}