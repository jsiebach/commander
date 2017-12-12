<?php

namespace JSiebach\Commander;


use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface CommandableInterface
 * @package JSiebach\Commander
 */
interface CommandableInterface {
	/**
	 * @return array
	 */
	public function getCommanderFields();
}