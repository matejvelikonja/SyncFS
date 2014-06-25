<?php

namespace SyncFS\Test\Syncer;

use SyncFS\Client\MockClient;
use SyncFS\Map\FileSystemMap;
use SyncFS\Map\MapBag;
use SyncFS\Syncer\FolderSyncer;
use SyncFS\Test\TestCase;

/**
 * Class FolderSyncerTest
 *
 * @package SyncFS\Test\Syncer
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class FolderSyncerTest extends TestCase
{
    /**
     * Tests if FolderSyncer calls sync method on all given folders
     */
    public function testSyncMethod()
    {
        $client = new MockClient();
        $client->setOrigin('source');
        $client->setTarget('destination');

        $syncer       = new FolderSyncer($client);
        $sourceFolder = new FileSystemMap('name', $client->getOrigin(), $client->getTarget());
        $folders      = new MapBag(array(
            $sourceFolder
        ));

        $syncer->sync($folders);

        $this->assertEquals($client->getOrigin(), $client->getTarget(), 'Origin and target should be the same.');
    }
}
