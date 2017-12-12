<?php
namespace JSiebach\Commander;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class CommanderServiceProvider extends ServiceProvider {
	/**
	 * Perform post-registration booting of services.
	 *
	 * @param Router $router
	 *
	 * @return void
	 */
	public function boot(Router $router)
	{

		$this->publishes([ __DIR__ . '/config' => config_path()], 'config');
		$this->publishes([ __DIR__ . '/database/migrations' => base_path('database/migrations')], 'migrations');
		$this->publishes([ __DIR__ . '/resources/views' => resource_path('views/vendor/commander')], 'views');

		$this->loadViewsFrom(resource_path('views/vendor/commander'), 'commander');
		$this->loadViewsFrom(realpath(__DIR__.'/resources/views'), 'commander');


		$config = $this->app['config']->get('commander.route', []);
		$config['namespace'] = 'JSiebach\Commander';

		$router->group($config, function($router)
		{
			\CRUD::resource('command', 'CommanderCrudController');
			\Route::get('command/{command}/run', 'CommanderCrudController@getRun');
			\Route::post('command/{command}/run', 'CommanderCrudController@postRun');
		});
	}
}