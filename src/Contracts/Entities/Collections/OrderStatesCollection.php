<?php

namespace Fixme\Ordering\Contracts\Entities\Collections;

use Fixme\Ordering\Entities\Values\Status;

interface OrderStatesCollection
{
    public function getActiveState(): Status;
}
