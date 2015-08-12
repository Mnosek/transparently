<?php

namespace Core\Mvc;

use Core\View\BaseView;
use Core\View\Html;
use Core\View\Json;
use Core\View\Cli;
use Core\Http\Response;


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
        $this->$action();
        $this->_afterExec();

        return $this->_response;
    }


    private function _beforeExec()
    {
        return $this;
    }


    private function _afterExec()
    {   
        if (!$this->_view instanceof BaseView) 
        {
            $this->setHtml();
        }

        $this->_view->bindData($this->_data);
        $this->_view->render();

        $this->_response->setView();



        return $this;
    }


    /**
     * Disables view rendering
     * @return void
     */
    protected function noRender()
    {
        $this->_view = false;
    }


    /**
     * Sets HTML view type
     */
    protected function setHtml()
    {
        $this->_view = new Html();
    }


    /**
     * Sets JSON view type
     */
    protected function setJson()
    {
        $this->_view = new Json();
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

}