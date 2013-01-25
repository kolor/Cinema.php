<?php

ini_set('display_errors', 'On');

# return array of configuration options
Laravel\Event::listen(Laravel\Config::loader, function($bundle, $file)
{
	return Laravel\Config::file($bundle, $file);
});

# register class aliases
$aliases = Laravel\Config::get('application.aliases');

Laravel\Autoloader::$aliases = $aliases;

# auto-loader mappings
Autoloader::map(array(
	'Base_Controller' => path('app').'controllers/base.php',
));


# auto-loader directories
Autoloader::directories(array(
	path('app').'models',
	path('app').'libraries',
));

# view loader is responsible for returning the full file path for the given bundle and view
Event::listen(View::loader, function($bundle, $view)
{
	return View::file($bundle, $view, Bundle::path($bundle).'views');
});

# language loader is responsible for returning the array of language lines for a given bundle
Event::listen(Lang::loader, function($bundle, $language, $file)
{
	return Lang::file($bundle, $language, $file);
});

# attaching laravel profiler
if (Config::get('application.profiler'))
{
	Profiler::attach();
}

# blade templating engine enabled
Blade::sharpen();

# set default timezone
date_default_timezone_set(Config::get('application.timezone'));

# enable user sessions
if (!Request::cli() and Config::get('session.driver') !== '')
{
	Session::load();
}