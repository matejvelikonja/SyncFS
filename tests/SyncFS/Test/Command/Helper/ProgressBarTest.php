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

        /** @var ProgressBar|\PHPUnit_Framework_MockObject_MockObject $bar */
        $bar    = $this->getMockBuilder('\Symfony\Component\Console\Helper\ProgressBar')
            ->disableOriginalConstructor()
            ->getMock();

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
