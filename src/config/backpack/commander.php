<?php
return [
	/*
	 * Configure the routes for your Commander CRUD
	 */
	'route' => [
		'prefix'     => config('backpack.base.route_prefix', 'admin').'/commander',
		'middleware' => ['web', 'admin'],
	],
	/*
	 * If true, users can add and delete new commands. This should not be used in production
	 */
	'allow_creation_and_deletion' => env('APP_ENV') == "local"
];