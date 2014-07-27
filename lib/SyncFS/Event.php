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
    private $file;

    /**
     * @var float
     */
    private $overallProgress;

    /**
     * @var MapInterface
     */
    private $map;

    /**
     * @param string $file
     *
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
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

    /**
     * @param float $overallProgress
     *
     * @return $this
     */
    public function setOverallProgress($overallProgress)
    {
        $this->overallProgress = $overallProgress;

        return $this;
    }

    /**
     * @return float
     */
    public function getOverallProgress()
    {
        return $this->overallProgress;
    }

}