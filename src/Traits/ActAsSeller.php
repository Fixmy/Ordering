<?php
namespace Fixme\Ordering\Traits;

use Fixme\Ordering\Entities\Seller;

trait ActAsSeller
{	
	use Polymorphs;

	public function toSeller()
	{
		$seller = new Seller();
		$seller->setIdentifierKey($this->retrieveIdentifierKey());
		$seller->setIdentifierValue($this->retrieveIdentifierValue());
		$seller->setClassType($this->retrieveClassType());
		return $seller;
	}
}