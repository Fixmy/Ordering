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
use Fixme\Ordering\Entities\Seller;

class Ordering implements OrderingContract
{	
	/**
	 * just running some tests
	 * 
	 * @return dumps some data
	 */
	public function test() 
	{	
		//testing create
		$beneficiary = Beneficiary::all()->random(); //	device_id: string
		// $shop        = Shop::all()->random(); // 	shop_id: int
		// $items       = Item::all()->random(3)->map(function($item) {
		// 	return $item->toOrderItem($quantity = rand(1, 3), $price = rand(100, 500));
		// });
		// $address     = new AddressInfo('76372024', 'St Marc Des Pins, Street nb 1');
		// $result = $this->request($beneficiary, $shop, $address, ...$items);
		//testing read;
		$result = $this->getBuyerOrder($beneficiary, 7);
		dd($result);
	}

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
		OrderRepository::save($order);
		return $order;
	}

	public function getBuyerOrder(BuyerContract $buyer, $orderId): ?Order 
	{
		$orderBuyer	= Buyer::clientCopy($buyer);
		$order = OrderRepository::find($orderId);
		return $order;
	}

	public function getBuyerOrders(BuyerContract $buyer, $args = null) : ?OrdersCollection 
	{

	}
}


