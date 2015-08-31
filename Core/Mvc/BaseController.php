<?php

namespace Core\Mvc;

use Core\App;
use Core\View\BaseView;
use Core\View\Html;
use Core\View\Json;
use Core\View\Cli;
use Core\Http\Response;
use Core\Input;
use Core\FlashMessenger;


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
     * True if controller can be accessed without logging
     * @var boolean
     */
    protected $_isPublic = false;


    /**
     * Page title
     * @var string
     */
    protected $_title;


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
        $this->input     = new Input();
        $this->messenger = FlashMessenger::instance();
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
        if (method_exists($this, 'init')) {
            $this->init();
        }

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
        if (!$this->_isPublic && !App::$user->isLogged()) {
            $this->_redirect('/application/login/index');
        }

        $this->_title = App::$config->title;
        $this->attach('flashMsg', $this->messenger->getMessages());
        return $this;
    }


    /**
     * Finishes action execution
     * @return self
     */
    private function _afterExec()
    {   
        if (!$this->noRender) {
            if (!$this->_view instanceof BaseView) {
                $this->setHtml();
            }
            $this->attach('title', $this->_title);
            $this->_view->bindData($this->_data);
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
     * Sets page title
     */
    protected function setTitle($title)
    {
        $this->_title = $title;
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


    protected function _redirect($url)
    {
        $this->noRender();
        return $this->_response->redirect($url);
    }


    /**
     * Redirects back
     */
    public function back()
    {
        if ($_SERVER['HTTP_REFERER']) {
            return $this->_redirect($_SERVER['HTTP_REFERER']);
        } else {
            return $this->_redirect('/');
        }
    }


    /**
     * Refuses access and redirects back
     */
    public function deny()
    {
        $this->error('Brak uprawnień!');
        $this->back();
    }


    /**
     * Adds success message
     * @param  string $msg
     */
    public function success($msg)
    {
        $this->messenger->setMessage($msg, FlashMessenger::SUCCESS);
    }


    /**
     * Adds error message
     * @param  string $msg
     */
    public function error($msg)
    {
        $this->messenger->setMessage($msg, FlashMessenger::ERROR);
    }


    /**
     * Adds info message
     * @param  string $msg
     */
    public function info($msg)
    {
        $this->messenger->setMessage($msg, FlashMessenger::INFO);
    }
}