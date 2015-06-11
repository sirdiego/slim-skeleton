<?php
use Slim\Slim;
use Slim\Views\Twig;

define('APP_ROOT', realpath('..') . DIRECTORY_SEPARATOR);

require_once APP_ROOT . 'vendor/autoload.php';

session_start();

// Initialize Twig
$view = new Twig();
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
);

// Loading the configuration
$config = include APP_ROOT . 'config/config.php';
$config = array_merge($config, [
	'view' => $view,
]);

$app = new Slim($config);

// Initializing database connection
$app->container->singleton('database', function () use ($app) {
	return new \PDO($app->config('database.dsn'), $app->config('database.user'), $app->config('database.password'));
});

// Application routes
$app->get('/', function () use ($app) {
	echo $app->view->render('index.twig');
});

$app->run();

