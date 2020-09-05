<?php

namespace Octorate\Events;

/**
 * Class BaseEvent
 * @package Octorate\Events
 */
abstract class BaseEvent
{
    /**
     * @var array
     */
    public $data;

    /**
     * BaseEvent constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
