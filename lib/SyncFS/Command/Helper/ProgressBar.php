<?php

namespace SyncFS\Command\Helper;

use Symfony\Component\Console\Helper\ProgressHelper;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar as SFProgressBar;

/**
 * Class ProgressBar
 *
 * Wrapper for ProgressBar or ProgressHelper. Symfony 2.5 or above uses ProgressBar, older versions have ProgressHelper.
 *
 * @package SyncFS\Command\Helper
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class ProgressBar
{
    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    private $output;

    /**
     * @var \Symfony\Component\Console\Helper\ProgressBar | \Symfony\Component\Console\Helper\ProgressHelper
     */
    private $bar;

    /**
     * @param OutputInterface            $output
     * @param ProgressBar|ProgressHelper $bar
     *
     * @throws \RuntimeException
     */
    public function __construct(OutputInterface $output, $bar = null)
    {
        if (! class_exists('\Symfony\Component\Console\Helper\ProgressBar')) {
            throw new \RuntimeException('Not yet implemented for SF Console < 2.5');
        }

        if (! $bar) {
            $bar = $this->getNewInstanceOfBar($output);
        }

        $this->bar    = $bar;
        $this->output = $output;
    }

    /**
     * @return bool
     */
    public function isStarted()
    {
        return (bool) $this->bar->getStartTime();
    }

    /**
     * @return $this
     */
    public function start()
    {
        $this->bar->start();

        return $this;
    }

    /**
     * @return $this
     */
    public function finish()
    {
        $this->bar->finish();

        return $this;
    }

    /**
     * @param int $step
     *
     * @return $this
     */
    public function advance($step = 1)
    {
        $this->bar->advance($step);

        return $this;
    }

    /**
     * @param int $max
     *
     * @return $this
     */
    public function setMax($max)
    {
        $this->bar = $this->getNewInstanceOfBar($this->output, $max);

        return $this;
    }

    /**
     * @param int $step
     *
     * @return $this
     */
    public function setCurrent($step)
    {
        $this->bar->setCurrent($step);

        return $this;
    }

    /**
     * @param OutputInterface $output
     * @param int             $max
     *
     * @return SFProgressBar
     */
    private function getNewInstanceOfBar(OutputInterface $output, $max = 0)
    {
        return new SFProgressBar($output, $max);
    }
}
