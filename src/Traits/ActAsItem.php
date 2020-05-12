<?php
namespace Fixme\Ordering\Traits;

use Fixme\Ordering\Entities\Item as OrderItem;

trait ActAsItem 
{
	use Polymorphs;

	private $itemQuantity;
	private $itemUnitPrice;
	private $itemOrderDescription;

	public function getQuantity() : int
	{
		return $this->itemQuantity;
	}

	public function setQuantity(int $quantity) : void
	{
		$this->itemQuantity = $quantity;
	}

	public function getUnitPrice() : float
	{
		return $this->itemUnitPrice;
	}

	public function setUnitPrice(float $itemUnitPrice) : void
	{
		$this->itemUnitPrice = $itemUnitPrice;
	}

	public function getLineItemPrice() : float
	{
		return $this->itemUnitPrice * $this->itemQuantity;
	}

	public function getItemOrderDescription() : string
	{
		return $this->itemOrderDescription;
	}

	public function setItemOrderDescription($description) : void
	{
		$this->itemOrderDescription = $description;
	}

	public function toOrderItem($quantity, $unitPrice)
	{
		$orderItem = new OrderItem($quantity, $unitPrice, $this->description);
		$orderItem->setIdentifierKey($this->retrieveIdentifierKey());
		$orderItem->setIdentifierValue($this->retrieveIdentifierValue());
		$orderItem->setClassType($this->retrieveClassType());
		return $orderItem;
	}
}