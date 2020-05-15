<?php 

namespace Fixme\Ordering\Contracts\Entities;

use Fixme\Ordering\Contracts\Client\Item as ClientItem;
use Fixme\Ordering\Contracts\Support\Arrayable;

interface Item extends ClientItem, Arrayable
{
	/**
	 * return the price of the order item (quantity * unitPrice)
	 * 
	 * @return float 
	 */
	public function getLineItemPrice(): float;
}