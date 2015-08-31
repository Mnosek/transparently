<?php

namespace Expense;

use Core\Model\DataObject;
use Core\Model\Interfaces\Sanitizable;


class Payment extends DataObject
{
    public function getTableName()
    {
        return 'payment_tab';
    }
}