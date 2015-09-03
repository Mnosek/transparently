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
        $this->setTitle('Dashboard');

        $this->attach('balance', App::$user->getBalance());
        $this->attach('groupBalance', App::$user->getGroupBalance());

    }
}