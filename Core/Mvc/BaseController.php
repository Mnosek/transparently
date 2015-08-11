<?php

namespace Core\Mvc;

use Core\View\Html;
use Core\View\Json;
use Core\View\Cli;
use Core\Http\Response;


abstract class BaseController
{
    protected $_view;
    protected $_response;

    public function __construct()
    {
        $this->$_response = new Response();
    }

    public function execute($action)
    {
        $this->_beforeExec();
        $this->$action();
        $this->_afterExec();

        return $this->_response;
    }


    private function _beforeExec()
    {
        echo 'before controller<br />';
        return $this;
    }


    private function _afterExec()
    {
        echo 'after controller<br />';
        return $this;
    }

}