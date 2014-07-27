<?php

namespace SyncFS\Client;

/**
 * Class SyncClientMock
 *
 * @package SyncFS\Client
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class MockClient implements ClientInterface
{
    /**
     * @var string
     */
    private $origin;

    /**
     * @var string
     */
    private $target;

    /**
     * Sync $origin directory with $target one.
     * If SSH was configured, you must use absolute path
     * in the target directory
     *
     * @param string   $src
     * @param string   $dst
     * @param Callable $callback
     *
     * @throws ClientException
     *
     * @return int|null
     */
    public function sync($src, $dst, $callback = null)
    {
        $this->target = $src;
    }

    /**
     * @param string $origin
     *
     * @return $this
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param string $target
     *
     * @return $this
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

}