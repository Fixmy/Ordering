<?php

namespace Fixme\Ordering\Entities\Collections;

use Fixme\Ordering\Contracts\Entities\Collections\ItemsCollection as ItemsCollectionContract;
use \Illuminate\Support\Collection;

class ItemsCollection extends Collection implements ItemsCollectionContract
{
	/**
	 * returns the Sum of all the items prices
	 * by calling getPrice() on each price
	 * 
	 * @return float
	 */
    public function getTotalItemsPrice() : float
    {
    	return array_reduce($this->items, function($v, $item) {
            if($item->getUpdated() == 1){
                return $v + $item->getLineItemPrice();
            }    	    
    	}, 0);
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
