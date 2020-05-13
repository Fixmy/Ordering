<?php

namespace Fixme\Ordering\Data\Repositories;

use Fixme\Ordering\Data\Interfaces\OrderRepository as OrderRepositoryInterface;
use Fixme\Ordering\Data\Models\Order as OrderModel;
use Fixme\Ordering\Data\Models\OrderAddress;
use Fixme\Ordering\Data\Models\OrderItem;
use Fixme\Ordering\Data\Models\OrderState as StateModel;
use Fixme\Ordering\Entities\AddressInfo;
use Fixme\Ordering\Entities\Buyer;
use Fixme\Ordering\Entities\Collections\ItemsCollection;
use Fixme\Ordering\Entities\Collections\OrderStatesCollection;
use Fixme\Ordering\Entities\Collections\OrdersCollection;
use Fixme\Ordering\Entities\Item;
use Fixme\Ordering\Entities\Order;
use Fixme\Ordering\Entities\OrderState as OrderState;
use Fixme\Ordering\Entities\Seller;
use Fixme\Ordering\Entities\Values\Polymorph;
use Fixme\Ordering\Entities\Values\Status;

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
		$orderModel->buyer_id    = $order->getBuyer()->retrieveIdentifierValue();
		$orderModel->buyer_type  = $order->getBuyer()->retrieveClassType();
		$orderModel->seller_id   = $order->getSeller()->retrieveIdentifierValue();
		$orderModel->seller_type = $order->getSeller()->retrieveClassType();
		$orderModel->currency = $order->getCurrency();
		$orderModel->save();
		///////////////////////////////
		$order->setId($orderModel->id);
		///////////////////////////////
		$orderItems = $order->getItems()->map(function($item) use ($orderModel) {
			$orderItem = [
				'order_id'    => $orderModel->id,
				'quantity'    => $item->getQuantity(),
				'unit_price'  => $item->getUnitPrice(),
				'price'       => $item->getLineItemPrice(),
				'description' => $item->getItemOrderDescription(),
				'item_id'     => $item->retrieveIdentifierValue(),
				'item_type'   => $item->retrieveClassType(),
				'updated_at'   => new \DateTime(),
				'created_at'   => new \DateTime(),
			];
			return $orderItem;
		});

		OrderItem::insert($orderItems->toArray());

		$orderAddress = new OrderAddress([
			'phone_number' => $order->getAddressInfo()->getPhone(),
			'address_line' => $order->getAddressInfo()->getAddressLine(),
		]);
		$orderModel->address()->save($orderAddress);

		$orderStates = $order->getStates()->map(function($state) use ($orderModel) {
			$orderItem = [
				'order_id'    => $orderModel->id,
				'issuer_type' => $state->getIssuer()->retrieveClassType(),
				'issuer_id'   => $state->getIssuer()->retrieveIdentifierValue(),
				'maintainer_type' => $state->getMaintainer()->retrieveClassType(),
				'maintainer_id'   => $state->getMaintainer()->retrieveIdentifierValue(),
				'status'       => $state->getStatus()->getType(),
				'updated_at'   => new \DateTime(),
				'created_at'   => new \DateTime(),
			];
			return $orderItem;
		});

		StateModel::insert($orderStates->toArray());
        
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
    		'states',
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

		$orderStatesCollection = new OrderStatesCollection(
			$orderModel->states->map(function($stateModel) {
				$issuer     = new Polymorph($stateModel->issuer_type, $stateModel->issuer_id);
				$maintainer = new Polymorph($stateModel->maintainer_type, $stateModel->maintainer_id);
				$orderState = new OrderState($stateModel->status, $issuer, $maintainer);
				return $orderState;
			})
		);

		$orderEntity  = new Order($orderBuyer, $orderSeller, $addressInfo, $itemsCollection, $orderStatesCollection);
		$orderEntity->setId($orderModel->id);
		return $orderEntity;
    }

}