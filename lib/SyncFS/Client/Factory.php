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
     * @param string $name
     * @param array  $options
     *
     * @throws \InvalidArgumentException
     *
     * @return ClientInterface
     */
    public function create($name, array $options = array())
    {
        $client = null;

        switch($name) {
            case 'rsync':
                $client = new RsyncClient($options);
                break;
            case 'mock':
            case 'test':
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
