<?php

namespace SyncFS\Test\Map;

use SyncFS\Map\FileSystemMap;
use SyncFS\Map\MapBag;
use SyncFS\Test\TestCase;

/**
 * Class MapBagTest
 *
 * @package SyncFS\Test\Map
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class MapBagTest extends TestCase
{
    /**
     * Tests if all method returns given array.
     */
    public function testIfAllReturnsGivenArray()
    {
        $data = range(0, 10, 3);
        $bag  = new MapBag($data);

        $this->assertEquals($data, $bag->all());
    }

    /**
     * Test count method.
     *
     * @param array $data
     * @param int   $result
     *
     * @dataProvider countProvider
     */
    public function testCountMethod(array $data, $result)
    {
        $bag = new MapBag($data);

        $this->assertEquals($result, $bag->count());
    }

    /**
     * @return array
     */
    public function countProvider()
    {
        return array(
            array(array(), 0),
            array(array(1), 1),
            array(array(1, 2), 2),
        );
    }

    /**
     * Test adding of single map.
     */
    public function testAddSingleMapToBag()
    {
        $bag = new MapBag();
        $map = new FileSystemMap();

        $bag->add($map);

        $this->assertEquals(1, $bag->count());
    }

    /**
     * Tests if getIterator returns \ArrayIterator object.
     */
    public function testGetIteratorReturnObject()
    {
        $bag = new MapBag(array());

        $this->assertInstanceOf('\ArrayIterator', $bag->getIterator());
    }

    /**
     * Test if first() returns null when bag is empty.
     */
    public function testIfFirstReturnsNullWhenBagIsEmpty()
    {
        $bag = new MapBag(array());

        $this->assertNull($bag->first());
    }

    /**
     * Tests if first() returns really first element.
     */
    public function testIfFirstReturnsFirstElement()
    {
        $bag = new MapBag(array('a', 'b', 'c'));

        $this->assertEquals('a', $bag->first());
    }

    /**
     * Tests if offsetExists() returns true when elements exists.
     */
    public function testOffsetExistsReturnsTrue()
    {
        $bag = new MapBag(array('a', 'b', 'c'));

        $this->assertTrue($bag->offsetExists(2));
    }

    /**
     * Tests if offsetExists() returns false when elements does not exist.
     */
    public function testOffsetExistsReturnsFalse()
    {
        $bag = new MapBag(array('a', 'b', 'c'));

        $this->assertFalse($bag->offsetExists(25));
    }

    /**
     * Tests offsetSet().
     */
    public function testOffsetSet()
    {
        $map = new FileSystemMap();
        $bag = new MapBag();
        $bag->offsetSet(88, $map);

        $this->assertEquals($map, $bag->offsetGet(88));
    }

    /**
     * Tests offsetUnset().
     */
    public function testOffsetUnset()
    {
        $bag = new MapBag(array(1, 2, 3));
        $bag->offsetUnset(1);

        $this->assertCount(2, $bag);
    }
}
