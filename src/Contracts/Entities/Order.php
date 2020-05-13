<?php 

namespace Fixme\Ordering\Contracts\Entities;

use Fixme\Ordering\Contracts\Entities\Values\Status;
use Fixme\Ordering\Entities\AddressInfo;
use Fixme\Ordering\Entities\Buyer;
use Fixme\Ordering\Entities\Collections\ItemsCollection;
use Fixme\Ordering\Entities\Collections\OrderStatusesCollection;
use Fixme\Ordering\Entities\Seller;

interface Order 
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
	 * [getSeller description]
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
	 * @return string
	 */
	public function getCurrency(): string;

	/**
	 * returns a list of orderStatuses
	 * 
	 * @return Fixme\Ordering\Collections\OrderStatusesCollection
	 */
	public function getStatuses(): OrderStatusesCollection;

	/**
	 * adds a new status for the order
	 * 
	 * @param Status    $status   [description]
	 * @param bool|null $activate [description]
	 * @return OrderStatusesCollection $statuses
	 */
	public function addStatus(Status $status, bool $activate = null): OrderStatusesCollection;

}