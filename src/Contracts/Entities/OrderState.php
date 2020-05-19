<?php 

namespace Fixme\Ordering\Contracts\Entities;

use Fixme\Ordering\Contracts\Client\Polymorphs;
use Fixme\Ordering\Contracts\Support\Arrayable;
use Fixme\Ordering\Entities\Order;
use Fixme\Ordering\Entities\Values\Status;

interface OrderState extends Arrayable 
{
	/**
	 * [getStatus description]
	 * 
	 * @return Status [description]
	 */
	public function getStatus(): Status;

	/**
	 *  returns the issuer of the status
	 * 
	 * @return Polymorphs $issuer
	 */
	public function getIssuer(): Polymorphs;

	/**
	 *  returns the maintainer of the status
	 * 
	 * @return Polymorphs $maintainer
	 */
	public function getMaintainer(): ?Polymorphs;

	/**
	 * set the creation date proprety on the Order State! 
	 * should be set as protected!
	 * 
	 * @param \Datetime $date
	 */
	public function setCreationDate(\Datetime $date);

	/**
	 * get the creation date of the order state
	 * 
	 * @return \Datetime
	 */
	public function getCreatedAt(): \Datetime;

	/**
	 * return state notes
	 * 
	 * @return string|null
	 */
	public function getNotes(): ?string; 

	/**
	 * set state notes
	 * 
	 * @param string $notes 
	 */
	public function setNotes(string $notes);
}