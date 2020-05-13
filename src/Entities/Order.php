<?php

namespace Fixme\Ordering\Entities;

use Fixme\Ordering\Contracts\Entities\Order as OrderContract;
use Fixme\Ordering\Entities\AddressInfo;
use Fixme\Ordering\Entities\Collections\ItemsCollection;

class Order implements OrderContract
{
	protected $buyer; 
	protected $seller; 
	protected $items;
	protected $addressInfo;
	protected $currency = 'USD';
	private $id;

	/**
	 * Creates a new Order Class Entity
	 * 
	 * @param Buyer           $buyer
	 * @param Seller          $seller
	 * @param AddressInfo     $addressInfo
	 * @param ItemsCollection $items       
	 */
	public function __construct(
		Buyer $buyer,
		Seller $seller,
		AddressInfo $addressInfo,
		ItemsCollection $items,
		int $id = null
	) {
    	$this->buyer = $buyer;
    	$this->seller = $seller;
    	$this->items = $items;
    	$this->addressInfo = $addressInfo;
    	$this->id = $id;
    }

    public function getId(): int
    {
    	return $this->id;
    }

    public function setId(int $id): void
    {
    	$this->id = $id;
    }

	public function getId(): ?int 
	{
		return $this->id;
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

}