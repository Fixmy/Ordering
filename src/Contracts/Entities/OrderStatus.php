<?php 

namespace Fixme\Ordering\Contracts\Entities;

use Fixme\Ordering\Contracts\Client\Polymorphs;
use Fixme\Ordering\Entities\Order;
use Fixme\Ordering\Entities\Values\Status;

interface OrderStatus 
{
	/**
	 * [getStatus description]
	 * 
	 * @return Status [description]
	 */
	public function getStatus(): Status;

	/**
	 * [order description]
	 * 
	 * @return Order [description]
	 */
	public function getOrder(): Order;

	/**
	 *  returns the issuer of the status
	 * 
	 * @return Polymorphs $issuer
	 */
	public function getIssuer(): Polymorphs;
}