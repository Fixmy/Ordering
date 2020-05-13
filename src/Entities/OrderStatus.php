<?php

namespace Fixme\Ordering\Entities;

use Fixme\Ordering\Contracts\Entities\OrderStatus as OrderStatusContract;
use Fixme\Ordering\Entities\Values\Status;

class OrderStatus implements OrderStatusContract
{
	protected $status;
	private $order;

    public function __construct(Order $order, Status $status)
    {
    	$this->order = $order;
    	$this->status = $status;
    }

    /**
     * @return Status [description]
     */
    public function status(): Status
    {
    	return $this->status;
    }
    
    /**
     * @param Status $status [description]
     */
    public function setStatus(Status $status)
    {
    	$this->status = $status;
    }

    /**
     * @return Order [description]
     */
    public function order(): Order
    {
    	return $this->order;
    }
}