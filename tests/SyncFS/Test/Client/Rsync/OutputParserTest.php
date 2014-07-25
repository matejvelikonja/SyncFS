<?php

namespace SyncFS\Test\Client\Rsync;
use SyncFS\Client\Rsync\OutputParser;

/**
 * Class OutputParserTest
 *
 * @package SyncFS\Test\Client\Rsync
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class OutputParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $buffer
     * @param float  $expectedResult
     *
     * @dataProvider getSimpleProgressBufferData
     */
    public function testSimpleProgressParsing($buffer, $expectedResult)
    {
        $parser = new OutputParser();
        $result = $parser->getProgress($buffer);

        $this->assertEquals($expectedResult, $result, 'Parsing of given buffer failed.');
    }

    /**
     * @return array
     */
    public function getSimpleProgressBufferData()
    {
        return array(
            array('967 100%  944.34kB/s    0:00:00 (xfer#12, to-check=20/20)', 0),
            array('1.86K 100%    1.77MB/s    0:00:00 (xfer#5, to-check=11/20)', 0.45),
            array('967 100%  944.34kB/s    0:00:00 (xfer#12, to-check=0/20)', 1),
            array('something that definitely can not be read by the parser...', null),
        );
    }
}
 