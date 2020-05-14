<?php

namespace Fixme\Ordering\Entities;

use Fixme\Ordering\Contracts\Entities\Order as OrderContract;
use Fixme\Ordering\Contracts\Entities\Values\Status;
use Fixme\Ordering\Entities\AddressInfo;
use Fixme\Ordering\Entities\Collections\ItemsCollection;
use Fixme\Ordering\Entities\Collections\OrderStatesCollection;

class Order implements OrderContract
{
	protected $buyer; 
	protected $seller; 
	protected $items;
	protected $addressInfo;
	protected $currency = 'USD';
	private $id;
	protected $states;

	/**
	 * Creates a new Order Class Entity
	 * 
	 * @param Buyer           $buyer
	 * @param Seller          $seller
	 * @param AddressInfo     $addressInfo
	 * @param ItemsCollection $items       
	 * @param OrderStatesCollection|null $states
	 * @param int|null $id        
	 */
	public function __construct(
		Buyer $buyer,
		Seller $seller,
		AddressInfo $addressInfo,
		ItemsCollection $items,
		OrderStatesCollection $states = null
	) {
		$this->buyer   	= $buyer;
		$this->seller	= $seller;
		$this->items	= $items;
		$this->addressInfo = $addressInfo;
    	if(isset($states)) {
    		$this->states = $states;
    	} else {
    		$this->states = new OrderStatesCollection(); //initializing a new collection
    	}
    }

    public function getId(): int
    {
    	return $this->id;
    }

    /**
     * this is the only proprety that get sets from the DataRepository
     * makes the entity dependent on an AutocomrentId, could be resolved
     * by implementing UUID
     * 
     * @param int $id [description]
     */
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

	public function getStates(): OrderStatesCollection
	{
		return $this->states;
	}

	/**
	 * [addState description]
	 * 
	 * @param OrderState $state   [description]
	 * @param bool|null $activate [description]
	 *
	 * @return bool
	 */
	public function addState(OrderState $state, bool $activate = null): OrderStatesCollection
	{
		return $this->states->push($state);
	}

	public function toArray() 
	{
		return [
			'id'     => $this->getId(),
			'buyer'  => $this->buyer->toArray(),
			'seller' => $this->seller->toArray(),
			'items'  => $this->items->toArray(),
			'addressInfo' => $this->addressInfo->toArray(),
			'states' => $this->states->toArray(),
		];
	}

}