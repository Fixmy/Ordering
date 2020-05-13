<?php

namespace Fixme\Ordering\Entities\Collections;

use Fixme\Ordering\Entities\Values\Status;
use \Illuminate\Support\Collection;
use Fixme\Ordering\Contracts\Entities\Collections\OrderStatusesCollection as OrderStatusesCollectionContract

class OrderStatusesCollection extends Collection implements OrderStatusesCollectionContract
{
    public function getActiveStatus(): Status
    {
    	return (new Status());
    }
}