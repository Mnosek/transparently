<?php

namespace Expense;

use Core\Model\DataObject;
use Core\Model\Interfaces\Sanitizable;


class Expense extends DataObject
{
    public function getTableName()
    {
        return 'expense_tab';
    }
}