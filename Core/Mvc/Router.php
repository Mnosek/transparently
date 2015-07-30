<?php

namespace Core\Mvc;

use RuntimeException;
use Core\Filter;
use Core\Http\Request;


/**
 * Application router class. It dispatches request to the proper controllers
 * Please mind if there is rewrite module configured properly. It should returns
 * whole url in $_GET['_url'];
 *
 * @author Michał Nosek <mmnosek@gmail.com>
 */
final class Router
{
    /**
     * Request
     * @var \Core\Http\Request
     */
    private $_request;


    /**
     * Router constructor
     */
    public function __construct(Request $request)
    {
        $this->_request = $request;
    }


    /**
     * Request dispatcher
     */
    public function dispatch()
    {
        $path = $this->_request->getPath();
        $this->_setModule($path);
        $this->_setController($path);
        $this->_setAction($path);
    }


    /**
     * Checks and sets module
     * @param string[] $path url
     */
    private function _setModule($path)
    {
        if (!$path[0]) {
            $this->_module = 'Application';
        } else {
            $this->_module = ucfirst($path[0]);
        }

        if (!file_exists(MODULE_PATH . $this->_module)) {
            throw new RuntimeException('Invalid module specified');
        }
    }


    /**
     * Checks and sets controller
     * @param string[] $path url
     */
    private function _setController($path)
    {
        if (!$path[1]) {
            $this->_controller = 'IndexController';
        } else {
            $this->_controller = ucfirst($path[1]) . 'Controller';
        }
        
        $className = '\\' . $this->_module . '\\Controller\\' . $this->_controller;
        
        if (!class_exists($className)) {
            throw new RuntimeException('Invalid controller specified');
        }

        $controller = new $className;

        if (!$controller instanceof BaseController) {
            throw new RuntimeException('Controller is not instance of BaseController');
        }
        
        $this->_controller = $controller;
    }


    /**
     * Checks and sets action
     * @param string[] $path url
     */
    private function _setAction($path)
    {
         if (!$path[2]) {
            $this->_action = 'indexAction';
        } else {
            $this->_action = Filter::dashToCamelCase($path[2]) . 'Action';
        }

        if (!is_callable(array($this->_controller, $this->_action))) {
            throw new RuntimeException('Invalid action specified');
        }
    }
}