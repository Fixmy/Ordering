<?php 

namespace Fixme\Ordering\Contracts\Entities;

use Fixme\Ordering\Contracts\Client\Polymorphs;
use Fixme\Ordering\Contracts\Support\Arrayable;
use Fixme\Ordering\Entities\Order;
use Fixme\Ordering\Entities\Values\Status;

interface OrderState extends Arrayable 
{
	/**
	 * [getStatus description]
	 * 
	 * @return Status [description]
	 */
	public function getStatus(): Status;

	/**
	 *  returns the issuer of the status
	 * 
	 * @return Polymorphs $issuer
	 */
	public function getIssuer(): Polymorphs;

	/**
	 *  returns the maintainer of the status
	 * 
	 * @return Polymorphs $maintainer
	 */
	public function getMaintainer(): ?Polymorphs;
}