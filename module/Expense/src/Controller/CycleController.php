<?php

namespace Expense\Controller;


use Core\Mvc\BaseController;


class CycleController extends BaseController
{
    public function indexAction()
    {
        $this->setTitle('Wydatek - ');
    }


    public function listAction()
    {
        $this->setTitle('Wydatki cykliczne - nie zaimplementowano');
    }


    public function addCycleAction()
    {
        $this->setTitle('Dodaj wydatek cykliczny');
    }


    public function saveAction()
    {
        $this->noRender();
    }
}