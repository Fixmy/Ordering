<?php

namespace  Fixme\Ordering\Entities\Values;

class CountryCode 
{
	protected $code; 
	
	public function __construct(string $code) 
	{
		$this->code = $code;
	}

	/**
	 * return status type
	 * 
	 * @return string $type
	 */
	public function getCode(): string
	{
		return $this->code;
	}

	/**
	 * set the currency code made of three letters abbriviation
	 * 
	 * @param string $code 
	 * @return void
	 */
	public function setCode(string $code)
	{
		$this->code = $code;
	}

	public function toArray() 
	{
		return $this->getCode();
	}


}