<?php

namespace SyncFS\Command\Helper;

use Symfony\Component\Console\Helper\ProgressHelper;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar as SFProgressBar;

/**
 * Class ProgressBar
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
            $bar = new SFProgressBar($output);
        }

        $this->bar    = $bar;
        $this->output = $output;
    }

    /**
     * @return bool
     */
    public function isStarted()
    {
        return (bool) $this->bar->getStep();
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
} 