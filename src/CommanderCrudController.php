<?php

namespace JSiebach\Commander;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use Carbon\Carbon;
use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Support\Facades\Artisan;
use Route;

class CommanderCrudController extends CrudController
{
	public function setup()
	{

		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->crud->setModel(CommanderCommand::class);
		$this->crud->setRoute(config('backpack.commander.route.prefix').'/command');
		$this->crud->setEntityNameStrings('command', 'commands');

		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

		//$this->crud->setFromDb();

		// ------ CRUD FIELDS
		// $this->crud->addField($options, 'update/create/both');
		// $this->crud->addFields($array_of_arrays, 'update/create/both');
		// $this->crud->removeField('name', 'update/create/both');
		// $this->crud->removeFields($array_of_names, 'update/create/both');

		// ------ CRUD COLUMNS
		// $this->crud->addColumn(); // add a single column, at the end of the stack
		$this->crud->addColumns([
			[
				'name' => 'name',
				'label' => 'Name',
				'type' => 'model_function',
				'function_name' => 'getNameAttribute'
			],
			[
				'name' => 'description',
				'label' => 'Description',
				'type' => 'model_function',
				'function_name' => 'getDescriptionAttribute'
			]
		]);

		if(!is_null( Route::current()->parameter('command'))){
			$command = CommanderCommand::find( Route::current()->parameter('command'));
			$this->crud->addFields($command->getCommanderFields());
		} else {
			$this->crud->addFields([
				[
					'name' => 'command',
					'label' => 'Command',
					'type' => 'text'
				],
				[
					'name' => 'descriptive_name',
					'label' => 'Descriptive Name (Optional)',
					'type' => 'text'
				]
			]);
		}
		// $this->crud->removeColumn('column_name'); // remove a column from the stack
		// $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
		// $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
		// $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

		// ------ CRUD BUTTONS
		// possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
		if(!config('backpack.commander.allow_creation_and_deletion', false) == true){
			$this->crud->removeAllButtons();
		}
		$this->crud->addButton('line', 'run', 'view', 'commander::run-button', 'end'); // add a button; possible types are: view, model_function
		// $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
		// $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
		// $this->crud->removeButton($name);
		// $this->crud->removeButtonFromStack($name, $stack);
		// $this->crud->removeAllButtons();
		// $this->crud->removeAllButtonsFromStack('line');
		// ------ CRUD ACCESS
		// $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
		// $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

		// ------ CRUD REORDER
		// $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
		// NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

		// ------ CRUD DETAILS ROW
		// $this->crud->enableDetailsRow();
		// NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
		// NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

		// ------ REVISIONS
		// You also need to use \Venturecraft\Revisionable\RevisionableTrait;
		// Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
		// $this->crud->allowAccess('revisions');

		// ------ AJAX TABLE VIEW
		// Please note the drawbacks of this though:
		// - 1-n and n-n columns are not searchable
		// - date and datetime columns won't be sortable anymore
		// $this->crud->enableAjaxTable();

		// ------ DATATABLE EXPORT BUTTONS
		// Show export to PDF, CSV, XLS and Print buttons on the table view.
		// Does not work well with AJAX datatables.
		// $this->crud->enableExportButtons();

		// ------ ADVANCED QUERIES
		// $this->crud->addClause('active');
		// $this->crud->addClause('type', 'car');
		// $this->crud->addClause('where', 'name', '==', 'car');
		// $this->crud->addClause('whereName', 'car');
		// $this->crud->addClause('whereHas', 'posts', function($query) {
		//     $query->activePosts();
		// });
		// $this->crud->addClause('withoutGlobalScopes');
		// $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
		// $this->crud->with(); // eager load relationships
		// $this->crud->orderBy();
		// $this->crud->groupBy();
		// $this->crud->limit();
	}

	public function store(CrudRequest $request)
	{
		// your additional operations before save here
		$redirect_location = parent::storeCrud($request);
		// your additional operations after save here
		// use $this->data['entry'] or $this->crud->entry
		return $redirect_location;
	}

	public function update(CrudRequest $request)
	{
		// your additional operations before save here
		$redirect_location = parent::updateCrud($request);
		// your additional operations after save here
		// use $this->data['entry'] or $this->crud->entry
		return $redirect_location;
	}

	public function getRun($id) {
		//$this->crud->hasAccessOrFail('update');

		// get the info for that entry
		$this->data['entry'] = $this->crud->getEntry($id);
		$this->data['crud'] = $this->crud;
		$this->data['saveAction'] = $this->getSaveAction();
		$this->data['fields'] = $this->data['entry']->getCommanderFields();
		$this->data['action'] = 'update';
		$this->data['title'] = $this->data['entry']->name;

		$this->data['id'] = $id;

		// load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
		return view('commander::run', $this->data);
	}

	public function postRun($id, CrudRequest $request) {
		// fallback to global request instance
		if (is_null($request)) {
			$request = \Request::instance();
		}
		$command = CommanderCommand::findOrFail($id);
		if($request->get('--queue_command')){
			Artisan::queue($command->command_object->getName(),
				$request->except('http_referrer','_token', '--queue_command', '--queue_name'))->onQueue($request->get('--queue_name', 'default'));
			$exitCode = 2;
		} else {
			$exitCode = Artisan::call($command->command_object->getName(),
				$request->except('http_referrer','_token', '--queue_command', '--queue_name'));
		}

		$this->data['id'] = $id;
		$this->data['entry'] = $this->crud->getEntry($id);
		$this->data['crud'] = $this->crud;
		$this->data['title'] = $this->data['entry']->name .' - Output';
		$this->data['output'] = Artisan::output();
		$this->data['exitCode'] = $exitCode;

		if(0 === $exitCode){
			\Alert::success('Command executed successfully.');
		} else if (2 === $exitCode){
			\Alert::success('Command queued.');
		} else {
			\Alert::warning('Command failed to execute.');
		}

		return view('commander::output', $this->data);
	}
}
