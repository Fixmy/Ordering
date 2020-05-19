<?php

namespace Fixme\Ordering\Data\Repositories;

/**
 *  Data Models
 */
use Fixme\Ordering\Data\Interfaces\OrderRepository as OrderRepositoryInterface;
use Fixme\Ordering\Data\Models\Order as OrderModel;
use Fixme\Ordering\Data\Models\OrderAddress;
use Fixme\Ordering\Data\Models\OrderItem;
use Fixme\Ordering\Data\Models\OrderState as StateModel;
/**
 * Entities
 */
use Fixme\Ordering\Entities\AddressInfo;
use Fixme\Ordering\Entities\Buyer;
use Fixme\Ordering\Entities\Collections\ItemsCollection;
use Fixme\Ordering\Entities\Collections\OrderStatesCollection;
use Fixme\Ordering\Entities\Collections\OrdersCollection;
use Fixme\Ordering\Entities\Item;
use Fixme\Ordering\Entities\Order;
use Fixme\Ordering\Entities\OrderState as OrderState;
use Fixme\Ordering\Entities\Seller;
use Fixme\Ordering\Entities\Values\Currency;
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
    	if($order->getId()) 
    	{
    		self::addOrderState($order); // this is the only thing that currently requires updates
    		$orderModel = OrderModel::find($order->getId());
    		$orderModel->status = $order->resolveStatus()->getType();
    		return $orderModel->save();
    	}
    	$orderModel = new OrderModel();
		$orderModel->buyer_id    = $order->getBuyer()->retrieveIdentifierValue();
		$orderModel->buyer_type  = $order->getBuyer()->retrieveClassType();
		$orderModel->buyer_key   = $order->getBuyer()->retrieveIdentifierKey();
		$orderModel->seller_id   = $order->getSeller()->retrieveIdentifierValue();
		$orderModel->seller_type = $order->getSeller()->retrieveClassType();
		$orderModel->seller_key  = $order->getSeller()->retrieveIdentifierKey();
		$orderModel->currency    = $order->getCurrency()->getCode();
		$orderModel->created_at  = $order->getCreatedAt();
		$orderModel->status = $order->resolveStatus()->getType();
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
				'item_key'    => $item->retrieveIdentifierKey(),
				'created_at'  => new \DateTime(),
				'updated_at'  => new \DateTime(),
			];
			return $orderItem;
		});

		OrderItem::insert($orderItems->toArray());

		$orderAddress = new OrderAddress([
			'phone_number' => $order->getAddressInfo()->getPhone(),
			'address_line' => $order->getAddressInfo()->getAddressLine(),
		]);
		$orderModel->address()->save($orderAddress);

		$orderStates = $order->getStates()->map(function($state) use ($order) {
			return self::prepareOrderStateModelData($order, $state);
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
    	$orders = OrderModel::with(
    		'buyer',
    		'seller',
    		'items',
    		'states',
    		'address'
    	)->where([
    		'buyer_id' => $buyer->retrieveIdentifierValue(),
    		'buyer_type' => $buyer->retrieveClassType(),
    	])->get();
    	if($orders) {
    		$ordersCollection = new OrdersCollection( 
    			$orders->map(function($orderModel) {
    				return self::orderTransformer($orderModel);
    			})
    		);
    		return $ordersCollection;
    	} else {	
    		return (new OrdersCollection());
    	}
    }

    /**
     * get the orders for a seller
     * 
     * @param Seller $seller
     * @return OrdersCollection
     */
    public static function listForSeller(Seller $seller): OrdersCollection 
    {
    	$orders = OrderModel::with(
    		'buyer',
    		'seller',
    		'items',
    		'states',
    		'address'
    	)->where([
    		'seller_id' => $seller->retrieveIdentifierValue(),
    		'seller_type' => $seller->retrieveClassType(),
    	])->get();
    	if($orders) {
    		$ordersCollection = new OrdersCollection( 
    			$orders->map(function($orderModel) {
    				return self::orderTransformer($orderModel);
    			})
    		);
    		return $ordersCollection;
    	} else {	
    		return (new OrdersCollection());
    	}
    }

    private static function addOrderState(Order &$order): bool
    {
		$orderState = $order->getStates()->getActiveState();
		$stateData = self::prepareOrderStateModelData($order, $orderState);
		StateModel::insert([$stateData]);
		return true;
    }

    private static function prepareOrderStateModelData(Order $order, OrderState $state): array
    {
    	$orderItem = [
    		'order_id'        => $order->getId(),
    		'issuer_type'     => $state->getIssuer()->retrieveClassType(),
    		'issuer_id'       => $state->getIssuer()->retrieveIdentifierValue(),
    		'issuer_key'      => $state->getIssuer()->retrieveIdentifierKey(),
    		'maintainer_type' => $state->getMaintainer() ? $state->getMaintainer()->retrieveClassType() : null,
    		'maintainer_id'   => $state->getMaintainer() ? $state->getMaintainer()->retrieveIdentifierValue() : null,
    		'maintainer_key'  => $state->getMaintainer() ? $state->getMaintainer()->retrieveIdentifierKey() : null,
    		'status'          => $state->getStatus()->getType(),
    		'notes'          => $state->getNotes(),
    		'created_at'      => $state->getCreatedAt(),
    		'updated_at'      => new \DateTime(),
    	];
    	return $orderItem;
    }

    /**
     * Transforms an Order Model to an Entity
     * 
     * @param  OrderModel $orderModel
     * @return Order
     */
    private static function orderTransformer(OrderModel $orderModel): Order 
    {
		$itemsCollection = new ItemsCollection(
			$orderModel->items->map(function($item) {
				$itemEntity = new Item($item->quantity, $item->price, $item->description);
				$itemEntity->setIdentifierValue($item->item_id);
				$itemEntity->setClassType($item->item_type);
				$itemEntity->setIdentifierKey($item->item_key);
				return $itemEntity;
			})
		);

		$orderBuyer	= Buyer::clientCopy($orderModel->buyer);
		$orderSeller = Seller::clientCopy($orderModel->seller);
		$addressInfo = new AddressInfo($orderModel->address->phone_number, $orderModel->address->address_line);
		$currency = new Currency($orderModel->currency);
		$orderStatesCollection = new OrderStatesCollection(
			$orderModel->states->map(function($stateModel) {
				$issuer     = new Polymorph($stateModel->issuer_type, $stateModel->issuer_id, $stateModel->issuer_key);
				if($stateModel->maintainer_type) {
					$maintainer = new Polymorph($stateModel->maintainer_type, $stateModel->maintainer_id, $stateModel->maintainer_key);
				} else {
					$maintainer = null;
				}
				$orderState = new OrderState($stateModel->status, $stateModel->notes, $issuer, $maintainer);
				$orderState->setCreationDate($stateModel->created_at);
				return $orderState;
			})
		);

		$orderEntity  = new Order($orderBuyer, $orderSeller, $addressInfo, $itemsCollection, $currency, $orderStatesCollection);
		$orderEntity->setId($orderModel->id);
		$orderEntity->setCreationDate($orderModel->created_at);
		return $orderEntity;
    }
}