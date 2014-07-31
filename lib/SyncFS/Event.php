<?php

namespace SyncFS;

use SyncFS\Map\MapInterface;

/**
 * Class Event
 *
 * @package SyncFS
 * @author  Matej Velikonja <mmatej@velikonja.si>
 */
class Event implements EventInterface
{
    /**
     * @var string
     */
    private $buffer;

    /**
     * @var MapInterface
     */
    private $map;

    /**
     * @param string       $buffer
     * @param MapInterface $map
     */
    public function __construct($buffer, MapInterface $map = null)
    {
        $this->buffer = $buffer;
        $this->map    = $map;
    }


    /**
     * @return string
     */
    public function getBuffer()
    {
        return $this->buffer;
    }

    /**
     * @param string $buffer
     *
     * @return $this
     */
    public function setBuffer($buffer)
    {
        $this->buffer = $buffer;

        return $this;
    }

    /**
     * @param \SyncFS\Map\MapInterface $map
     *
     * @return $this
     */
    public function setMap(MapInterface $map)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * @return \SyncFS\Map\MapInterface
     */
    public function getMap()
    {
        return $this->map;
    }
}
