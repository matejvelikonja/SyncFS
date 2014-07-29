<?php

namespace SyncFS\Test\Client\Rsync;

use SyncFS\Client\Output;
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
     * @param array $lines
     * @param float $expectedResult
     *
     * @dataProvider getSimpleProgressBufferData
     */
    public function testSimpleProgressParsing(array $lines, $expectedResult)
    {
        $output = new Output($lines);
        $parser = new OutputParser($output);
        $result = $parser->getOverallProgress();

        $this->assertEquals($expectedResult, $result, 'Parsing of given buffer failed.');
    }

    /**
     * @return array
     */
    public function getSimpleProgressBufferData()
    {
        return array(
            array(
                array(
                    '967 100%  944.34kB/s    0:00:00 (xfer#12, to-check=20/20)',
                ),
                0
            ),
            array(
                array(
                    '1.86K 100%    1.77MB/s    0:00:00 (xfer#5, to-check=11/20)',
                ),
                0.45
            ),
            array(
                array(
                    '967 100%  944.34kB/s    0:00:00 (xfer#12, to-check=0/20)',
                ),
                1
            ),
            array(
                array(
                    'something that definitely can not be read by the parser...',
                ),
                null
            ),
        );
    }

    /**
     * Tests if 1 is returned when rsync finishes.
     */
    public function testIfOverallProgressReturns1OnFinish()
    {
        $lines = $this->getSimpleRsyncOutput();

        $output = new Output($lines);
        $parser = new OutputParser($output);

        $this->assertEquals(1, $parser->getOverallProgress());
    }

    /**
     * Tests if 23 is returned as number of all files to sync.
     */
    public function testFilesCountMethod()
    {
        $lines = $this->getSimpleRsyncOutput();

        $output = new Output($lines);
        $parser = new OutputParser($output);

        $this->assertEquals(23, $parser->getFilesCount());
    }

    /**
     * @return array
     */
    private function getSimpleRsyncOutput()
    {
        return array(
            'building file list ...',
            '23 files to consider',
            'Test/',
            'Test/TestCase.php',
            '1.29K 100%    0.00kB/s    0:00:00 (xfer#1, to-check=20/23)',
            'Test/Client/',
            'Test/Client/Rsync/',
            'Test/Client/Rsync/OutputParserTest.php',
            '2.84K 100%    2.71MB/s    0:00:00 (xfer#2, to-check=17/23)',
            'Test/Configuration/',
            'Test/Configuration/ConfigurationTest.php',
            '790 100%  771.48kB/s    0:00:00 (xfer#3, to-check=15/23)',
            'Test/Configuration/ReaderTest.php',
            '1.44K 100%    1.37MB/s    0:00:00 (xfer#4, to-check=14/23)',
            'sent 7.78K bytes  received 360 bytes  16.28K bytes/sec', // rsync finishes syncing at this moment
            'total size is 20.82K  speedup is 2.56'
        );
    }

    /**
     * @param array  $lines
     * @param string $expectedResult
     *
     * @dataProvider getSimpleFileProgressData
     */
    public function testSimpleFileParsing(array $lines, $expectedResult)
    {
        $output = new Output($lines);
        $parser = new OutputParser($output);
        $result = $parser->getLastFile();

        $this->assertEquals($expectedResult, $result, 'Parsing of given buffer failed.');
    }

    /**
     * @return array
     */
    public function getSimpleFileProgressData()
    {
        return array(
            array(
                array(
                    'Test/Resources/data/',
                ),
                'Test/Resources/data/'
            ),
            array(
                array(
                    'Test/Resources/data/config.example.yml',
                ),
                'Test/Resources/data/config.example.yml'
            ),
            array(
                array(
                    'building file list ...',
                ),
                null
            ),
            array(
                array(
                    '149 files to consider',
                ),
                null
            ),
            array(
                array(
                    'created directory something.bckp',
                ),
                null
            ),
        );
    }
}
