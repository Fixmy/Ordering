<?php 

namespace Fixme\Ordering\Contracts\Client;

interface Item extends Polymorphs
{
	/**
	 * gets the quantity of the item
	 * 
	 * @return number
	 */
	public function getQuantity() : int;

	/**
	 * set the unit item quantity
	 * 
	 * @param int $quantity
	 * @return void
	 */
	public function setQuantity(int $quantity) : void;
	
	/**
	 * Gets the price of a single item
	 * 
	 * @return number
	 */
	public function getUnitPrice() : float;

	/**
	 * set the unit item price
	 * 
	 * @param float $itemUnitPrice
	 * @return void
	 */
	public function setUnitPrice(float $itemUnitPrice) : void;

	/**
	 * retrieve the description that is present on the order for the item
	 * 
	 * @return string [description]
	 */
	public function getItemOrderDescription() : string;

	/**
	 * set the description that will be present on the order for the item
	 * 
	 * @param string $description
	 * @return void
	 */
	public function setItemOrderDescription(string $description) : void;
}