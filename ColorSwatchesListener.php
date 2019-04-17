<?php

namespace Statamic\Addons\ColorSwatches;

use Statamic\Extend\Listener;

class ColorSwatchesListener extends Listener
{
    /**
     * The events to be listened for, and the methods to call.
     *
     * @var array
     */
    public $events = [
        'cp.add_to_head' => 'addToHead',
    ];

    public function addToHead()
    {
        return $this->css->tag('fieldtype.css');
    }
}
