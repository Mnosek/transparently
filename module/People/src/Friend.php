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
}