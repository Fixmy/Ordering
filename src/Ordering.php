<?php

namespace Fixme\Ordering;

/*
 * Main Application Models - used for testing while development
 */
use App\Models\Items\Item;
use App\Models\Shops\Shop;
use App\Models\Users\Beneficiary;
use Illuminate\Database\Eloquent\Relations\Relation;
/**
 *  Contracts
 */
use Fixme\Ordering\Contracts\Ordering as OrderingContract;
use Fixme\Ordering\Contracts\Client\Buyer as BuyerContract;
use Fixme\Ordering\Contracts\Client\Seller as SellerContract;
use Fixme\Ordering\Contracts\Client\Item as ItemContract;
use Fixme\Ordering\Contracts\Client\AddressInfo as AddressInfoContract;
/**
 * Entities
 */
use Fixme\Ordering\Entities\Order;
use Fixme\Ordering\Entities\Buyer;
use Fixme\Ordering\Entities\AddressInfo;
use Fixme\Ordering\Entities\OrderState;
use Fixme\Ordering\Entities\Seller;
use Fixme\Ordering\Entities\Collections\ItemsCollection;
use Fixme\Ordering\Entities\Collections\OrdersCollection;
use Fixme\Ordering\Entities\Values\Status;
/**
 * Data
 */
use Fixme\Ordering\Data\Repositories\OrderRepository;

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
		// $beneficiary = Beneficiary::all()->random(); //	device_id: string
		// $shop        = Shop::all()->random(); // 	shop_id: int
		// $items       = Item::all()->random(3)->map(function($item) {
		// 	return $item->toOrderItem($quantity = rand(1, 3), $price = rand(100, 500));
		// });
		// $address     = new AddressInfo('76372024', 'St Marc Des Pins, Street nb 1');
		// $order = $this->request($beneficiary, $shop, $address, ...$items);
		// $result = $this->getBuyerOrder($beneficiary, $order->getId());
		// return $result->toArray();
	}

	//Fixme\Ordering\Contracts\Ordering\Ordering::request(...args) implementation
	public function request(
		BuyerContract $buyer, 
		SellerContract $seller, 
		AddressInfoContract $addressInfo, 
		ItemContract ...$items
	): Order {
		$itemsCollection = new ItemsCollection($items);
		$orderBuyer	= Buyer::clientCopy($buyer);
		$orderSeller = Seller::clientCopy($seller);
		$order	= new Order($orderBuyer, $orderSeller, $addressInfo, $itemsCollection);
		$state = new OrderState(Status::REQUESTED, $buyer, $seller);
		$order->addState($state);
		OrderRepository::save($order);
		return $order;
	}

	public function getBuyerOrder(BuyerContract $buyer, $orderId): ?Order 
	{
		$asker = Buyer::clientCopy($buyer);
		$order = OrderRepository::find($orderId);
		return $order;
	}

	public function getBuyerOrders(BuyerContract $buyer, $args = null): ?OrdersCollection 
	{
		$asker = Buyer::clientCopy($buyer);
		// $orders = OrderRepository::listForBuyer($buyer);
		return $orders;
	}
}


