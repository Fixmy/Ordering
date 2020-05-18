<?php

namespace Fixme\Ordering\Entities\Collections;

use Fixme\Ordering\Contracts\Entities\Collections\OrderStatesCollection as Contract;
use Fixme\Ordering\Entities\OrderState;
use \Illuminate\Support\Collection;

class OrderStatesCollection extends Collection implements Contract
{
    public function getActiveState(): OrderState
    {
    	$sorted = $this->sortBy(function($item)
    	{
    	  return $item->getCreatedAt();
    	});

    	return $this->last();
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