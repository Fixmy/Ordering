<?php

namespace Fixme\Ordering\Entities;

use Fixme\Ordering\Contracts\Entities\Order as OrderContract;
use Fixme\Ordering\Contracts\Entities\Values\Status;
use Fixme\Ordering\Entities\AddressInfo;
use Fixme\Ordering\Entities\Collections\ItemsCollection;
use Fixme\Ordering\Entities\Collections\OrderStatusesCollection;

class Order implements OrderContract
{
	protected $buyer; 
	protected $seller; 
	protected $items;
	protected $addressInfo;
	protected $currency = 'USD';
	private $id;
	protected $statuses;

	/**
	 * Creates a new Order Class Entity
	 * 
	 * @param Buyer           $buyer
	 * @param Seller          $seller
	 * @param AddressInfo     $addressInfo
	 * @param ItemsCollection $items       
	 * @param int|null $id        
	 * @param OrderStatusesCollection|null $statuses       
	 */
	public function __construct(
		Buyer $buyer,
		Seller $seller,
		AddressInfo $addressInfo,
		ItemsCollection $items,
		int $id = null,
		OrderStatusesCollection $statuses = null
	) {
    	$this->buyer = $buyer;
    	$this->seller = $seller;
    	$this->items = $items;
    	$this->addressInfo = $addressInfo;
    	$this->id = $id;
    	if(isset($statuses)) {
    		$this->statuses = $statuses;
    	} else {
    		$this->statuses = new OrderStatusesCollection();
    	}
    }

    public function getId(): int
    {
    	return $this->id;
    }

    public function setId(int $id): void
    {
    	$this->id = $id;
    }

	public function getBuyer(): Buyer 
	{
		return $this->buyer;
	}

	public function getSeller(): Seller 
	{
		return $this->seller;
	}

	public function getItems(): ItemsCollection 
	{
		return $this->items;
	}

	public function getAddressInfo(): AddressInfo 
	{
		return $this->addressInfo;
	}

	public function getCurrency(): string
	{
		return $this->currency;
	}

	public function getStatuses(): OrderStatusesCollection
	{
		return $this->statuses;
	}

	public function setStatuses(OrderStatusesCollection $statuses)
	{
		 $this->statuses = $statuses;
	}

	/**
	 * [addStatus description]
	 * 
	 * @param Status    $status   [description]
	 * @param bool|null $activate [description]
	 *
	 * @return bool
	 */
	public function addStatus(Status $status, bool $activate = null): OrderStatusesCollection
	{
		$orderStatus = new OrderStatus($this, $status);
		$orderStatus->setIssuer($this->buyer);
		return $this->statuses->push($orderStatus);
	}


}