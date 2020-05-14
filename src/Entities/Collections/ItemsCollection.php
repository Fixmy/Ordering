<?php

namespace Fixme\Ordering\Entities\Collections;

use Fixme\Ordering\Contracts\Entities\Collections\ItemsCollection as ItemsCollectionContract;
use \Illuminate\Support\Collection;

class ItemsCollection extends Collection implements ItemsCollectionContract
{
    public function getTotalBill() : float
    {
    	return 123;
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
