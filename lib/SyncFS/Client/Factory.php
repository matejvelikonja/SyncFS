<?php

namespace SyncFS\Client;

/**
 * Class Factory
 *
 * @package SyncFS\Client
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class Factory
{
    /**
     * @param $name
     *
     * @throws \InvalidArgumentException
     *
     * @return ClientInterface
     */
    public function create($name)
    {
        $client = null;

        switch($name) {
            case 'rsync':
                $client = new RsyncClient();
                break;
            case 'mock':
                $client = new MockClient();
                break;
            case 'copy':
                $client = new CopyClient();
                break;
        }

        if (! $client) {
            throw new \InvalidArgumentException(sprintf('Client `%s` does not exists.', $name));
        }

        return $client;
    }
}
