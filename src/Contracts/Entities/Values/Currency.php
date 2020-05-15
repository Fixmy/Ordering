<?php

namespace  Fixme\Ordering\Contracts\Entities\Values;

interface Currency 
{
	/**
	 * return status type
	 * 
	 * @return string $type
	 */
	public function getCode(): string;

	/**
	 *
	 * @param string $code three letters currency abbriviation
	 * @return void
	 */
	public function setCode(string $code);
}