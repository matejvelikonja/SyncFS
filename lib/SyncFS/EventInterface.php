<?php

namespace SyncFS;

use SyncFS\Client\Output;
use SyncFS\Map\MapInterface;

/**
 * Interface EventInterface
 *
 * @package SyncFS
 * @author  Matej Velikonja <matej@velikonja.si>
 */
interface EventInterface
{
    /**
     * @param string $file
     *
     * @return $this
     */
    public function setFile($file);

    /**
     * @return string
     */
    public function getFile();

    /**
     * @param float $progress
     *
     * @return $this
     */
    public function setOverallProgress($progress);

    /**
     * @return float
     */
    public function getOverallProgress();

    /**
     * @param \SyncFS\Map\MapInterface $map
     *
     * @return $this
     */
    public function setMap(MapInterface $map);

    /**
     * @return \SyncFS\Map\MapInterface
     */
    public function getMap();

    /**
     * @return Output
     */
    public function getOutput();

    /**
     * @param Output $output
     *
     * @return $this
     */
    public function setOutput(Output $output);
}