<?php

namespace Expense\Controller;


use Core\Mvc\BaseController;


class PaymentController extends BaseController
{
    public function indexAction()
    {
        $this->setTitle('Wpłata');
    }


    public function listAction()
    {
        $this->setTitle('Lista wpłat');
    }


    public function addPaymentAction()
    {
        $this->setTitle('Dodaj wpłatę');
    }


    public function saveAction()
    {
        $this->noRender();
    }
}