<?php

namespace Fixme\Ordering\Data\Interfaces;

use Fixme\Ordering\Entities\Buyer;
use Fixme\Ordering\Entities\Seller;
use Fixme\Ordering\Entities\Collections\OrdersCollection;
use Fixme\Ordering\Entities\Order;

interface OrderRepository
{
	/**
	 * Saves Persists an Order
	 *
	 * @param Order $order
	 * @return boolean
	 */
	public static function save(Order &$order): bool;

	/**
	 * finds an order by Id
	 *
	 * @param int $orderId
	 * @return Order|null
	 */
	public static function find($orderId): ?Order;

	/**
	 * get orders for a buyer
	 *
	 * @param Buyer $buyer
	 * @return OrdersCollection
	 */
	public static function listForBuyer(Buyer $buyer): OrdersCollection;

	/**
	 * get the orders for a seller
	 * 
	 * @param Seller $seller
	 * @return OrdersCollection
	 */
	public static function listForSeller(Seller $seller): OrdersCollection;
}