<?php

namespace Fixme\Ordering\Entities\Collections;

use Fixme\Ordering\Contracts\Entities\Collections\ItemsCollection as ItemsCollectionContract;
use \Illuminate\Support\Collection;

class ItemsCollection extends Collection implements ItemsCollectionContract
{
    public function getTotalBill() : float
    {
    	return 123;
    }
}
