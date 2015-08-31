<?php

namespace User;

use Core\Model\DataObject;
use Core\Model\Interfaces\Sanitizable;


class User extends DataObject
{
    public function getTableName()
    {
        return 'user_tab';
    }
}