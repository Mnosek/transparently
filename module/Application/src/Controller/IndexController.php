<?php

namespace Application\Controller;


use Core\Mvc\BaseController;
use Core\App;

/**
 * Application default (index controller)
 */
class IndexController extends BaseController
{
    public function indexAction()
    {
        $this->attach('foo', 'FOOO');
    }
}