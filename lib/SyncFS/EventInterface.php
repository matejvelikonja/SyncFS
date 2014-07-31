<?php

namespace SyncFS;

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
     * @param \SyncFS\Map\MapInterface $map
     *
     * @return $this
     */
    public function setMap(MapInterface $map);

    /**
     * @return \SyncFS\Map\MapInterface
     */
    public function getMap();
}
