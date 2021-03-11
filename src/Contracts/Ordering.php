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
	 * @param  string $currencyCode a three letter abbriviation of the currency (LBP, USD, etc..)
	 * @param  float $deliveryCharge the delivery charge for the order (can be zero)
	 * @param  string $countryCode a three letter abbriviation of the country (LEB..)
	 * @param  Fixme\Ordering\Contracts\Client\Item[] $items
	 * @return Fixme\Ordering\Entities\Order
	 */
	public function request(
		Buyer $buyer,
		Seller $seller,
		AddressInfo $addressInfo,
		string $currencyCode,
		float $deliveryCharge,
		string $countryCode,
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
	 * (Incomplete Implementation for args)
	 * 
	 * @param  Fixme\Ordering\Contracts\Client\Buyer  $buyer
	 * @param  mixed|null $args
	 * @return Fixme\Ordering\Entities\Collections\OrdersCollection
	 */
	public function getBuyerOrders(Buyer $buyer, $args = null): OrdersCollection;
	
	/**
	 * Returns seller Order
	 * (Missing Implementation - Integrity)
	 * 
	 * @param  Fixme\Ordering\Contracts\Client\Seller $seller
	 * @param  int $orderId
	 * @return Fixme\Ordering\Entities\Order|null
	 */
	public function getSellerOrder(Seller $seller, $orderId): ?Order;
	
	/**
	 * Get a list of all seller's orders
	 * (Incomplete Implementation for args)
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
	 * @param Polymorphs issuer 
	 * @param string|null $snotes
	 * @param Polymorphs|null maintainer 
	 * @return bool
	 */
	public function setOrderState(int $orderId, string $status, $issuer, string $notes = null, $maintainer = null): bool;

	/**
	 * deletes an order
	 * (Incomplete Implementation)
	 * 
	 * @param  int $orderId
	 * @return bool $result of the delete operation
	 */
	public function delete($orderId): bool;

	/**
	 *  Get a list of all system orders
	 *  
	 * @param  DateTime    $from
	 * @param  DateTime    $to
	 * @param  string|null $countryCode
	 * @param  string|null $status
	 * @return Fixme\Ordering\Entities\Collections\OrderCollection
	 */
	public function getOrders(\DateTime $from, \DateTime $to, string $countryCode = null, string $status = null): OrdersCollection;


	/**
	 * updateOrderItems
	 * remove items from order
	 * @param orderId
	 * @param items
	 * @param note
	 * @return Fixme\Ordering\Entities\Order|null
	 */
	public function updateOrderItems($orderId, $items, $note): ?Order;

}