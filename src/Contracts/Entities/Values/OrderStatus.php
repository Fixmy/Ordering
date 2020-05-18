<?php

namespace  Fixme\Ordering\Contracts\Entities\Values;

use Fixme\Ordering\Entities\OrderState;
use Fixme\Ordering\Entities\Values\OrderStatus;

interface OrderStatus 
{
	/**
	 * returns an array of all available statuses
	 * 
	 * @return array
	 */
	public static function getStatuses(): array;

	/**
	 * return status type
	 * 
	 * @return string $type
	 */
	public function getType(): string;

	/**
	 * set the type of the status, must exists in the getStatus
	 *
	 * @param string $type
	 * @return void
	 */
	public function setType(string $type);

	/**
	 * matches a state's status and resolves the relevant order status
	 * 
	 * @param  OrderState $state
	 * @return OrderStatus
	 */
	public static function matchStateStatus(OrderState $state): OrderStatus;
}