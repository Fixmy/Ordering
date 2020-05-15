<?php 

namespace Fixme\Ordering\Contracts\Entities\Collections;

interface ItemsCollection
{
	/**
	 * returns the Sum of all the items prices
	 * 
	 * @return float
	 */
	public function getTotalItemsPrice(): float;
}