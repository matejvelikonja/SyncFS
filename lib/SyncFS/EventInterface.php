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
     * @param string $buffer
     *
     * @return $this
     */
    public function setBuffer($buffer);

    /**
     * @return string
     */
    public function getBuffer();

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
     * Returns calculated number of files.
     *
     * @return int | null
     */
    public function getFilesCount();

    /**
     * @param Bag $bag
     *
     * @return $this
     */
    public function setCompletedFiles(Bag $bag);

    /**
     * @return Bag
     */
    public function getCompletedFiles();

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
