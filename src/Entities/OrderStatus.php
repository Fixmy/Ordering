<?php

namespace Fixme\Ordering\Entities;

use Fixme\Ordering\Contracts\Client\Polymorphs;
use Fixme\Ordering\Contracts\Entities\OrderStatus as OrderStatusContract;
use Fixme\Ordering\Entities\Values\Status;

class OrderStatus implements OrderStatusContract
{
	protected $status;
	private $order;
	private $issuer;

	/**
	 * instantiate a new Order
	 * 
	 * @param Order  $order 
	 * @param Status $status
	 */
    public function __construct(Order $order, Status $status)
    {
    	$this->order = $order;
    	$this->status = $status;
    }

    /**
     * @return Status [description]
     */
    public function getStatus(): Status
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
    public function getOrder(): Order
    {
    	return $this->order;
    }

    /**
     *  returns the issuer of the status
     * 
     * @return Polymorphs $issuer
     */
    public function getIssuer(): Polymorphs
    {
    	return $this->issuer;
    }

    /**
     * @param Status $status [description]
     */
    public function setIssuer(Polymorphs $issuer)
    {
    	$this->issuer = $issuer;
    }
}