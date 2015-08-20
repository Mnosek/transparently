<?php

namespace Core;

use ArrayObject;
use Core\Mvc\Router;
use Core\Http\Request;


/**
 * Application core class
 * @author Michał Nosek <mmnosek@gmail.com>
 */
final class App
{   
    /**
     * Singleton \App instance
     * @var \App
     */
    private static $_app;


    /**
     * Registry
     * @var ArrayObject
     */
    public static $registry;


    /**
     * Router instance
     * @var \Core\Mvc\Router
     */
    public static $_router;


    /**
     * Request instance
     * @var \Core\Http\Request
     */
    private static $_request;


     /**
     * Response instance
     * @var \Core\Http\Response
     */
    private static $_response;


    /**
     * Private constructor to force singleton instance
     */
    private function __construct(){}


    /**
     * Starts application with configuration initialization
     * @return \App
     */
    public static function init()
    {
        if (!self::$_app instanceof self) {
            self::$_app = new self();            
        }
        return self::$_app;
    }


    /**
     * Starts an application
     * @return void
     */
    public function start()
    {
        self::$registry  = new ArrayObject();
        self::$_request  = new Request();
        self::$_router   = new Router(self::$_request);
        self::$_router->dispatch();
        
        $this->handle();
    }


    /**
     * Handles request and executes controller
     * @return void
     */
    private function handle()
    {
        $controller = self::$_router->getController();
        $action     = self::$_router->getAction();

        $this->_response = $controller->execute($action);
        $this->finish();
    }


    /**
     * Finishes application run
     * Sends headers and content to browser
     * @return void;
     */
    private function finish()
    {
        if (!$this->isConsole()) {
            foreach ($this->_response->getHeaders() as $header) {
                header((string)$header, true, $this->_response->getCode());
            }
        }

        echo $this->_response->getContent();
    }


    /**
     * Returns true if CLI context
     * @return bool
     */
    public static function isConsole()
    {
        return PHP_SAPI == 'cli';
    }
}