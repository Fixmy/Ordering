<?php
namespace Fixme\Ordering\Traits;

use Fixme\Ordering\Entities\Item as OrderItem;

trait ActAsItem 
{
	use Polymorphs;

	private $itemQuantity;
	private $itemUnitPrice;
	private $itemOrderDescription;
	private $itemUpdated;

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
		return $this->itemUnitPrice ?: $this->price;
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
		return $this->itemOrderDescription ?: $this->description;
	}

	public function setItemOrderDescription($description) : void
	{
		$this->itemOrderDescription = $description;
	}

	public function getUpdated() : int
	{
		return $this->itemUpdated;
	}

	public function setUpdated(int $Updated) : void
	{
		$this->itemUpdated = $Updated;
	}

	public function toOrderItem()
	{
		$orderItem = new OrderItem($this->getQuantity(), $this->getUnitPrice(), $this->getItemOrderDescription());
		$orderItem->setIdentifierKey($this->retrieveIdentifierKey());
		$orderItem->setIdentifierValue($this->retrieveIdentifierValue());
		$orderItem->setClassType($this->retrieveClassType());
		return $orderItem;
	}
}