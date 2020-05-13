<?php 

namespace Fixme\Ordering\Contracts\Entities;

use Fixme\Ordering\Contracts\Entities\Order;
use Fixme\Ordering\Entities\Values\Status;

interface OrderStatus 
{
	/**
	 * [getStatus description]
	 * 
	 * @return Status [description]
	 */
	public function status(): Status;

	/**
	 * [order description]
	 * 
	 * @return Order [description]
	 */
	public function order(): Order;
}