<?php

namespace People;

use Core\Model\DataObject;
use Core\Model\Interfaces\Sanitizable;
use Core\App;
use Exception;


class Group extends DataObject
{
    public function getTableName()
    {
        return 'group_tab';
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
}