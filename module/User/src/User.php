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
}