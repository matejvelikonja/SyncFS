<?php

namespace SyncFS\Client;

/**
 * Class Output
 *
 * @package SyncFS\Client
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class Output implements \Countable
{
    /**
     * @var array
     */
    private $lines;

    /**
     * @param array $lines
     */
    public function __construct(array $lines = array())
    {
        $this->setLines($lines);
    }

    /**
     * @param string $line
     *
     * @return $this
     */
    public function add($line)
    {
        // removes new lines
        $line = trim(preg_replace('/\s+/', ' ', $line));

        $this->lines[] = $line;

        return $this;
    }

    /**
     * @param array $lines
     *
     * @return $this
     */
    public function setLines(array $lines)
    {
        foreach ($lines as $line) {
            $this->add($line);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * Returns last lines.
     *
     * @return string
     */
    public function last()
    {
        return end($this->lines);
    }

    /**
     * Returns second last line.
     *
     * @return string | false
     */
    public function secondLast()
    {
        end($this->lines);

        return prev($this->lines);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->lines);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return ! $this->lines;
    }
}