<?php

namespace Fixme\Ordering;

/*
 * Main Application Models - used for testing while development
 */
use App\Models\Items\Item;
use App\Models\Shops\Shop;
use App\Models\Users\Beneficiary;
use Fixme\Ordering\Contracts\Client\AddressInfo as AddressInfoContract;
use Fixme\Ordering\Contracts\Client\Buyer as BuyerContract;
use Fixme\Ordering\Contracts\Client\Item as ItemContract;
use Fixme\Ordering\Contracts\Client\Seller as SellerContract;
use Fixme\Ordering\Contracts\Ordering as OrderingContract;
use Fixme\Ordering\Data\Repositories\OrderRepository;
use Fixme\Ordering\Entities\AddressInfo;
use Fixme\Ordering\Entities\Buyer;
use Fixme\Ordering\Entities\Collections\ItemsCollection;
use Fixme\Ordering\Entities\Collections\OrdersCollection;
use Fixme\Ordering\Entities\Order;
use Fixme\Ordering\Entities\OrderState;
use Fixme\Ordering\Entities\Seller;
use Fixme\Ordering\Entities\Values\Currency;
use Fixme\Ordering\Entities\Values\Status;

class Ordering implements OrderingContract
{	
	/**
	 * just running some tests
	 * 
	 * @return dumps some data
	 */
	public function test() 
	{	
		print('hello from ordering');
		$buyer  = Beneficiary::all()->random();
		// $seller = Shop::all()->random(); 
		// $items  = Item::all()->random(3)->map(function($item) {
		// 	return $item->toOrderItem($quantity = rand(1, 3), $price = rand(100, 500));
		// });
		// $address = new AddressInfo('76372024', 'St Marc Des Pins, Street nb 1');

		// $order = $this->request($buyer, $seller, $address, 'LBP', ...$items);

		// return $order;
		// $orderId = $order->getId();		
		// $getBuyerOrder = $this->getBuyerOrder($buyer, $orderId);
		$getBuyerOrders = $this->getBuyerOrders($buyer);
		// $getSellerOrder = $this->getSellerOrder($seller, $orderId);
		// $getSellerOrders = $this->getSellerOrders($seller);
		
		dd(
			// $getBuyerOrder->toArray()
			$getBuyerOrders->toArray()
			// $getSellerOrder->toArray(),
			// $getSellerOrders->toArray()
		);
	
	}

	/**
	 * Requests a new Order
	 * 
	 * @param  Fixme\Ordering\Contracts\Client\Buyer  $buyer
	 * @param  Fixme\Ordering\Contracts\Client\Seller $seller
	 * @param  Fixme\Ordering\Contracts\Client\AddressInfo $addressInfo
	 * @param  string $currencyCode a three letter abbriviation of the currency (LBP, USD, etc)
	 * @param  Fixme\Ordering\Contracts\Client\Item[] $items
	 * @return Fixme\Ordering\Entities\Order
	 */
	public function request(
		BuyerContract $buyer, 
		SellerContract $seller, 
		AddressInfoContract $addressInfo, 
		string $currency,
		ItemContract ...$items
	): Order {
		$itemsCollection = new ItemsCollection($items);
		$orderBuyer	= Buyer::clientCopy($buyer);
		$orderSeller = Seller::clientCopy($seller);
		$orderCurrency = new Currency($currency);
		$order	= new Order($orderBuyer, $orderSeller, $addressInfo, $itemsCollection, $orderCurrency);
		OrderRepository::save($order);
		return $order;
	}

	/**
	 * Returns buyer Order
	 * 
	 * @param  Fixme\Ordering\Contracts\Client\Buyer  $buyer
	 * @param  int $orderId
	 * @return Fixme\Ordering\Entities\Order|null
	 */	
	public function getBuyerOrder(BuyerContract $buyer, $orderId): ?Order 
	{
		$asker = Buyer::clientCopy($buyer);
		$order = OrderRepository::find($orderId);
		return $order;
	}

	/**
	 * Get a list of all buyer's orders
	* (Incomplete Implementation)
	 * 
	 * @param  Fixme\Ordering\Contracts\Client\Buyer  $buyer
	 * @param  mixed|null $args
	 * @return Fixme\Ordering\Entities\Collections\OrdersCollection
	 */
	public function getBuyerOrders(BuyerContract $buyer, $args = null): OrdersCollection 
	{
		$asker = Buyer::clientCopy($buyer);
		$orders = OrderRepository::listForBuyer($asker);
		return $orders;
	}

	/**
	 * Returns seller Order
	 * (Incomplete Implementation)
	 * 
	 * @param  Fixme\Ordering\Contracts\Client\Seller $seller
	 * @param  int $orderId
	 * @return Fixme\Ordering\Entities\Order|null
	 */
	public function getSellerOrder(SellerContract $seller, $orderId): ?Order
	{
		$asker = Seller::clientCopy($seller);
		$order = OrderRepository::find($orderId);
		return $order;
	}

	/**
	 * Get a list of all seller's orders
	 * (Incomplete Implementation)
	 * 
	 * @param  Fixme\Ordering\Contracts\Client\Seller $seller
	 * @param  mixed|null $args 
	 * @return Fixme\Ordering\Entities\Collections\OrderCollection
	 */
	public function getSellerOrders(SellerContract $seller, $args = null): OrdersCollection
	{
		$asker = Seller::clientCopy($seller);
		$orders = OrderRepository::listForSeller($asker);
		return $orders;
	}

	/**
	 * sets a new state object on the order, and updating the order status accordingly
	 * (Incomplete Implementation)
	 * 
	 * @param int $orderId
	 * @param string $status  must exists in Fixme\Ordering\Entities\Values\Status::getStatuses()
	 * @return bool 
	 */
	public function setOrderState($orderId, string $status, $issuer, $maintainer = null): bool
	{
		$order = OrderRepository::find($orderId);
		$state = new OrderState($status, $issuer, $maintainer);
		$order->addState($state);
		return OrderRepository::save($order);
	}

	/**
	 * deletes an order
	 * (Incomplete Implementation)
	 * 
	 * @param  int $orderId
	 * @return bool $result of the delete operation
	 */
	public function delete($orderId): bool
	{

	}

}


