<?php

namespace Expense\Controller;


use Core\Mvc\BaseController;


class FriendController extends BaseController
{
    public function listAction()
    {
        $this->setTitle('Znajomi');
    }


    public function indexAction()
    {
        $this->setTitle('Znajomy - ');
    }


    public function searchAction()
    {
        $this->setTitle('Szukaj znajomych');
    }


    public function addAction()
    {
        $this->noRender();
    }
}