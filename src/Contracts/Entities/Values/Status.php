<?php

namespace  Fixme\Ordering\Contracts\Entities\Values;

interface Status 
{
	/**
	 * returns an array of all available statuses
	 * 
	 * @return array
	 */
	public static function getStatuses(): array;

	/**
	 * return status type
	 * 
	 * @return string $type
	 */
	public function getType(): string;

	/**
	 * set the type of the status, must exists in the getStatus
	 *
	 * @param string $type
	 * @return void
	 */
	public function setType(string $type);
}