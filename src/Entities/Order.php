<?php

namespace Fixme\Ordering\Entities;

use Fixme\Ordering\Contracts\Entities\Order as OrderContract;
use Fixme\Ordering\Entities\AddressInfo;
use Fixme\Ordering\Entities\Collections\ItemsCollection;
use Fixme\Ordering\Entities\Collections\OrderStatesCollection;
use Fixme\Ordering\Entities\Values\Currency;

class Order implements OrderContract
{
	protected $buyer; 
	protected $seller; 
	protected $items;
	protected $addressInfo;
	protected $currency;
	private $id;
	protected $states;
	protected $createdAt;

	/**
	 * Creates a new Order Class Entity
	 * 
	 * @param Buyer           $buyer
	 * @param Seller          $seller
	 * @param AddressInfo     $addressInfo
	 * @param ItemsCollection $items       
	 * @param Currency|null $currency
	 * @param OrderStatesCollection|null $states
	 * @param int|null $id        
	 */
	public function __construct(
		Buyer $buyer,
		Seller $seller,
		AddressInfo $addressInfo,
		ItemsCollection $items,
		Currency $currency,
		OrderStatesCollection $states = null
	) {
		$this->buyer   	= $buyer;
		$this->seller	= $seller;
		$this->items	= $items;
		$this->addressInfo = $addressInfo;
		$this->currency = $currency;
    	if(isset($states)) {
    		$this->states = $states;
    	} else {
    		$this->states = new OrderStatesCollection(); //initializing a new collection
    	}
    	$this->createdAt = new \DateTime();
    }

    /**
     * return the identifier of the order
     * 
     * @return int|null
     */
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

    /**
     * returns the buyer of the order
     * 
     * @return Buyer
     */
	public function getBuyer(): Buyer 
	{
		return $this->buyer;
	}

	/**
	 * returns the seller of the order
	 * 
	 * @return Seller
	 */
	public function getSeller(): Seller 
	{
		return $this->seller;
	}

	/**
	 * returns a Collection of OrderItems that are related to 
	 * the order
	 * 
	 * @return ItemsCollection
	 */
	public function getItems(): ItemsCollection 
	{
		return $this->items;
	}
	/**
	 * returns the address for order delivery
	 * 
	 * @return AddressInfo
	 */
	public function getAddressInfo(): AddressInfo 
	{
		return $this->addressInfo;
	}

	/**
	 *  returns the currency that is used for the order price
	 * 
	 * @return Currency
	 */
	public function getCurrency(): Currency
	{
		return $this->currency;
	}

	/**
	 * returns a list of orderStates
	 * 
	 * @return OrderStatesCollection
	 */
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

	/**
	 * calls OrderItemsCollection::getTotalItemsPrice() on $items
	 * to return the total price of all items
	 * 
	 * @return float
	 */
	public function getItemsPrice(): float
	{
		return $this->getItems()->getTotalItemsPrice();
	}

	public function setCreationDate(\Datetime $date) 
	{
		$this->createdAt = $date;
	}

	public function getCreatedAt(): \Datetime
	{
		return $this->createdAt;
	}

	public function toArray()
	{
		return [
			'id'          => $this->getId(),
			'buyer'       => $this->buyer->toArray(),
			'seller'      => $this->seller->toArray(),
			'items'       => $this->items->toArray(),
			'addressInfo' => $this->addressInfo->toArray(),
			'states'      => $this->states->toArray(),
			'itemsPrice'  => $this->getItemsPrice(),
			'currency'    => $this->currency->getCode(),
			'createdAt'   => $this->createdAt,
		];
	}

}