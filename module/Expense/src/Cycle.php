<?php

namespace Expense;

use Core\Model\DataObject;
use Core\Model\Interfaces\Sanitizable;


class Cycle extends DataObject
{
    public function getTableName()
    {
        return 'cycle_tab';
    }
}