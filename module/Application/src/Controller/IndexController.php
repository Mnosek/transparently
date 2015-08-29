<?php

namespace Application\Controller;


use Core\Mvc\BaseController;
use Core\App;

/**
 * Application default (index controller)
 */
class IndexController extends BaseController
{
    /**
     * Application main page
     * @todo
     * @return
     */
    public function indexAction()
    {   
        $this->attach('foo', 'FOOO');
    }
}