<?php

namespace People;

use Core\Model\DataObject;
use Core\Model\Interfaces\Sanitizable;


class Friend extends DataObject
{
    public function getTableName()
    {
        return 'friend_tab';
    }


    protected $multiPrimaryKey = array('user_id', 'friend_user_id');



    public static function find($params = null, $order = null)
    {
        if ($params['user_friend_id']) {
            Friend::$customParam[] = '(user_id = :user_friend_id OR friend_user_id = :user_friend_id)';
            Friend::$customValue['user_friend_id'] = $params['user_friend_id'];

            unset($params['user_friend_id']);
        }

        return parent::find($params, $order);
    }


    public function insert()
    {
        $params = array(
            'user_id' => $this->user_id,
            'friend_user_id' => $this->friend_user_id
        );

        self::$_db->execDML("CALL add_friend(:user_id, :friend_user_id)", $params);
    }

}