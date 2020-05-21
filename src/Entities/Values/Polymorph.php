<?php

namespace Fixme\Ordering\Entities\Values;

use Fixme\Ordering\Contracts\Client\Polymorphs as PolymorphsContract;
use Fixme\Ordering\Traits\Polymorphs;

class Polymorph implements PolymorphsContract
{
	use Polymorphs;

	public function __construct($type = null, $id = null, $key = 'id') 
	{
		$this->setIdentifierValue($id);
		$this->setClassType($type);
		$this->setIdentifierKey($key);
	}
}