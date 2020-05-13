<?php

namespace Fixme\Ordering;

/*
 * Main Application Models - used for testing while development
 */
use App\Models\Items\Item;
use App\Models\Shops\Shop;
use App\Models\Users\Beneficiary;
/**
 * Contracts
 */
use Fixme\Ordering\Contracts\Client\AddressInfo as AddressInfoContract;
use Fixme\Ordering\Contracts\Client\Buyer as BuyerContract;
use Fixme\Ordering\Contracts\Client\Item as ItemContract;
use Fixme\Ordering\Contracts\Client\Seller as SellerContract;
use Fixme\Ordering\Contracts\Ordering as OrderingContract;
/**
 * Data
 */
use Fixme\Ordering\Data\Repositories\OrderRepository;
/**
 * Entities
 */
use Fixme\Ordering\Entities\AddressInfo;
use Fixme\Ordering\Entities\Buyer;
use Fixme\Ordering\Entities\Collections\ItemsCollection;
use Fixme\Ordering\Entities\Collections\OrdersCollection;
use Fixme\Ordering\Entities\Order;
use Fixme\Ordering\Entities\Seller;
use Fixme\Ordering\Entities\Entities\OrderStatus;
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
		//testing create
		//
		$status = new Status(Status::REQUESTED);
		// dd($status);
		$beneficiary = Beneficiary::all()->random(); //	device_id: string
		$shop        = Shop::all()->random(); // 	shop_id: int
		$items       = Item::all()->random(3)->map(function($item) {
			return $item->toOrderItem($quantity = rand(1, 3), $price = rand(100, 500));
		});
		$address     = new AddressInfo('76372024', 'St Marc Des Pins, Street nb 1');
		$order = $this->request($beneficiary, $shop, $address, ...$items);
		$result = $this->getBuyerOrder($beneficiary, $order->getId());
		dd($result);
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
		$status = new Status(Status::REQUESTED);
		$order->addStatus($status);
		OrderRepository::save($order);
		return $order;
	}

	public function getBuyerOrder(BuyerContract $buyer, $orderId): ?Order 
	{
		$orderBuyer	= Buyer::clientCopy($buyer);
		$order = OrderRepository::find($orderId);
		return $order;
	}

	public function getBuyerOrders(BuyerContract $buyer, $args = null): ?OrdersCollection 
	{

	}
}


