<?php

namespace Fixme\Ordering\Data\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
	protected $fillable = ['phone_number', 'address_line'];

	public function __construct(array $attributes = array())
	{
	    $this->setTable(config('ordering.database_predecessor', '') . 'order_addresses');
	    parent::__construct($attributes);
	}
}