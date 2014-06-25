<?php

namespace SyncFS\Map;

/**
 * Class MapBag
 *
 * @package SyncFS\Map
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class MapBag implements \IteratorAggregate, \Countable, \ArrayAccess
{
    /**
     * @var array|MapInterface
     */
    private $maps;

    /**
     * @param array|MapInterface[] $maps
     */
    public function __construct(array $maps = array())
    {
        // reset keys
        $this->maps = array_values($maps);
    }

    /**
     * @param MapInterface $mapInterface
     *
     * @return $this
     */
    public function add(MapInterface $mapInterface)
    {
        $this->maps[] = $mapInterface;

        return $this;
    }

    /**
     * @return \ArrayIterator|\Traversable|MapInterface[]
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->maps);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->maps);
    }

    /**
     * @return array|\Traversable|MapInterface[]
     */
    public function all()
    {
        return $this->maps;
    }

    /**
     * @return MapInterface
     */
    public function first()
    {
        if (! $this->count()) {
            return null;
        }

        list($first) = $this->maps;

        return $first;
    }

    /**
     * @param int $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->maps[$offset]);
    }

    /**
     * @param int $offset
     *
     * @return MapInterface
     */
    public function offsetGet($offset)
    {
        return $this->maps[$offset];
    }

    /**
     * @param int          $offset
     * @param MapInterface $value
     */
    public function offsetSet($offset, $value)
    {
        $this->maps[$offset] = $value;
    }

    /**
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->maps[$offset]);
    }
}