<?php

namespace Fixme\Ordering\Entities\Values;

use Fixme\Ordering\Contracts\Entities\Values\OrderStatus as OrderStatusContract;
use Fixme\Ordering\Entities\OrderState;

class OrderStatus implements OrderStatusContract
{
	public const REQUESTED  = 'requested'; // an order that is only requested
	public const FAILED     = 'failed'; // an order that is only requested
	public const INPROGRESS = 'in-progress'; // after seller aproves it
	public const DISPUTED   = 'disputed'; // buyer not happy
	public const COMPLETED  = 'completed'; // 
	public const UNRESOLVED = 'unresolved'; // 

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
			$thisClass = new \ReflectionClass(__CLASS__);
			$types = $thisClass->getConstants();
			$exception = new \Exception("Invalid Status Type, $type does not exist in: [" .implode(', ', $types). "]");
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
			case Status::REQUESTED:
				return (new static(self::REQUESTED));
				break;
			//inprogress
			case Status::ACCEPTED:
			case Status::EDITED:
			case Status::APPROVED:
			case Status::DISPATCHED:
			case Status::CONFIRMED:
			case Status::ANSWERED:
			case Status::DELIVERED:
				return (new static(self::INPROGRESS));
				break;
			//disputed
			case Status::DISPUTED:
			case Status::RESOLVED:
				return (new static(self::DISPUTED));
				break;
			//closed
			case Status::REJECTED:
			case Status::DECLINED:
			case Status::CANCELED:
			case Status::TERMINATED:
			case Status::ABORTED:
				return (new static(self::FAILED));
				break;
			case Status::COMPLETED:
			case Status::COMPLETED:
				return (new static(self::COMPLETED));
				break;
			default: 
				return (new static(self::UNRESOLVED));
		}
	}

	public static function matchBuyerStatus(OrderState $state): OrderStatusContract
	{	
		switch($state->getStatus()->getType())
		{
			case Status::REQUESTED:
				return (new static(self::REQUESTED));
				break;
			case Status::ACCEPTED:
			case Status::DISPATCHED:
				return (new static(self::INPROGRESS));
				break;
			case Status::DISPUTED:
				return (new static(self::DISPUTED));
				break;
			case Status::REJECTED:
			case Status::DECLINED:
			case Status::CANCELED:
				return (new static(self::FAILED));
				break;
			case Status::DELIVERED:
			case Status::COMPLETED:
			case Status::CONFIRMED:
				return (new static(self::COMPLETED));
				break;
			default: 
				return (new static(self::UNRESOLVED));
		}
	}

	public static function matchSellerStatus(OrderState $state): OrderStatusContract
	{	
		switch($state->getStatus()->getType())
		{
			case Status::REQUESTED:
				return (new static(self::REQUESTED));
				break;
			case Status::ACCEPTED:
			case Status::DISPATCHED:
			case Status::CONFIRMED:
				return (new static(self::INPROGRESS));
				break;
			case Status::DISPUTED:
				return (new static(self::DISPUTED));
				break;
			case Status::REJECTED:
			case Status::CANCELED:
			case Status::DECLINED:
				return (new static(self::FAILED));
				break;
			case Status::COMPLETED:
			case Status::DELIVERED:
				return (new static(self::COMPLETED));
				break;
			default: 
				return (new static(self::UNRESOLVED));
		}
	}
}