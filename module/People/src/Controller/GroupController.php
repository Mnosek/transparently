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

        $groups = Group::find(array('user_id' => App::$user->user_id), 'name');
        $this->attach('groups', $groups);
    }


    public function expenseMemberAction()
    {
        $this->setBlank();

        try {
            if (!$this->input->get('group_id')) {
                throw new Exception('Nie odnaleziono grupy');
            }

            $group = Group::instance($this->input->get('group_id'));
            if (!$group->checkAccess()) {
                throw new Exception('Nie odnaleziono grupy');
            }

            $this->attach('members', $group->getMembers());

        } catch (Exception $e) {
            $this->_response->setCode(500);
            return;
        }
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

    }
}