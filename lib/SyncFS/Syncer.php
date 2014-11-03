<?php

namespace SyncFS;

use Symfony\Component\Console\Output\OutputInterface;
use SyncFS\Client\Factory;
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
    private $defaultClient;

    /**
     * @param array   $config
     * @param Factory $clientFactory
     */
    public function __construct(array $config, Factory $clientFactory = null)
    {
        if (! $clientFactory) {
            $clientFactory = new Factory();
        }

        $clientConfig = array();

        if (isset($config['timeout'])) {
            $clientConfig ['timeout'] = $config['timeout'];
        }

        $mapFactory          = new FileSystemMapFactory();
        $this->map           = $mapFactory->create($config['maps']);
        $this->defaultClient = $clientFactory->create($config['default_client'], $clientConfig);
    }

    /**
     * @param OutputInterface $output
     */
    public function sync(OutputInterface $output)
    {
        $folderSyncer = new FolderSyncer($this->defaultClient);
        $folderSyncer->sync(
            $this->map,
            function (EventInterface $event) use ($output) {
                $output->write($event->getBuffer());
            }
        );

    }
}
