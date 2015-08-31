<?php

namespace User;

use Core\Model\DataObject;


class User extends DataObject
{
    public function getTableName()
    {
        return 'user_tab';
    }
}