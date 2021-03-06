<?php
namespace Fixme\Ordering\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;

trait Polymorphs
{	
	protected $identifierKey;
	protected $identifierValue;
	protected $identifierClass;

	/**
	 * Retrieve the attribute that is used to identify the Buyer, exp: 'id'
	 * @return string
	 */
	public function retrieveIdentifierKey() : string
	{
		if(isset($this->identifierKey)) {
			return $this->identifierKey;
		} else {
			return $this->getKeyName();
		}
	}
	
	/**
	 *  Retrieve the unique identifier value.
	 * @return string
	 */
	public function retrieveIdentifierValue() : string
	{
		if(isset($this->identifierValue)) {
			return $this->identifierValue;
		} else {
			return $this->getKey();
		}
	}

	/**
	 * Retrieve the unique 'type' identifier for the object used to 
	 * establish a polymorphic relation exp: 'App\Model\MyBuyerClass' | 'mybuyerclass'
	 * 
	 * @return string
	 */
	public function retrieveClassType() : string
	{
		if(isset($this->identifierClass)) {
			return $this->identifierClass;
		} else {
			return $this->getMorphClass();
		}
	}

	/**
	 * sets the indentifier key that is used to make this instance uniq
	 * 
	 * @param string $key [description]
	 */
	public function setIdentifierKey(string $key) : void 
	{
		$this->identifierKey = $key;
	}

	/**
	 *  sets the identifier value
	 * 
	 * @param string $key [description]
	 */
	public function setIdentifierValue(string $value) : void 
	{
		$this->identifierValue = $value;
	}

	/**
	 * sets the class type of the instance
	 * 
	 * @param string $key [description]
	 */
	public function setClassType(string $type) : void 
	{
		$this->identifierClass = $type;
	}

	/**
	 * tries to retrieve the original model
	 * 
	 * @return Model|null [description]
	 */
	public function tryGetModel() 
	{
		if(class_exists($this->retrieveClassType())) {
			$modelClass = $this->retrieveClassType();
		} else {
			$modelClass = Relation::getMorphedModel($this->retrieveClassType());
		}
		if($modelClass) 
		{
			$model = $modelClass::where($this->retrieveIdentifierKey(), $this->retrieveIdentifierValue())->first();
			return $model; 
		}

		return null;
	}

	/**
	 * returns the polymorphs methods as an array
	 * 
	 * @return array
	 */
	public function polymorphsToArray()
	{
		return [
			'identifierKey' => $this->retrieveIdentifierKey(),
			'identifierValue' => $this->retrieveIdentifierValue(),
			'identifierClass' => $this->retrieveClassType(),
		];
	}

}