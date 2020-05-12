<?php
namespace Fixme\Ordering\Contracts\Client;

interface Polymorphs
{
	/**
	 * Retrieve the attribute that is used to identify the Entity, exp: 'id'
	 * 
	 * @return string
	 */
	public function retrieveIdentifierKey() : string;
	
	/**
	 *  Retrieve the unique identifier value.
	 *  
	 * @return string
	 */
	public function retrieveIdentifierValue() : string;

	/**
	 * Retrieve the unique 'type' identifier for the object used to 
	 * establish a polymorphic relation exp: 'App\Model\MyBuyerClass' | 'mybuyerclass'
	 * 
	 * @return string
	 */
	public function retrieveClassType() : string;

	/**
	 * sets the indentifier key that is used to make this instance uniq
	 * 
	 * @param string $key
	 */
	public function setIdentifierKey(string $key) : void;

	/**
	 *  sets the identifier value
	 * 
	 * @param string $value
	 */
	public function setIdentifierValue(string $value) : void;

	/**
	 * sets the class type of the instance
	 * 
	 * @param string $type 'App\Namespace\SomeClass'
	 */
	public function setClassType(string $type) : void;

}