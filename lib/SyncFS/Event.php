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
    private $buffer;

    /**
     * @var string
     */
    private $file;

    /**
     * @var Bag
     */
    private $completedFiles;

    /**
     * @var int
     */
    private $filesCount;

    /**
     * @var MapInterface
     */
    private $map;

    /**
     * @var Output
     */
    private $output;

    /**
     * @param string        $buffer
     * @param string        $file
     * @param Bag           $completedFiles
     * @param int           $filesCount
     * @param MapInterface  $map
     * @param Client\Output $output
     */
    public function __construct(
        $buffer,
        $file = null,
        Bag $completedFiles = null,
        $filesCount = null,
        MapInterface $map = null,
        Output $output = null
    ) {
        $this->buffer          = $buffer;
        $this->file            = $file;
        $this->completedFiles  = $completedFiles;
        $this->filesCount      = $filesCount;
        $this->map             = $map;
        $this->output          = $output;
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
     * @return \SyncFS\Bag
     */
    public function getCompletedFiles()
    {
        return $this->completedFiles;
    }

    /**
     * @param \SyncFS\Bag $files
     *
     * @return $this
     */
    public function setCompletedFiles(Bag $files)
    {
        $this->completedFiles = $files;

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

    /**
     * @return int
     */
    public function getFilesCount()
    {
        return $this->filesCount;
    }

    /**
     * @param int $filesCount
     *
     * @return $this
     */
    public function setFilesCount($filesCount)
    {
        $this->filesCount = $filesCount;

        return $this;
    }
}
