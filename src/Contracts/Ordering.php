<?php 

namespace Fixme\Ordering\Contracts;

use Fixme\Ordering\Contracts\Client\AddressInfo;
use Fixme\Ordering\Contracts\Client\Buyer;
use Fixme\Ordering\Contracts\Client\Item;
use Fixme\Ordering\Contracts\Client\Seller;

use Fixme\Ordering\Entities\OrderState;
use Fixme\Ordering\Entities\Collections\OrdersCollection;
use Fixme\Ordering\Entities\Order;

interface Ordering
{
	/**
	 * Requests a new Order
	 * 
	 * @param  Fixme\Ordering\Contracts\Client\Buyer  $buyer
	 * @param  Fixme\Ordering\Contracts\Client\Seller $seller
	 * @param  Fixme\Ordering\Contracts\Client\AddressInfo $addressInfo
	 * @param  Fixme\Ordering\Contracts\Client\Item[] $items
	 * @return Fixme\Ordering\Entities\Order
	 */
	public function request(
		Buyer $buyer,
		Seller $seller,
		AddressInfo $addressInfo,
	 	Item ...$items
	): Order;

	/**
	 * Returns buyer Order
	 * 
	 * @param  Fixme\Ordering\Contracts\Client\Buyer  $buyer
	 * @param  int $orderId
	 * @return Fixme\Ordering\Entities\Order|null
	 */	
	public function getBuyerOrder(Buyer $buyer, $orderId): ?Order;

	/**
	 * Get a list of all buyer's orders
	* (Incomplete Implementation)
	 * 
	 * @param  Fixme\Ordering\Contracts\Client\Buyer  $buyer
	 * @param  mixed|null $args
	 * @return Fixme\Ordering\Entities\Collections\OrdersCollection
	 */
	public function getBuyerOrders(Buyer $buyer, $args = null): OrdersCollection;
	
	/**
	 * Returns seller Order
	 * (Incomplete Implementation)
	 * 
	 * @param  Fixme\Ordering\Contracts\Client\Seller $seller
	 * @param  int $orderId
	 * @return Fixme\Ordering\Entities\Order|null
	 */
	public function getSellerOrder(Seller $seller, $orderId): ?Order;
	
	/**
	 * Get a list of all seller's orders
	 * (Incomplete Implementation)
	 * 
	 * @param  Fixme\Ordering\Contracts\Client\Seller $seller
	 * @param  mixed|null $args 
	 * @return Fixme\Ordering\Entities\Collections\OrderCollection
	 */
	public function getSellerOrders(Seller $seller, $args = null): OrdersCollection;
	
	/**
	 * sets a new state object on the order, and updating the order status accordingly
	 * (Incomplete Implementation)
	 * 
	 * @param int $orderId
	 * @param string $status  must exists in Fixme\Ordering\Entities\Values\Status::getStatuses()
	 * @return Fixme\Ordering\Contracts\Entities\OrderState|null 
	 */
	public function setOrderState($orderId, string $status): ?OrderState;

	/**
	 * deletes an order
	 * (Incomplete Implementation)
	 * 
	 * @param  int $orderId
	 * @return bool $result of the delete operation
	 */
	public function delete($orderId): bool;
}