<?php

namespace Application\Controller;


use Core\Mvc\BaseController;

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