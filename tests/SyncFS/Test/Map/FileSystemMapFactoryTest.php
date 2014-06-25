<?php

namespace SyncFS\Test\Map;

use SyncFS\Map\FileSystemMap;
use SyncFS\Map\FileSystemMapFactory;
use SyncFS\Test\TestCase;

/**
 * Class FileSystemMapFactoryTest
 *
 * @package SyncFS\Test\Map
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class FileSystemMapFactoryTest extends TestCase
{
    /**
     * @var array
     */
    private $data;

    /**
     * Prepares data array for test.
     */
    public function setUp()
    {
        $this->data = array(
            'folder_name_1' => array(
                'src'  => 'source_1',
                'dst'  => 'destination_1',
            ),
            'folder_name_2' => array(
                'src'  => 'source_2',
                'dst'  => 'destination_2',
            )
        );
    }

    /**
     * Tests if returns map bag.
     */
    public function testIfReturnsMapBag()
    {
        $factory = new FileSystemMapFactory();
        $result  = $factory->create($this->data);

        $this->assertInstanceOf('\SyncFS\Map\MapBag', $result);
    }

    /**
     * Tests if returns all elements.
     */
    public function testIfReturnsAllElements()
    {
        $factory = new FileSystemMapFactory();
        $result  = $factory->create($this->data);

        $this->assertEquals(count($this->data), count($result));
    }

    /**
     * Tests if map bag contains maps.
     */
    public function testIfMapBagContainsMaps()
    {
        $factory = new FileSystemMapFactory();
        $result  = $factory->create($this->data);

        $this->assertContainsOnlyInstancesOf('\SyncFS\Map\FileSystemMap', $result);
    }

    /**
     * Tests if maps contain proper data.
     */
    public function testIfMapsContainProperData()
    {
        $factory = new FileSystemMapFactory();
        $maps    = $factory->create($this->data);
        $count   = 0;

        foreach ($this->data as $name => $mapData) {
            /** @var FileSystemMap $map */
            $map = $maps[$count];

            $this->assertEquals($this->data[$name]['src'], $map->getSource());
            $this->assertEquals($this->data[$name]['dst'], $map->getDestination());
            $this->assertEquals($name, $map->getName());

            $count++;
        }
    }
}
