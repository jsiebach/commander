<?php
/**
 * Created by PhpStorm.
 * User: lsm
 * Date: 12/11/17
 * Time: 7:33 PM
 */

namespace JSiebach\Commander;


use Backpack\CRUD\CrudTrait;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Eloquent\Model;

class CommanderCommand extends Model {
	use CrudTrait;

	/*
   |--------------------------------------------------------------------------
   | GLOBAL VARIABLES
   |--------------------------------------------------------------------------
   */

	protected $table = 'commander_commands';
	//protected $primaryKey = 'id';
	// public $timestamps = false;
	protected $guarded = ['id'];
	// protected $fillable = [];
	// protected $hidden = [];

	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/
	/*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
	/*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/

	/*
	|--------------------------------------------------------------------------
	| ACCESORS
	|--------------------------------------------------------------------------
	*/
	public function getNameAttribute(){
		return $this->descriptive_name ? $this->descriptive_name : $this->command_object->getName();
	}
	public function getCommanderFields(  ) {
		return method_exists($this->command_object, 'getCommanderFields') ?
			$this->command_object->getCommanderFields() :
			[];
	}
	public function getCommandObjectAttribute(){
		return app(Kernel::class)->all()[$this->command];
	}
	public function getDescriptionAttribute(){
		return $this->command_object->getDescription();
	}

	/*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}