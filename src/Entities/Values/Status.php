<?php

namespace Fixme\Ordering\Entities\Values;

use Fixme\Ordering\Contracts\Entities\Values\Status as StatusContract;

class Status implements StatusContract
{
	public const REQUESTED  = 	'requested'; // buyer requested an order
	public const ACCEPTED   =	'accepted'; // seller accepted an order
	public const EDITED     =	'edited'; // seller suggested edits
	public const APPROVED   =	'approved'; // buyer aproved edits
	public const DISPATCHED =	'dispatched'; // seller dispatches an order
	public const CONFIRMED  = 	'confirmed'; // buyer confirms order
	public const DISPUTED   =	'disputed'; // buyer opens a dispute
	public const RESOLVED   =	'resolved'; // buyer resolves a dispute
	public const ANSWERED   =	'answered'; // seller answers a dispute
	public const DELIVERED  =	'delivered'; // seller marks it as delivered
	public const REJECTED   =	'rejected'; // buyer rejected edits
	public const DECLINED   =	'declined'; // seller declined an order
	public const CANCELED   =	'canceled'; // buyer cancels an order
	public const TERMINATED =	'terminated'; // seller terminates an order (cancels)
	public const COMPLETED  =	'completed'; // seller completes an order and received payment
	public const ABORTED    =	'aborted'; // admin/system intervention

	protected $type;

	public static function getStatuses() {
	    $thisClass = new \ReflectionClass(__CLASS__);
	    return $thisClass->getConstants();
	}

	public function __construct(string $type = null)
	{
		$this->type = $type;
	}

	public function setType(string): string
	{
		return $this->type;
	}

	public function getType(): string
	{
		return $this->type;
	}
}