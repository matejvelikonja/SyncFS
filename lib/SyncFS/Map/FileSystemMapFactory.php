<?php

namespace SyncFS\Map;

/**
 * Class FileSystemMapFactory
 *
 * @package SyncFS\Map
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class FileSystemMapFactory
{
    /**
     * @param array $data
     *
     * @return MapBag
     */
    public function create(array $data)
    {
        $mapBag = new MapBag();

        foreach ($data as $name => $mapData) {
            $map = new FileSystemMap();
            $map
                ->setName($name)
                ->setDestination($mapData['dst'])
                ->setSource($mapData['src']);

            $mapBag->add($map);
        }

        return $mapBag;
    }
}