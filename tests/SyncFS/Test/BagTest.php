<?php

namespace SyncFS\Test;

use SyncFS\Bag;

/**
 * Class BagTest
 *
 * @package SyncFS\Test
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class BagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $array
     * @param mixed $expectedResult
     *
     * @dataProvider firstMethodProvider
     */
    public function testFirstMethod(array $array, $expectedResult)
    {
        $bag = new Bag($array);

        $this->assertEquals($expectedResult, $bag->first());
    }

    /**
     * @return array
     */
    public function firstMethodProvider()
    {
        return array(
            array(array(), false),
            array(array(1), 1),
            array(array(3, 2, 1), 3),
        );
    }

    /**
     * @param array $array
     * @param mixed $expectedResult
     *
     * @dataProvider lastMethodProvider
     */
    public function testLastMethod(array $array, $expectedResult)
    {
        $bag = new Bag($array);

        $this->assertEquals($expectedResult, $bag->last());
    }

    /**
     * @return array
     */
    public function lastMethodProvider()
    {
        return array(
            array(array(), false),
            array(array(1), 1),
            array(array(1, 2, 3), 3),
        );
    }

    /**
     * @param array $array
     * @param mixed $expectedResult
     *
     * @dataProvider secondLastProvider
     */
    public function testGetSecondLastMethod(array $array, $expectedResult)
    {
        $bag = new Bag($array);

        $this->assertEquals($expectedResult, $bag->secondLast());
    }

    /**
     * @return array
     */
    public function secondLastProvider()
    {
        return array(
            array(
                array(1, 2, 3, 4, 5, 6, 7, 8, 9, 100, 30, 70, 1), 70
            ),
            array(
                array(1, 2, 3), 2
            ),
            array(
                array(1), false
            )
        );
    }

    /**
     * @param array $array
     * @param mixed $expectedResult
     *
     * @dataProvider toStringMethodProvider
     */
    public function testToStringMethod(array $array, $expectedResult)
    {
        $bag = new Bag($array);

        $this->assertEquals($expectedResult, $bag->__toString());
    }

    /**
     * @return array
     */
    public function toStringMethodProvider()
    {
        return array(
            array(
                array(1, 2, 3), "1\n2\n3"
            ),
            array(
                array('a', 'b', 'c', 'd', 'e', 'f'), "a\nb\nc\nd\ne\nf"
            ),
        );
    }

    /**
     * @param array $array
     * @param mixed $expectedResult
     *
     * @dataProvider isEmptyMethodProvider
     */
    public function testIsEmptyMethod(array $array, $expectedResult)
    {
        $bag = new Bag($array);

        $this->assertEquals($expectedResult, $bag->isEmpty());
    }

    /**
     * @return array
     */
    public function isEmptyMethodProvider()
    {
        return array(
            array(
                array(), true
            ),
            array(
                array(1), false
            ),
            array(
                array(1, 2), false
            ),
       );
    }

    /**
     * @param array $array
     * @param mixed $expectedResult
     *
     * @dataProvider countMethodProvider
     */
    public function testCountMethod(array $array, $expectedResult)
    {
        $bag = new Bag($array);

        $this->assertEquals($expectedResult, $bag->count());
    }

    /**
     * @return array
     */
    public function countMethodProvider()
    {
        return array(
            array(
                array(), 0
            ),
             array(
                array(1), 1
             ),
            array(
                array(1, 2), 2,
            ),
       );
    }

    /**
     * Tests if getIterator returns \ArrayIterator object.
     */
    public function testGetIteratorReturnObject()
    {
        $bag = new Bag(array());

        $this->assertInstanceOf('\ArrayIterator', $bag->getIterator());
    }

    /**
     * Tests if offsetExists() returns true when elements exists.
     */
    public function testOffsetExistsReturnsTrue()
    {
        $bag = new Bag(array(1, 2, 3));

        $this->assertTrue($bag->offsetExists(2));
    }

    /**
     * Tests if offsetExists() returns false when elements does not exist.
     */
    public function testOffsetExistsReturnsFalse()
    {
        $bag = new Bag(array(1, 2, 3));

        $this->assertFalse($bag->offsetExists(25));
    }

    /**
     * Tests offsetSet().
     */
    public function testOffsetSet()
    {
        $bag = new Bag();
        $bag->offsetSet(88, 101);

        $this->assertEquals(101, $bag->offsetGet(88));
    }

    /**
     * Tests offsetUnset().
     */
    public function testOffsetUnset()
    {
        $bag = new Bag(array(1, 2, 3));
        $bag->offsetUnset(2);

        $this->assertCount(2, $bag);
    }

    /**
     * Tests if all method returns given array.
     */
    public function testIfAllReturnsGivenArray()
    {
        $data = range(0, 10, 3);
        $bag  = new Bag($data);

        $this->assertEquals($data, $bag->all());
    }

    /**
     * Test adding of single element.
     */
    public function testAddSingleElementToBag()
    {
        $bag = new Bag();

        $bag->add(55);

        $this->assertEquals(1, $bag->count());
    }

    /**
     * Test if clear method works.
     */
    public function testClearMethod()
    {
        $bag = new Bag(array(1, 2, 3));

        $bag->clear();

        $this->assertEquals(0, $bag->count());
    }
}
 