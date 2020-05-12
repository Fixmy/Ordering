<?php

namespace Fixme\Ordering\Entities;

use Fixme\Ordering\Contracts\Entities\Order as OrderContract;
use Fixme\Ordering\Entities\AddressInfo;
use Fixme\Ordering\Entities\Collections\ItemsCollection;

class Order implements OrderContract
{
	public $buyer; 
	public $seller; 
	public $items;
	public $addressInfo;
	public $currency = 'USD';

	/**
	 * Creates a new Order Class
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
		ItemsCollection $items
	) {
    	$this->buyer = $buyer;
    	$this->seller = $seller;
    	$this->items = $items;
    	$this->addressInfo = $addressInfo;
    }
}