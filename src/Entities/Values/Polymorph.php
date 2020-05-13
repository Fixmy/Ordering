<?php

namespace Fixme\Ordering\Entities\Values;

use Fixme\Ordering\Contracts\Client\Polymorphs as PolymorphsContract;
use Fixme\Ordering\Traits\Polymorphs;

class Polymorph implements PolymorphsContract
{
	use Polymorphs;

	public function __construct($value = null, $class = null, $key = 'id') 
	{
		$this->setIdentifierValue($value);
		$this->setClassType($class);
		$this->setIdentifierKey($key);
	}
}