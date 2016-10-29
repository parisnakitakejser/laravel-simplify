<?php
require('../config.php');

$controllersDirectory = ROOT_PATH . 'controllers';

// register the autoloader and add directories
Illuminate\Support\ClassLoader::register();
Illuminate\Support\ClassLoader::addDirectories([$controllersDirectory]);

// Instantiate the container
$app = new Illuminate\Container\Container();

// Tell facade about the application instance
Illuminate\Support\Facades\Facade::setFacadeApplication($app);

// register application instance with container
$app['app'] = $app;

// set environment
$app['env'] = 'production';

with(new Illuminate\Events\EventServiceProvider($app))->register();
with(new Illuminate\Routing\RoutingServiceProvider($app))->register();

include_once ROOT_PATH .'routes.php';

// Instantiate the request
$request = Illuminate\Http\Request::createFromGlobals();

try {
  $response = $app['router']->dispatch($request);
  $response->send();
} catch(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $notFound) {
  $blade = new Philo\Blade\Blade(BLADE_VIEWS, BLADE_CACHE);
  $bladeTemplate = 'error.404';
  $bladeData = [];

  with(new \Illuminate\Http\Response($blade->view()->make($bladeTemplate, $bladeData)->render(), 404))->send();
}
?>
