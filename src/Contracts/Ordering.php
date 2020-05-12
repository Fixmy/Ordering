<?php 

namespace Fixme\Ordering\Contracts;

use Fixme\Ordering\Contracts\Client\AddressInfo;
use Fixme\Ordering\Contracts\Client\Buyer;
use Fixme\Ordering\Contracts\Client\Item;
use Fixme\Ordering\Contracts\Client\Seller;
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
	 * Returns an Order
	 * 
	 * @param  Fixme\Ordering\Contracts\Client\Buyer  $buyer
	 * @param  int $orderId
	 * @return Fixme\Ordering\Entities\Order|null
	 */	
	public function getBuyerOrder(Buyer $buyer, $orderId): ?Order;

	/**
	 * [getBuyerOrders description]
	 * @param  Fixme\Ordering\Contracts\Client\Buyer  $buyer
	 * @param  mixed $args
	 * @return Fixme\Ordering\Entities\Collections\OrdersCollection
	 */
	public function getBuyerOrders(Buyer $buyer, $args = null): ?OrdersCollection;

	// public function retrieveForBuyer(, $orderId);
	// public function list($any, $status = 'any', $from = null, $to = null);


	// public function confirm($client, $orderId);
	// public function dispute($client, $orderId, $meta = null);
	// public function cancel($any, $orderId);
	// public function accept($merchant, $orderId);
	// public function decline($merchant, $orderId);
	// public function dispatch($merchant, $orderId, $traderId = null);
	// public function close($merchant, $orderId, $traderId = null);
	// public function retrieve($any, $orderId);
	// public function retrieveAndExpend($any, $orderId);
	// public function delete($admin, $orderId);
	// public function list($any, $status = 'any', $from = null, $to = null);
}