<?php

namespace SyncFS\Client;

/**
 * Interface ClientInterface
 *
 * @package SyncFS\Client
 * @author  Matej Velikonja <matej@velikonja.si>
 */
interface ClientInterface
{
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
    public function sync($src, $dst, $callback = null);
}