<?php

namespace Fixme\Ordering\Contracts\Entities\Collections;

use Fixme\Ordering\Entities\Values\Status;
use \Illuminate\Support\Collection;

interface OrderStatusesCollection extends Collection
{
    public function getActiveStatus(): Status;
}
