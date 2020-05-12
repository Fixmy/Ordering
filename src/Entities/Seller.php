<?php

namespace Fixme\Ordering\Entities;

use Fixme\Ordering\Contracts\Entities\Seller as SellerContract;
use Fixme\Ordering\Contracts\Client\Seller as ClientSellerContract;
use Fixme\Ordering\Traits\ActAsSeller;

class Seller implements SellerContract
{
	use ActAsSeller;
	
    public function __construct()
    {
    }

    static function clientCopy(ClientSellerContract $toCopy) : Seller
    {
    	$seller = new Seller();
    	$seller->setIdentifierKey($toCopy->retrieveIdentifierKey());
    	$seller->setIdentifierValue($toCopy->retrieveIdentifierValue());
    	$seller->setClassType($toCopy->retrieveClassType());
    	return $seller;
    }
}