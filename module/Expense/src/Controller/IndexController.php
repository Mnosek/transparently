<?php

namespace Expense\Controller;


use Core\Mvc\BaseController;
use People\Group;
use Core\App;
use Exception;
use Expense\Expense;


class IndexController extends BaseController
{
    public function listAction()
    {
        $this->setTitle('Twoje rachunki');

        $groups = Group::find(array('user_id' => App::$user->user_id), 'name');
        $this->attach('groups', $groups);
    }


    public function listPaneAction()
    {
        $this->setBlank();
    }


    public function indexAction()
    {
        $this->setTitle('Rachunek - ');
    }



    public function addAction()
    {
        $this->noRender();

        $params = $this->input->post();

        try {
            if (!$params['group_id'] || !$params['value'] || !$params['date'] || !$params['name'] || !$params['split_type_id']) {
                throw new Exception('Brak danych rachunku');
            }

            if ($params['split_type_id'] != 'Equally') {
                foreach ($params['userValue'] as $value) {
                    if (!(float)$value) {
                        throw new Exception('Niepoprawne wartości');
                    }
                } 
            }

            if (!is_array($params['userId'])) {
                throw new Exception('Brak danych użytkowników');
            }

            $expense = new Expense($params);
            $expense->insert();

        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
        } finally {
            echo json_encode($response);
        }
        

    }
}