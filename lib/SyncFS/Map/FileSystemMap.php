<?php

namespace SyncFS\Map;

/**
 * Class FileSystemMap
 *
 * @package SyncFS\Map
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class FileSystemMap implements MapInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $source;
    /**
     * @var string
     */
    private $destination;

    /**
     * @param string $name
     * @param string $source
     * @param string $destination
     */
    public function __construct($name = null, $source = null, $destination = null)
    {
        $this->setName($name);
        $this->setSource($source);
        $this->setDestination($destination);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $destination
     *
     * @return $this
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param string $source
     *
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }
}