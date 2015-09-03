<?php

namespace User;

use Core\Model\DataObject;
use People\Friend;


class User extends DataObject
{
    public function getTableName()
    {
        return 'user_tab';
    }


    public function getFriends()
    {
        $users = array();

        $friends =  Friend::find(array('user_id' => $this->id()));

        if (!count($friends)) {
            return;
        }

        foreach ($friends as $friend) {
            $users[] = $friend->friend_user_id;
        }

        return User::find(array('user_id' => $users), 'last_name');
    }


    public function getBalance()
    {
        $params['user_id'] = $this->id();
        return reset(self::$_db->query("SELECT * FROM user_balance WHERE user_id = :user_id", $params));
    }


    public function getGroupBalance()
    {
        $params['user_id'] = $this->id();
        return self::$_db->query("SELECT * FROM user_group_balance WHERE user_id = :user_id", $params);
    }
}