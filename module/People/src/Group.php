<?php

namespace People;

use Core\Model\DataObject;
use Core\Model\Interfaces\Sanitizable;
use Core\App;
use Exception;
use User\User;


class Group extends DataObject
{

    /**
     * Group members
     * @var \User\User
     */
    private $_members;


    public function getTableName()
    {
        return 'group_tab';
    }


    public function getViewName()
    {
        return 'pai.group';
    }


    public function insert($friends)
    {
        try {
            self::$_db->beginTransaction();

            parent::insert();
            if (!$this->id()) {
                throw new Exception('Wystąpił błąd podczas dodawania grupy');
            }

            $sql = "INSERT INTO user_group_tab(group_id, user_id, is_admin) VALUES (:group_id, :user_id, :is_admin)";
            $params = array();
            foreach ($friends as $friend) {
                $params['group_id'] = $this->id();
                $params['user_id']  = $friend;
                $params['is_admin']  = '0';

                self::$_db->execDML($sql, $params);
            }

            //Group admin
            $params['group_id'] = $this->id();
            $params['user_id']  = App::$user->user_id;
            $params['is_admin']  = 1;

            self::$_db->execDML($sql, $params);

            self::$_db->commit();
        } catch (Exception $e) {
            self::$_db->rollback();
            throw $e;
        }
    }


    /**
     * Returns group members
     * @return \User\User[]
     */
    public function getMembers()
    {
        if ($this->_members) {
            return $this->_members;
        }
        
        $users = array();
        $members =  self::$_db->query("SELECT user_id FROM user_group_tab WHERE group_id = :group_id", array('group_id' => $this->id()));

        if (!count($members)) {
            return;
        }
        
        foreach ($members as $member) {
            $users[] = $member['user_id'];
        }

        $this->_members = User::find(array('user_id' => $users), 'last_name');

        return $this->_members;
    }


    /**
     * Checks if user is attached to the group
     * @return boolean
     */
    public function checkAccess()
    {
        foreach ($this->getMembers() as $user) {
            if (App::$user->user_id == $user->id()) {
                return true;
            }
        }

        return false;
    }
}