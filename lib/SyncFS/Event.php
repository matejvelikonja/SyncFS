<?php

namespace SyncFS;

use SyncFS\Client\Output;
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
     * @var Output
     */
    private $output;

    /**
     * @param string        $file
     * @param float         $overallProgress
     * @param MapInterface  $map
     * @param Client\Output $output
     */
    public function __construct($file = null, $overallProgress = null, MapInterface $map = null, Output $output = null)
    {
        $this->file            = $file;
        $this->map             = $map;
        $this->overallProgress = $overallProgress;
        $this->output          = $output;
    }

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
