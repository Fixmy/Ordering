<?php

namespace Fixme\Ordering\Entities\Collections;

use Fixme\Ordering\Contracts\Entities\Collections\OrdersCollection as OrdersCollectionContract;
use \Illuminate\Support\Collection;

class OrdersCollection extends Collection implements OrdersCollectionContract
{
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
