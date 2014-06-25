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
     * @param string $origin
     * @param string $target
     *
     * @throws \InvalidArgumentException If the command failed
     */
    public function sync($origin, $target);
}