<?php

namespace SyncFS\Map;

/**
 * Interface MapInterface
 *
 * @package SyncFS\Map
 * @author  Matej Velikonja <matej@velikonja.si>
 */
interface MapInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * @param string $destination
     *
     * @return $this
     */
    public function setDestination($destination);

    /**
     * @return string
     */
    public function getDestination();

    /**
     * @param string $source
     *
     * @return $this
     */
    public function setSource($source);

    /**
     * @return string
     */
    public function getSource();
}
