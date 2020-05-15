<?php

namespace Fixme\Ordering\Entities;

use Fixme\Ordering\Contracts\Client\Buyer as ClientBuyerContract;
use Fixme\Ordering\Contracts\Entities\Buyer as BuyerContract;
use Fixme\Ordering\Traits\ActAsBuyer;

class Buyer implements BuyerContract
{
	use ActAsBuyer;

    static function clientCopy(ClientBuyerContract $toCopy) : Buyer
    {
    	$buyer = new Buyer();
    	$buyer->setIdentifierKey($toCopy->retrieveIdentifierKey());
    	$buyer->setIdentifierValue($toCopy->retrieveIdentifierValue());
    	$buyer->setClassType($toCopy->retrieveClassType());
    	return $buyer;
    }

    public function toArray() 
    {
    	return $this->polymorphsToArray();
    }

}