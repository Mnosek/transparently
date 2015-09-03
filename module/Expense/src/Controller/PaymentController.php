<?php

namespace Expense\Controller;


use Core\Mvc\BaseController;
use Expense\Expense;
use Expense\Payment;
use People\Group;
use Core\App;

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


    public function addAction()
    {
        $this->noRender();

        try {
            if (!$this->input->get('expense_id')) {
                throw new Exception('Brak id wydatku');
            }

            if (!$this->input->get('value')) {
                throw new Exception('Brak kwoty wpłaty');
            }

            $expense = Expense::instance($this->input->get('expense_id'));
            $group = Group::instance($expense->group_id);
            
            $group->checkAccess();

            $payment = new Payment(array(
                'expense_id' => $expense->id(),
                'user_id'    => App::$user->user_id,
                'value'      => $this->input->get('value')
            ));

            $payment->insert();

            $this->success('Zarejestrowano wpłatę');

        } catch (Exception $e) {
            $this->error($e->getMessage());
        } finally {
            $this->back();
            return;
        }




        die('asdas');
    }
}