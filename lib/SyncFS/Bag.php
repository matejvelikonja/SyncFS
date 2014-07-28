<?php

namespace SyncFS;

/**
 * Class Bag
 *
 * @package SyncFS
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class Bag implements \IteratorAggregate, \Countable, \ArrayAccess
{
    /**
     * @var array
     */
    protected $elements;

    /**
     * @param array $elements
     */
    public function __construct(array $elements = array())
    {
        $this->setData($elements);
    }

    /**
     * @param array $elements
     */
    public function setData(array $elements)
    {
        $this->elements = $elements;
    }

    /**
     * @param mixed $element
     *
     * @return $this
     */
    public function add($element)
    {
        $this->elements[] = $element;

        return $this;
    }

    /**
     * Returns last element..
     *
     * @return string
     */
    public function last()
    {
        return end($this->elements);
    }

    /**
     * Returns second last element.
     *
     * @return string | false
     */
    public function secondLast()
    {
        end($this->elements);

        return prev($this->elements);
    }

    /**
     * Returns first element.
     *
     * @return string
     */
    public function first()
    {
        return reset($this->elements);
    }

    /**
     * Returns number of all elements.
     *
     * @return int
     */
    public function count()
    {
        return count($this->elements);
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->elements);
    }

    /**
     * @param int $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->elements[$offset]);
    }

    /**
     * @param int $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->elements[$offset];
    }

    /**
     * @param int   $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->elements[$offset] = $value;
    }

    /**
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->elements[$offset]);
    }

    /**
     * Removes all elements.
     *
     * @return $this
     */
    public function clear()
    {
        $this->elements = array();

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return ! $this->elements;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->elements;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(PHP_EOL, $this->elements);
    }
}