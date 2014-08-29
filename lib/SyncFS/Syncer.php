<?php

namespace SyncFS;

use Symfony\Component\Console\Output\OutputInterface;
use SyncFS\Client\ClientInterface;
use SyncFS\Map\FileSystemMapFactory;
use SyncFS\Map\MapBag;
use SyncFS\Syncer\FolderSyncer;

/**
 * Class Syncer
 *
 * @package SyncFS
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class Syncer
{
    /**
     * @var MapBag
     */
    private $map;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param array           $config
     * @param ClientInterface $client
     */
    public function __construct(array $config, ClientInterface $client)
    {
        $mapFactory   = new FileSystemMapFactory();
        $this->map    = $mapFactory->create($config);
        $this->client = $client;
    }

    /**
     * @param OutputInterface $output
     */
    public function sync(OutputInterface $output)
    {
        $folderSyncer = new FolderSyncer($this->client);
        $folderSyncer->sync(
            $this->map,
            function (EventInterface $event) use ($output) {
                $output->write($event->getBuffer());
            }
        );

    }
}
