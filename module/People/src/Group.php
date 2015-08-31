<?php

namespace People;

use Core\Model\DataObject;
use Core\Model\Interfaces\Sanitizable;


class Group extends DataObject
{
    public function getTableName()
    {
        return 'group_tab';
    }
}