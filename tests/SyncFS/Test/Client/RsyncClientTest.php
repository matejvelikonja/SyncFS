<?php

namespace SyncFS\Test\Client;

use SyncFS\Client\RsyncClient;

/**
 * Class RsyncClientTest
 *
 * @package SyncFS\Test\Client
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class RsyncClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \SyncFS\Client\ClientException
     */
    public function testIfExceptionIsThrownWhenCallbackArgumentIsNotCallable()
    {
        $client = new RsyncClient();

        $client->sync('source', 'destination', 'certainly non callable');
    }
}
 