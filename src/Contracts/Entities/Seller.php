<?php 

namespace Fixme\Ordering\Contracts\Entities;

use Fixme\Ordering\Contracts\Client\Seller as ClientSeller;
use Fixme\Ordering\Contracts\Support\Arrayable;

interface Seller extends ClientSeller, Arrayable
{
	// public function getSellerId(): string;
	// public function getSellerType(): string;
}