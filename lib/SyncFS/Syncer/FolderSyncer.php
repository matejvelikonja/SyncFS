<?php

namespace SyncFS\Syncer;

use SyncFS\Client\ClientInterface;
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
     * @param mixed $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param MapBag $folders
     */
    public function sync(MapBag $folders)
    {
        foreach ($folders->all() as $folder) {
            $this->client->sync($folder->getSource(), $folder->getDestination());
        }
    }
}