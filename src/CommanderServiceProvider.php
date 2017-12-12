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
		$configPath = __DIR__ . '/../config/commander.php';
		$this->mergeConfigFrom($configPath, 'commander');
		$this->publishes([$configPath => config_path('commander.php')], 'config');

		$viewPath = __DIR__ . '/../resources/views';
		$this->loadViewsFrom($viewPath, 'commander');
		$this->publishes([
			$viewPath => base_path('resources/views/vendor/commander'),
		], 'views');

		$migrationPath = __DIR__ . '/../database/migrations';
		$this->publishes([
			$migrationPath => base_path('database/migrations'),
		], 'migrations');

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