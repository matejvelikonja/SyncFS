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
     * Returns progress read from rsync output.
     * If parser cannot read progress it returns null.
     *
     * @param string $buffer
     *
     * @return float | null
     */
    public function getProgress($buffer)
    {
        $regexp = '/to-check=(\d+)\/(\d+)/';

        // 1.86K 100%    1.77MB/s    0:00:00 (xfer#5, to-check=11/20)
        preg_match($regexp, $buffer, $matches);

        if (count($matches) < 3) {
            return null;
        }

        $remaining = $matches[1];
        $all       = $matches[2];
        $completed = $all - $remaining;

        $result = round($completed / $all, 2);

        return $result;
    }

    public function getFile($buffer)
    {
    }
}