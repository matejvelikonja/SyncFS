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
     * Adds element to output. New lines are broken down to new elements.
     *
     * @param string $element
     *
     * @return $this
     */
    public function add($element)
    {
        // removes trailing new line
        $element = trim(preg_replace('/\s+$/', ' ', $element));

        $elements = explode(PHP_EOL, $element);

        foreach ($elements as $e) {
            return parent::add($e);
        }

        return $this;
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
