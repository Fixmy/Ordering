<?php

namespace Fixme\Ordering\Data\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	public function __construct(array $attributes = array())
	{
	    $this->setTable(config('ordering.database_predecessor', '') . 'orders');
	    parent::__construct($attributes);
	}

	public function buyer() 
	{
		return $this->morphTo();
	}

	public function seller() 
	{
		return $this->morphTo();
	}

	public function items() 
	{
		return $this->hasMany(OrderItem::class);
	}

	public function statuses() 
	{
		return $this->hasMany(OrderStatus::class);
	}

	public function address()
	{
		return $this->hasOne(OrderAddress::class);
	}
}