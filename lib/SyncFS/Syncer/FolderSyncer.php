<?php

namespace SyncFS\Syncer;

use SyncFS\Client\ClientInterface;
use SyncFS\Map\FileSystemMap;
use SyncFS\Map\MapBag;

/**
 * Class FolderSyncer
 *
 * @package SyncFS\Syncer
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class FolderSyncer
{
    /**
     * @var \SyncFS\Client\ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param MapBag   $folders
     * @param Callable $callback
     */
    public function sync(MapBag $folders, $callback = null)
    {
        /** @var FileSystemMap $folder */
        foreach ($folders->all() as $folder) {
            $this->client->sync($folder->getSource(), $folder->getDestination(), $callback);
        }
    }
}
