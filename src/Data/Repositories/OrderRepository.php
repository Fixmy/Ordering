<?php

namespace Fixme\Ordering\Data\Repositories;

use Fixme\Ordering\Data\Interfaces\OrderRepository as OrderRepositoryInterface;
use Fixme\Ordering\Data\Models\Order as OrderModel;
use Fixme\Ordering\Data\Models\OrderAddress;
use Fixme\Ordering\Data\Models\OrderItem;
use Fixme\Ordering\Entities\AddressInfo;
use Fixme\Ordering\Entities\Buyer;
use Fixme\Ordering\Entities\Collections\ItemsCollection;
use Fixme\Ordering\Entities\Collections\OrdersCollection;
use Fixme\Ordering\Entities\Item;
use Fixme\Ordering\Entities\Order;
use Fixme\Ordering\Entities\Seller;

class OrderRepository implements OrderRepositoryInterface
{	
	/**
	 * Persists an order
	 * 
	 * @param  Fixme\Ordering\Entities\Order  $order
	 * @return bool $saveResult
	 */
    public static function save(Order &$order): bool
    {
    	$orderModel = new OrderModel();
		$orderModel->buyer_id    = $order->buyer->retrieveIdentifierValue();
		$orderModel->buyer_type  = $order->buyer->retrieveClassType();
		$orderModel->seller_id   = $order->seller->retrieveIdentifierValue();
		$orderModel->seller_type = $order->seller->retrieveClassType();
		$orderModel->currency = $order->currency;
		$orderModel->save();
		$order->setId($orderModel->id);
		$orderItems = $order->items->map(function($item) use ($orderModel) {
			$orderItem = [
				'order_id'    => $orderModel->id,
				'quantity'    => $item->getQuantity(),
				'unit_price'  => $item->getUnitPrice(),
				'price'       => $item->getLineItemPrice(),
				'description' => $item->getItemOrderDescription(),
				'item_id'     => $item->retrieveIdentifierValue(),
				'item_type'   => $item->retrieveClassType(),
			];
			return $orderItem;
		});
		OrderItem::insert($orderItems->toArray());
		$orderAddress = new OrderAddress([
			'phone_number' => $order->addressInfo->getPhone(),
			'address_line' => $order->addressInfo->getAddressLine(),
		]);
		$orderModel->address()->save($orderAddress);
        return true;
    }

    /**
     * finds an order by Id
     * 
     * @param  int $orderId
     * @return Fixme\Ordering\Entities\Order|null
     */
    public static function find($orderId): ?Order
    {
    	$order = OrderModel::with(
    		'buyer',
    		'seller',
    		'items',
    		'statuses',
    		'address'
    	)->find($orderId);
    	if($order) {
    		$orderEntity = self::orderTransformer($order);
    		return $orderEntity;
    	} else {	
    		return null;
    	}
    }

    /**
     * get orders for a buyer
     *
     * @param Fixme\Ordering\Entities\Buyer $buyer
     * @return Fixme\Ordering\Entities\Collections\OrdersCollection
     */
    public static function listForBuyer(Buyer $buyer): OrdersCollection
    {
    	return (new OrdersCollection());
    }

    private static function orderTransformer(OrderModel $orderModel): Order 
    {
		$itemsCollection = new ItemsCollection(
			$orderModel->items->map(function($item) {
				$itemEntity = new Item($item->quantity, $item->price, $item->description);
				$itemEntity->setIdentifierValue($item->item_id);
				$itemEntity->setClassType($item->item_type);
				return $itemEntity;
			})
		);
		$orderBuyer	= Buyer::clientCopy($orderModel->buyer);
		$orderSeller = Seller::clientCopy($orderModel->seller);
		$addressInfo = new AddressInfo($orderModel->address->phone_number, $orderModel->address->address_line);
		$orderEntity  = new Order($orderBuyer, $orderSeller, $addressInfo, $itemsCollection);
		return $orderEntity;
    }

}