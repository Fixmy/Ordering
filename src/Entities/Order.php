<?php

namespace Fixme\Ordering\Entities;

use Fixme\Ordering\Contracts\Entities\Order as OrderContract;
use Fixme\Ordering\Entities\AddressInfo;
use Fixme\Ordering\Entities\Collections\ItemsCollection;
use Fixme\Ordering\Entities\Collections\OrderStatesCollection;
use Fixme\Ordering\Entities\Values\Currency;
use Fixme\Ordering\Entities\Values\OrderStatus;
use Fixme\Ordering\Entities\Values\Status;

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
	protected $status;
	protected $deliveryCharge;
	protected $countryCode;

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
		$deliveryCharge = null,
		$countryCode = null,
		OrderStatesCollection $states = null
	) {
		$this->buyer   	= $buyer;
		$this->seller	= $seller;
		$this->items	= $items;
		$this->addressInfo = $addressInfo;
		$this->currency = $currency;
		$this->countryCode = $countryCode;
		$this->deliveryCharge = $deliveryCharge;

    	if(isset($states)) {
    		$this->states = $states;
    	} else {
    		$this->states = new OrderStatesCollection(); //initializing a new collection
    		$state = new OrderState(Status::REQUESTED, null, $this->buyer, $this->seller);
    		$this->addState($state);
    	}
    	$this->createdAt = new \DateTime();
    	$this->resolveStatus();
    }

    /**
     * return the identifier of the order
     * 
     * @return int|null
     */
    public function getId(): ?int
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

	/**
	 * set the creation date proprety on the order! 
	 * should be set as protected!
	 * 
	 * @param \Datetime $date
	 */
	public function setCreationDate(\Datetime $date) 
	{
		$this->createdAt = $date;
	}

	/**
	 * get the creation date of the order
	 * 
	 * @return \Datetime
	 */
	public function getCreatedAt(): \Datetime
	{
		return $this->createdAt;
	}

	/**
	 * @return Status [description]
	 */
	public function resolveStatus(): OrderStatus 
	{
		$currentState = $this->states->getActiveState();
		return OrderStatus::matchStateStatus($currentState);
	}

	/**
	 * @return Status [description]
	 */
	public function resolveBuyerStatus(): OrderStatus 
	{
		$currentState = $this->states->getActiveState();
		return OrderStatus::matchBuyerStatus($currentState);
	}

	/**
	 * @return Status [description]
	 */
	public function resolveSellerStatus(): OrderStatus 
	{
		$currentState = $this->states->getActiveState();
		return OrderStatus::matchSellerStatus($currentState);
	}

	/**
	 * return the deliver charge associated with an order
	 * @return float|null
	 */
	public function getDeliveryCharge(): ?float
	{
		return $this->deliveryCharge;
	}
	
	/**
	 * return the country code associated with an order
	 * @return string|null
	 */
	public function getCountryCode(): ?string
	{
		return $this->countryCode;
	}

	/**
	 * return order note
	 * @return string|null
	 */
	public function getNotes(): ?string
	{
		return $this->notes;
	}

	


	public function toArray()
	{
		return [
			'id'             => $this->getId(),
			'buyer'          => $this->buyer->toArray(),
			'seller'         => $this->seller->toArray(),
			'items'          => $this->items->toArray(),
			'addressInfo'    => $this->addressInfo->toArray(),
			'states'         => $this->states->toArray(),
			'itemsPrice'     => $this->getItemsPrice(),
			'currency'       => $this->currency->getCode(),
			'createdAt'      => $this->createdAt,
			'deliveryCharge' => $this->getDeliveryCharge(),
			'countryCode'    => $this->getCountryCode(),
			'status'         => $this->resolveStatus()->getType(),
			'buyerStatus'    => $this->resolveBuyerStatus()->getType(),
			'traderStatus'   => $this->resolveSellerStatus()->getType(),
			'notes' 		 => $this->getNotes()
		];
	}
}