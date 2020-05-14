<?php

namespace Fixme\Ordering\Entities\Collections;

use Fixme\Ordering\Entities\Values\Status;
use \Illuminate\Support\Collection;
use Fixme\Ordering\Contracts\Entities\Collections\OrderStatesCollection as Contract;

class OrderStatesCollection extends Collection implements Contract
{
    public function getActiveState(): Status
    {
    	return (new Status());
    }

    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function ($value) {
            return method_exists($value, 'toArray') ? $value->toArray() : $value;
        }, $this->items);
    }
}