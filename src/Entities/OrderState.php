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

	/**
	 * 
	 * @param string          $status
	 * @param Polymorphs|null $issuer  the entity that is creating this state
	 * @param Polymorphs|null $maintainer 
	 */
    public function __construct(string $status, Polymorphs $issuer = null, Polymorphs $maintainer = null)
    {
    	$this->status = new Status($status);
    	$this->issuer = $issuer;
    	$this->maintainer = $maintainer;
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
}