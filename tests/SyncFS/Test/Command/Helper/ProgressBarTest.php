<?php

namespace SyncFS\Test\Command\Helper;

use Symfony\Component\Console\Output\OutputInterface;
use SyncFS\Command\Helper\ProgressBar;

/**
 * Class ProgressBarTest
 *
 * @package SyncFS\Test\Command\Helper
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class ProgressBarTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param int  $step
     * @param bool $expectedResult
     *
     * @dataProvider isStartedMethodProvider
     */
    public function testIsStartedMethod($step, $expectedResult)
    {
        /** @var OutputInterface $output */
        $output = $this->getMockBuilder('Symfony\Component\Console\Output\OutputInterface')
            ->disableOriginalConstructor()
            ->getMock();

        if (class_exists('\Symfony\Component\Console\Helper\ProgressBar')) {
            $barBuilder = $this->getMockBuilder('\Symfony\Component\Console\Helper\ProgressBar');
        } else {
            $barBuilder = $this->getMockBuilder('\Symfony\Component\Console\Helper\ProgressHelper');
        }

        $bar = $barBuilder
            ->disableOriginalConstructor()
            ->getMock();

        /** @var ProgressBar|\PHPUnit_Framework_MockObject_MockObject $bar */

        $bar->expects($this->once())
            ->method('getStep')
            ->willReturn($step);

        $progressBar = new ProgressBar($output, $bar);

        $this->assertEquals($expectedResult, $progressBar->isStarted());
    }

    /**
     * @return array
     */
    public function isStartedMethodProvider()
    {
        return array(
            array(0, false),
            array(1, true),
            array(15000, true),
        );
    }
}
