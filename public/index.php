<?php

/**
 * @author Michał Nosek <mmnosek@gmail.com>
 */

try {
    //Define directories constants
    define('ROOT_PATH',   dirname(__DIR__) . DIRECTORY_SEPARATOR);
    define('DATA_PATH',   ROOT_PATH . 'data' . DIRECTORY_SEPARATOR);
    define('MODULE_PATH', ROOT_PATH . 'module' . DIRECTORY_SEPARATOR);

    //Set error reporting
    error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

    //Set include path
    set_include_path(implode(PATH_SEPARATOR, array(
            realpath(ROOT_PATH),
            get_include_path(),
    )));

    //Class autoload initialization
    require_once('Core/Autoloader.php');
    $classLoader = new \Core\Autoloader();
    $classLoader->register();


    $app = \Core\App::init();
    $app->start();


} catch (Exception $e) {
    echo $e->getMessage();
}




