<?php

namespace Expense\Controller;


use Core\Mvc\BaseController;


class CycleControlelr extends BaseController
{
    public function indexAction()
    {
        $this->setTitle('Wydatek - ');
    }


    public function listAction()
    {
        $this->setTitle('Lista wydatków');
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