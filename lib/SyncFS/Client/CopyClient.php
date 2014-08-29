<?php

namespace SyncFS\Client;
use Symfony\Component\Filesystem\Filesystem;
use SyncFS\Event;

/**
 * Class CopyClient
 *
 * @package SyncFS\Client
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class CopyClient implements ClientInterface
{
    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $fs;

    public function __construct()
    {
        $this->fs = new Filesystem();
    }

    /**
     * Sync $origin directory with $target one.
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
        $cleanupEvent  = new Event(sprintf('Cleaning up destination (`%s`).', $dst));
        $copyEvent     = new Event(sprintf('Copying source `%s` to destination `%s`.', $src, $dst));
        $finishedEvent = new Event(sprintf('Finished copying.'));

        call_user_func($callback, $cleanupEvent);
        $this->fs->remove($dst);

        call_user_func($callback, $copyEvent);
        $this->fs->mirror($src, $dst);
        call_user_func($callback, $finishedEvent);
    }
}
