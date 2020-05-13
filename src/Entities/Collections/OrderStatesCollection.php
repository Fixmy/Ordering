<?php

namespace Fixme\Ordering\Entities\Collections;

use Fixme\Ordering\Entities\Values\Status;
use \Illuminate\Support\Collection;
use Fixme\Ordering\Contracts\Entities\Collections\OrderStatesCollection as Contract;

class OrderStatesCollection extends Collection implements Contract
{
    public function getActiveState(): Status
    {
    	return (new Status());
    }
}