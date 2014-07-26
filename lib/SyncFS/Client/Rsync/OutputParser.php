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
    private $buffer;

    /**
     * Constructor.
     *
     * @param array $buffer
     */
    public function __construct(array $buffer = array())
    {
        $this->buffer = $buffer;
    }

    /**
     * @param string $buffer
     *
     * @return $this
     */
    public function addBuffer($buffer)
    {
        $this->buffer[] = $buffer;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastBuffer()
    {
        return end($this->buffer);
    }

    /**
     * Returns progress read from rsync output.
     * If parser cannot read progress it returns null.
     *
     * @return float | null
     */
    public function getProgress()
    {
        preg_match($this->toCheckPattern, $this->getLastBuffer(), $matches);

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
     * Tries to determine if $buffer contains file that is syncing. If yes, it returns filename.
     * This is a very basic implementation. It does not know about files in current directory (without any /).
     *
     * @return string | null
     */
    public function getFile()
    {
        if (null !== $this->getProgress($this->getLastBuffer())) {
            return null;
        }

        if (strpos($this->getLastBuffer(), '/')) {
            return trim(preg_replace('/\s+/', ' ', $this->getLastBuffer()));
        }

        return null;
    }
}