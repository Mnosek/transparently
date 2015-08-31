<?php

namespace Expense\Controller;


use Core\Mvc\BaseController;


class IndexController extends BaseController
{
    public function listAction()
    {
        $this->setTitle('Twoje rachunki');
    }


    public function indexAction()
    {
        $this->setTitle('Rachunek - ');
    }


    public function addExpenseAction()
    {
        $this->setTitle('Dodaj rachunek');
    }


    public function saveAction()
    {
        $this->noRender();
    }
}