<?php

namespace Fixme\Ordering\Data\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
	public function __construct(array $attributes = array())
	{
	    $this->setTable(config('ordering.database_predecessor', '') . 'order_status');
	    parent::__construct($attributes);
	}
}