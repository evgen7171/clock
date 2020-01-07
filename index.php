<?php
/*
include $_SERVER['DOCUMENT_ROOT'] .
    '/services/Autoload.php';
spl_autoload_register(
    [new Autoload(),
        'loadClass']
);

$controllerName = $_GET['controller'] ?: 'user';
$actionName = $_GET['action'];
$tableName = $_GET['table'];
$id = $_GET['id'];
$unitData = $_POST;

$controllerClass = 'App\\controllers\\' .
    ucfirst($controllerName) . 'Controller';

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    $controller->run($actionName, $tableName, $id, $unitData);
};
*/

//$config = include($_SERVER['DOCUMENT_ROOT'] .'/main/config.php');
/*
\App\main\App::call()->run($config);

*/
include $_SERVER['DOCUMENT_ROOT'] .
    '/services/Autoload.php';
spl_autoload_register(
    [new Autoload(),
        'loadClass']
);

$config = include($_SERVER['DOCUMENT_ROOT'] .'/../main/config.php');
\App\main\App::call()->run($config);