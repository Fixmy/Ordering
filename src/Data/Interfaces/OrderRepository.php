<?php

namespace Fixme\Ordering\Data\Interfaces;

use Fixme\Ordering\Entities\Buyer;
use Fixme\Ordering\Entities\Collections\OrdersCollection;
use Fixme\Ordering\Entities\Order;

interface OrderRepository
{
	/**
	 * Undocumented function
	 *
	 * @param Order $order
	 * @return boolean
	 */
	public static function save(Order &$order): bool;

	/**
	 * finds an order by Id
	 *
	 * @param int $orderId
	 * @return Fixme\Ordering\Entities\Order|null
	 */
	public static function find($orderId): ?Order;

	/**
	 * get orders for a buyer
	 *
	 * @param Fixme\Ordering\Entities\Buyer $buyer
	 * @return Fixme\Ordering\Entities\Collections\OrdersCollection
	 */
	public static function listForBuyer(Buyer $buyer): OrdersCollection;
}