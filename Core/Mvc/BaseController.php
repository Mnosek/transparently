<?php

namespace Core\Mvc;

use Core\App;
use Core\View\BaseView;
use Core\View\Html;
use Core\View\Json;
use Core\View\Cli;
use Core\Http\Response;


/**
 * Abstract controller model
 * @author Michał Nosek <mmnosek@gmail.com>
 */
abstract class BaseController
{
    /**
     * View instance
     * @var \Core\View\BaseView
     */
    protected $_view;


    /**
     * View data
     * @var array
     */
    protected $_data = array();


    /**
     * Http response
     * @var \Core\Http\Response
     */
    protected $_response;


    /**
     * Executed action
     * @var string
     */
    private $_action;


    /**
     * Returns controller short name
     * @return string
     */
    public function __toString()
    {
        $class = new \ReflectionClass(get_class($this));

        return strtolower(str_replace('Controller', '', $class->getShortName()));
    }


    /**
     * Controller constructor
     */
    public function __construct()
    {
        $this->_response = new Response();
    }


    /**
     * Executes specified controller and actions
     * @param  string $action controller  method name
     * @return \Core\Mvc\Response response to send
     */
    public function execute($action)
    {
        $this->_beforeExec();
        $this->_action = $action;
        $this->$action();
        $this->_afterExec();

        return $this->_response;
    }


    /**
     * Prepares to action executrion
     * @return this
     */
    private function _beforeExec()
    {
        return $this;
    }


    /**
     * Finishes action execution
     * @return self
     */
    private function _afterExec()
    {   
        if (!$this->_view instanceof BaseView) {
            $this->setHtml();
        }

        $this->_view->bindData($this->_data);

        if (!$this->noRender) {
            $this->_response->setContent($this->_view->render($this->isBlank));
        }

        return $this;
    }


    /**
     * Disables view rendering
     * @return void
     */
    protected function noRender()
    {
        $this->noRender = true;
    }


    /**
     * Turns HTML footer and header off
     */
    protected function setBlank()
    {
        $this->isBlank = true;
    }


    /**
     * Sets HTML view type
     */
    protected function setHtml()
    {
        $this->_response->setHeader('Content-Type', 'text/html; charset=utf-8');
        $this->_view = new Html($this->_getTemplatePath());
    }


    /**
     * Sets JSON view type
     */
    protected function setJson()
    {
        $this->_view = new Json();
        $this->_response->setHeader('Content-Type', 'text/json; charset=utf-8');
    }


    /**
     * Sets CLI view type
     */
    protected function setCli()
    {
        $this->_view = new Cli();
    }


    /**
     * Attaches data to view rendering
     * @param  string $key  view variable name
     * @param  mixed $data bound content
     */
    protected function attach($key, $data)
    {
        $this->_data[$key] = $data;
    }


    /**
     * Returns template file path
     * @return string
     */
    private function _getTemplatePath()
    {
        return MODULE_PATH . App::$_router->getModule() . DIRECTORY_SEPARATOR .
        'view' . DIRECTORY_SEPARATOR . App::$_router->getController() . DIRECTORY_SEPARATOR . 
        substr(strtolower(App::$_router->getAction()), 0, -6) . '.php';
    }


    /**
     * Returns response
     * @return \Core\Http\Response
     */
    public function getResponse()
    {
        return $this->_response;
    }

}