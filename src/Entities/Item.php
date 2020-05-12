<?php

namespace Fixme\Ordering\Entities;

use Fixme\Ordering\Contracts\Entities\Item as ItemContract;
use Fixme\Ordering\Traits\ActAsItem;

class Item implements ItemContract
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
    		'unit_price' => $this->getUnitPrice(),
    		'total' => $this->getLineItemPrice(),
    		'description' => $this->getItemOrderDescription(),
    		'class' => $this->retrieveClassType(),
    	];
    	$identifier = $this->retrieveIdentifierKey();
    	$orderItem[$identifier] = $this->retrieveIdentifierValue();
    	return $orderItem;
    }

}