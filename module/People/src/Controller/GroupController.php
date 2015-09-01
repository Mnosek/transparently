<?php

namespace People\Controller;


use Core\Mvc\BaseController;
use Core\App;
use People\Group;
use Exception;


class GroupController extends BaseController
{
    public function listAction()
    {
        $this->setTitle('Grupy');
        $user = App::$user->getUser();  

        $this->attach('friends', $user->getFriends());
    }


    public function indexAction()
    {
        $this->setTitle('Grupa - ');
    }


    public function listPaneAction()
    {
        $this->setBlank();

    }


    public function createAction()
    {
        $this->noRender();
        
        try {
            if (!$this->input->post('name') || !is_array($this->input->post('friend'))) {
                throw new Exception('Brak danych');
            }

            $group = new Group(array('name' => $this->input->post('name')));
            
            $group->insert($this->input->post('friend'));

        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            return;
        }


        var_dump($this->input->post());

    }
}