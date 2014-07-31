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
     * @param string $buffer
     *
     * @return $this
     */
    public function add($buffer)
    {
        $newLineRegex = "/\r\n|\n|\r/";
        $elements     = preg_split($newLineRegex, $buffer);

        foreach ($elements as $element) {
            if (strlen($element)) {
                parent::add($element);
            }
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
