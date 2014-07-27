<?php

namespace SyncFS\Client;

use Symfony\Component\Process\Process;
use SyncFS\Client\Rsync\OutputParser;

/**
 * Class RsyncClient
 *
 * @package SyncFS\Client
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class RsyncClient implements ClientInterface
{
    /**
     * @var array
     */
    private $options;

    /**
     * @var string
     */
    private $executable;

    /**
     * @param array $options Use options from rSync manual page
     *
     * @link http://linux.die.net/man/1/rsync
     */
    public function __construct(array $options = array())
    {
        $defaultOptions = array(
            'rsync' => array(
                'archive'        => true,
                'verbose'        => true,
                'compress'       => true,
                'human-readable' => true,
                'delete'         => false,
                'progress'       => true,
            ),
            'timeout' => 60
        );

        $this->options    = array_replace_recursive($defaultOptions, $options);
        $this->executable = '/usr/bin/rsync';
    }

    /**
     * Sync $origin directory with $target one.
     * If SSH was configured, you must use absolute path
     * in the target directory
     *
     * @param string   $src
     * @param string   $dst
     * @param Callable $callback
     *
     * @throws ClientException
     *
     * @return int|null
     */
    public function sync($src, $dst, $callback = null)
    {
        if (! strlen($dst)) {
            throw new ClientException('Destination parameter missing.');
        }

        if (! strlen($src)) {
            throw new ClientException('Source parameter missing.');
        }

        if ($callback !== null && !is_callable($callback)) {
            throw new ClientException(sprintf('%s is not callable.', $callback));
        }

        $options = $this->getOptionsString();
        $command = implode(' ', array($this->executable, $options, $src, $dst));
        $process = new Process($command);
        $parser  = new OutputParser();
        $process->setTimeout($this->options['timeout']);

        $process->run(function ($type, $buffer) use ($callback, $parser) {
            if (Process::ERR === $type) {
                return;
            }

            $parser->addLine($buffer);

            call_user_func($callback, $parser->getOverallProgress(), $parser->getLastFile());
        });

        if (! $process->isSuccessful()) {
            throw new ClientException($process->getErrorOutput());
        }

        return $process->getExitCode();
    }

    /**
     * @return string
     */
    private function getOptionsString()
    {
        $options   = array_filter($this->options['rsync']); // remove all options with false value
        $arguments = '';

        foreach ($options as $name => $value) {
            $prefix = ' -';
            if (strlen($name) > 1) {
                $prefix = ' --';
            }

            $arguments .= $prefix . $name;
            if ($value && !is_bool($value)) {
                $arguments .= '=' . $value;
            }
        }

        return trim($arguments);
    }
}