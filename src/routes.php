<?php

\Route::group(config('commander.route'), function(){
	\Route::get('/', function(){
		return 'hi';
	});
});