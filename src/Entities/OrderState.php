<?php

namespace Fixme\Ordering\Entities;

use Fixme\Ordering\Contracts\Client\Polymorphs;
use Fixme\Ordering\Contracts\Entities\OrderState as StateContract;
use Fixme\Ordering\Entities\Values\Status;

class OrderState implements StateContract
{
	protected $status;
	private $issuer;
	private $maintainer;
	protected $createdAt;
	protected $notes;

	/**
	 * 
	 * @param string          $status
	 * @param string|null          $notes
	 * @param Polymorphs|null $issuer the entity that is creating this state
	 * @param Polymorphs|null $maintainer 
	 */
    public function __construct(string $status, string $notes = null, Polymorphs $issuer = null, Polymorphs $maintainer = null)
    {
    	$this->status = new Status($status);
    	$this->notes = $notes;
    	$this->issuer = $issuer;
    	$this->maintainer = $maintainer;
    	$this->createdAt = new \DateTime();
    }

    /**
     * @return Status [description]
     */
    public function getStatus(): Status
    {
    	return $this->status;
    }
    
    /**
     * @param Status $status [description]
     */
    public function setStatus(Status $status)
    {
    	$this->status = $status;
    }

    /**
     *  returns the issuer of the status
     * 
     * @return Polymorphs $issuer
     */
    public function getIssuer(): Polymorphs
    {
    	return $this->issuer;
    }

    /**
     * @param Status $status [description]
     */
    public function setIssuer(Polymorphs $issuer)
    {
    	$this->issuer = $issuer;
    }

    /**
     *  returns the maintainer of the status
     * 
     * @return Polymorphs|null $issuer
     */
    public function getMaintainer(): ?Polymorphs
    {
    	return $this->maintainer;
    }

    /**
     * @param Status $status [description]
     */
    public function setMaintainer(Polymorphs $maintainer)
    {
    	$this->maintainer = $maintainer;
    }

    public function setCreationDate(\Datetime $date) 
    {
    	$this->createdAt = $date;
    }

    public function getCreatedAt(): \Datetime
    {
    	return $this->createdAt;
    }

	public function getNotes(): ?string 
	{
		return $this->notes;
	} 

	public function setNotes(string $notes) 
	{
		$this->notes = $notes;
	}


	public function toArray() 
    {
    	return [
			'maintainer' => $this->maintainer ? $this->maintainer->polymorphsToArray() : null,
			'issuer'     => $this->issuer->polymorphsToArray(),
			'status'     => $this->status->getType(),
			'notes' 	 => $this->notes,
			'createdAt'  => $this->createdAt,
    	];
    }
}