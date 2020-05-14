<?php

namespace Fixme\Ordering\Entities;

use Fixme\Ordering\Contracts\Entities\Item as ItemContract;
use Fixme\Ordering\Traits\ActAsItem;
use Illuminate\Contracts\Support\Arrayable;

class Item implements ItemContract, Arrayable
{	
 	use ActAsItem; 

    public function __construct(int $quantity, float $unitPrice, string $description)
    {
    	$this->setQuantity($quantity);
		$this->setUnitPrice($unitPrice);
		$this->setItemOrderDescription($description);
    }

    public function toArray() 
    {
    	$orderItem = [
    		'quantity' => $this->getQuantity(),
    		'unitPrice' => $this->getUnitPrice(),
    		'total' => $this->getLineItemPrice(),
    		'description' => $this->getItemOrderDescription(),
    	];
    	return array_merge($orderItem, $this->polymorphsToArray());
    }

}