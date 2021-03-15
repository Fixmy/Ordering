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
        $total = 0;
        foreach($this->items as $item){
            if($item->getUpdated() != 1){
                $total = $total + $item->getLineItemPrice();
            }            
        }
    	return $total;
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
