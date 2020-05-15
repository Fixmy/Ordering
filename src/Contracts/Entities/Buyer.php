<?php 

namespace Fixme\Ordering\Contracts\Entities;

use Fixme\Ordering\Contracts\Client\Buyer as ClientBuyer;
use Fixme\Ordering\Contracts\Support\Arrayable;

interface Buyer extends ClientBuyer, Arrayable
{
	// public function getBuyerId(): string;
	// public function getBuyerType(): string;
}