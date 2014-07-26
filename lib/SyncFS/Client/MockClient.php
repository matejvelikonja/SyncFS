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
     * @inheritdoc
     */
    public function sync($origin, $target, $callback = null)
    {
        $this->target = $origin;
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