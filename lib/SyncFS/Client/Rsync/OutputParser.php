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
     * Returns progress read from rsync output.
     * If parser cannot read progress it returns null.
     *
     * @param string $buffer
     *
     * @return float | null
     */
    public function getProgress($buffer)
    {
        preg_match($this->toCheckPattern, $buffer, $matches);

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
     * @param string $buffer
     *
     * @return string | null
     */
    public function getFile($buffer)
    {
        if (null !== $this->getProgress($buffer)) {
            return null;
        }

        if (strpos($buffer, '/')) {
            return $buffer;
        }

        return null;
    }
}