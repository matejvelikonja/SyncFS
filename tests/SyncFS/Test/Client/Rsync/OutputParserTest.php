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
        $parser = new OutputParser(array($buffer));
        $result = $parser->getProgress();

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

    /**
     * @param string $buffer
     * @param string $expectedResult
     *
     * @dataProvider getSimpleFileProgressData
     */
    public function testSimpleFileParsing($buffer, $expectedResult)
    {
        $parser = new OutputParser(array($buffer));
        $result = $parser->getFile();

        $this->assertEquals($expectedResult, $result, 'Parsing of given buffer failed.');
    }

    /**
     * @return array
     */
    public function getSimpleFileProgressData()
    {
        return array(
            array('Test/Resources/data/', 'Test/Resources/data/'),
            array('Test/Resources/data/config.example.yml', 'Test/Resources/data/config.example.yml'),
            array('165 100%  161.13kB/s    0:00:00 (xfer#10, to-check=3/20)', null),
            array('building file list ...', null),
            array('149 files to consider', null),
            array('created directory something.bckp', null)
        );
    }
}
 