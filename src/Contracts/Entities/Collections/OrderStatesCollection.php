<?php

namespace Fixme\Ordering\Contracts\Entities\Collections;

use Fixme\Ordering\Entities\OrderState;

interface OrderStatesCollection
{
	/**
	 * returns the last active state of an order
	 * 
	 * @return OrderState
	 */
    public function getActiveState(): OrderState;
}
