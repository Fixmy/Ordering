<?php

namespace Fixme\Ordering\Data\Models;

use Illuminate\Database\Eloquent\Model;

class OrderState extends Model
{
	public function __construct(array $attributes = array())
	{
	    $this->setTable(config('ordering.database_predecessor', '') . 'order_states');
	    parent::__construct($attributes);
	}
}