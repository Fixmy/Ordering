<?php

namespace Fixme\Ordering\Contracts\Entities\Collections;

use Fixme\Ordering\Entities\Values\Status;

interface OrderStatusesCollection
{
    public function getActiveStatus(): Status;
}
