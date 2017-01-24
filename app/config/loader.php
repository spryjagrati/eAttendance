<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->pluginsDir,
        $config->application->libraryDir,
        $config->application->formsDir,
        $config->application->tasksDir

    )
)->register();


require_once __DIR__ . '/../../vendor/autoload.php';
//require_once('vendor/autoload.php');


//routers for confirmEmail save in config with routers.php
/*<?php
$router = new Phalcon\Mvc\Router();
$router->add('/confirm/{code}/{email}', array(
        'controller' => 'session',
        'action' => 'confirmEmail'
));
return $router;*/