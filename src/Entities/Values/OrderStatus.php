<?php

namespace Fixme\Ordering\Entities\Values;

use Fixme\Ordering\Contracts\Entities\Values\OrderStatus as OrderStatusContract;
use Fixme\Ordering\Entities\OrderState;

class OrderStatus implements OrderStatusContract
{
	public const OPEN       = 'open'; // an order that is only requested
	public const TERMINATED = 'terminated'; // an order that is closed
	public const INPROGRESS = 'in-progress'; // after seller aproves it
	public const DISPATCHED = 'dispatched'; // after seller aproves it
	public const REQUIRES_CONFIRMATION = 'requires-confirmation'
	public const DISPUTED   = 'disputed'; // buyer not happy
	public const COMPLETED  = 'completed'; // trader aproved edits
	public const DELIVERED  = 'delivered'; // trader marked delivered
	public const CONFIRMED  = 'confirmed'; // buyer confirmed receipt 

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

	public static function matchStateStatus(OrderState $state): OrderStatusContract
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

	public static function matchBuyerStatus(OrderState $state): OrderStatusContract
	{	
		switch($state->getStatus()->getType())
		{
			case Status::REQUESTED:
				return (new static(self::OPEN));
			case Status::ACCEPTED:
				return (new static(self::INPROGRESS));
			case Status::DISPATCHED:
			case Status::DELIVERED:
				return (new static(self::REQUIRES_CONFIRMATION));
			case Status::DISPUTED:
				return (new static(self::DISPUTED));
			case Status::REJECTED:
			case Status::CANCELED:
				return (new static(self::TERMINATED));
			case Status::COMPLETED:
			case Status::CONFIRMED:
				return (new static(self::COMPLETED));
		}
	}

	public static function matchTraderStatus(OrderState $state): OrderStatusContract
	{	
		switch($state->getStatus()->getType())
		{
			case Status::OPEN:
				return (new static(self::OPEN));
			case Status::ACCEPTED:
			case Status::DISPATCHED:
				return (new static(self::INPROGRESS));
			case Status::CONFIRMED:
				return (new static(self::REQUIRES_CONFIRMATION));
			case Status::DISPUTED:
				return (new static(self::DISPUTED));
			case Status::REJECTED:
			case Status::CANCELED:
				return (new static(self::TERMINATED));
			case Status::COMPLETED:
			case Status::DELIVERED:
				return (new static(self::COMPLETED));
		}
	}
}