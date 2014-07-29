<?php

namespace SyncFS\Client;

use SyncFS\Bag;

/**
 * Class Output
 *
 * @package SyncFS\Client
 * @author  Matej Velikonja <matej@velikonja.si>
 */
class Output extends Bag
{
    /**
     * @param string $element
     *
     * @return $this
     */
    public function add($element)
    {
        // removes new lines
        $element = trim(preg_replace('/\s+/', ' ', $element));

        return parent::add($element);
    }

    /**
     * @param array $elements
     *
     * @return $this
     */
    public function setData(array $elements)
    {
        $this->clear();

        foreach ($elements as $element) {
            $this->add($element);
        }

        return $this;
    }
}
