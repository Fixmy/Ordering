<?php 

namespace Fixme\Ordering\Contracts\Entities;

use Fixme\Ordering\Contracts\Support\Arrayable;
use Fixme\Ordering\Entities\AddressInfo;
use Fixme\Ordering\Entities\Buyer;
use Fixme\Ordering\Entities\Collections\ItemsCollection;
use Fixme\Ordering\Entities\Collections\OrderStatesCollection;
use Fixme\Ordering\Entities\OrderState;
use Fixme\Ordering\Entities\Seller;
use Fixme\Ordering\Entities\Values\Currency;

interface Order extends Arrayable
{
	/**
	 * return the identifier of the order
	 * 
	 * @return int|null
	 */
	public function getId(): ?int;

	/**
	 * returns the buyer of the order
	 * 
	 * @return Fixme\Ordering\Entities\Buyer
	 */
	public function getBuyer(): Buyer;

	/**
	 * returns the seller of the order
	 * 
	 * @return Fixme\Ordering\Entities\Seller [description]
	 */
	public function getSeller(): Seller;

	/**
	 * returns a Collection of OrderItems that are related to 
	 * the order
	 * 
	 * @return Fixme\Ordering\Collections\ItemsCollection
	 */
	public function getItems(): ItemsCollection;

	/**
	 * returns the address for order delivery
	 * 
	 * @return Fixme\Ordering\Values\AddressInfo
	 */
	public function getAddressInfo(): AddressInfo;

	/**
	 *  returns the currency that is used for the order price
	 * 
	 * @return Currency $currency
	 */
	public function getCurrency(): Currency;

	/**
	 * returns a list of orderStates
	 * 
	 * @return Fixme\Ordering\Collections\OrderStatesCollection
	 */
	public function getStates(): OrderStatesCollection;

	/**
	 * adds a new status for the order
	 * 
	 * @param OrderState    $state   [description]
	 * @param bool|null $activate [description]
	 * @return OrderStatesCollection $states
	 */
	public function addState(OrderState $state, bool $activate = null): OrderStatesCollection;

	/**
	 * to return the total price of all items
	 * 
	 * @return float
	 */
	public function getItemsPrice(): float;

	/**
	 * set the creation date proprety on the order! 
	 * should be set as protected!
	 * 
	 * @param \Datetime $date
	 */
	public function setCreationDate(\Datetime $date);

	/**
	 * get the creation date of the order
	 * 
	 * @return \Datetime
	 */
	public function getCreatedAt(): \Datetime;
}