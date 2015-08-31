<?php

namespace Expense\Controller;


use Core\Mvc\BaseController;


class GroupController extends BaseController
{
    public function listAction()
    {
        $this->setTitle('Twoje grupyt');
    }


    public function indexAction()
    {
        $this->setTitle('Grupa - ');
    }


    public function addGroupAction()
    {
        $this->setTitle('Dodaj grupę');
    }


    public function saveAction()
    {
        $this->noRender();
    }
}