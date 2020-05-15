<?php

namespace Fixme\Ordering\Entities;

class Staff
{
    public function __construct()
    {
    }

    public function toArray() 
    {
    	return $this->polymorphsToArray();
    }
}