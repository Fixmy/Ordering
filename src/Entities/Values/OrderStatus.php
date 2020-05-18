<?php

namespace Fixme\Ordering\Entities\Values;

use Fixme\Ordering\Contracts\Entities\Values\OrderStatus as OrderStatusContract;
use Fixme\Ordering\Entities\OrderState;

class OrderStatus implements OrderStatusContract
{
	public const OPEN       = 'open'; // an order that is only requested
	public const CLOSED     = 'closed'; // an order that is closed
	public const INPROGRESS = 'in-progress'; // after seller aproves it
	public const DISPUTED   = 'disputed'; // buyer aproved edits

	protected $type;

	public function __construct(string $type = null)
	{
		if(isset($type))
		{
			$this->setType($type);
		}
	}

	public static function getStatuses(): array
	{
	    $thisClass = new \ReflectionClass(__CLASS__);
	    return $thisClass->getConstants();
	}

	public function setType(string $type)
	{
		if($this->isValidStatus($type)) {
			$this->type = $type;
		} else {
			$exception = new \Exception('Invalid Status Type');
			throw $exception;
		}
	}

	public function getType(): string
	{
		return $this->type;
	}

	private function isValidStatus(string $type)
	{
		return in_array($type, $this->getStatuses());
	}

	public static function matchStateStatus(OrderState $state): OrderStatus
	{	
		switch($state->getStatus()->getType())
		{
			//open
			case Status::REQUESTED:
				return (new static(self::OPEN));
			//inprogress
			case Status::ACCEPTED:
			case Status::EDITED:
			case Status::APPROVED:
			case Status::DISPATCHED:
			case Status::CONFIRMED:
			case Status::ANSWERED:
			case Status::DELIVERED:
				return (new static(self::INPROGRESS));
			//disputed
			case Status::DISPUTED:
			case Status::RESOLVED:
				return (new static(self::DISPUTED));
			//closed
			case Status::REJECTED:
			case Status::DECLINED:
			case Status::CANCELED:
			case Status::TERMINATED:
			case Status::COMPLETED:
			case Status::ABORTED:
				return (new static(self::CLOSED));
		}
	}


}