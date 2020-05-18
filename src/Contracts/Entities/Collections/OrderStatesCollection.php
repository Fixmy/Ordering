<?php

namespace Fixme\Ordering\Contracts\Entities\Collections;

use Fixme\Ordering\Entities\OrderState;

interface OrderStatesCollection
{
    public function getActiveState(): OrderState;
}
