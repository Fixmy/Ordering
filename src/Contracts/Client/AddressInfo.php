<?php 

namespace Fixme\Ordering\Contracts\Client;

interface AddressInfo
{
	/**
	 * returns the phone number used to make an Address
	 * 
	 * @return string
	 */
	public function getPhone() : string;

	/**
	 * returns a one liner delivery address
	 * 
	 * @return string
	 */
	public function getAddressLine() : string;
}