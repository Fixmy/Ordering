<?php

namespace Fixme\Ordering\Entities;

use Fixme\Ordering\Contracts\Entities\Item as ItemContract;
use Fixme\Ordering\Traits\ActAsItem;

class Item implements ItemContract
{	
 	use ActAsItem; 

 	protected $total;

 	/**
 	 * instantiate a new  Item
 	 * 
 	 * @param int    $quantity
 	 * @param float  $unitPrice
 	 * @param string
 	 */
    public function __construct(int $quantity, float $unitPrice, string $description, int $updated)
    {
    	$this->setQuantity($quantity);
		$this->setUnitPrice($unitPrice);
		$this->setItemOrderDescription($description);
		$this->setUpdated($updated);
    }

    public function toArray() 
    {
    	$orderItem = [
    		'description' => $this->getItemOrderDescription(),
    		'quantity' => $this->getQuantity(),
			'updated' => $this->getUpdated(),
    		'unitPrice' => $this->getUnitPrice(),
    		'price' => $this->getLineItemPrice(),
    	];
    	return array_merge($orderItem, $this->polymorphsToArray());
    }

}