<?php

namespace SyncFS\Test\Client;

use SyncFS\Client\Output;

/**
 * Class OutputTest
 *
 * @package SyncFS\Test\Client
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class OutputTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array  $array
     * @param string $expectedResult
     *
     * @dataProvider secondLastProvider
     */
    public function testGetSecondLastMethod(array $array, $expectedResult)
    {
        $output = new Output($array);

        $this->assertEquals($expectedResult, $output->secondLast());
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
     * @param array  $array
     * @param string $expectedResult
     *
     * @dataProvider toStringMethodProvider
     */
    public function testToStringMethod(array $array, $expectedResult)
    {
        $output = new Output($array);

        $this->assertEquals($expectedResult, $output->__toString());
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
}
 