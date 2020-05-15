<?php

namespace Fixme\Ordering\Entities;

use Fixme\Ordering\Contracts\Client\AddressInfo as AddressInfoContract;
use Fixme\Ordering\Contracts\Support\Arrayable;

class AddressInfo implements AddressInfoContract, Arrayable
{
	protected $phone;
	protected $addressLine;

    public function __construct(string $phone, string $addressLine)
    {
    	$this->phone = $phone;
    	$this->addressLine = $addressLine;
    }

    public function getPhone() : string
    {
    	return $this->phone;
    }

    public function getAddressLine() : string
    {
    	return $this->addressLine;
    }

	public function toArray() 
    {
    	return [
    		'phone' => $this->phone,
    		'addressLine' => $this->addressLine,
    	];
    }
}