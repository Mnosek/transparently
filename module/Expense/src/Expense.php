<?php

namespace Expense;

use Core\Model\DataObject;
use Core\Model\Interfaces\Sanitizable;
use Exception;

class Expense extends DataObject
{
    public function getTableName()
    {
        return 'expense_tab';
    }


    public function insert()
    {
        if (!is_array($this->userId)) {
            throw new Exception('Brak użytkowników do podziału rachunku');
        }

        try {
            self::$_db->beginTransaction();

            $this->currency_id = 'PLN';

            $userId = $this->userId;
            $userValue = $this->userValue;
            
            unset($this['userId']);
            unset($this['userValue']);

            $sum = 0;

            if ($this->split_type_id == 'Equally') {
                foreach($userId as $key => $id) {
                    $userValue[$key] = round(($this->value/count($userId)), 2); 
                }
            } elseif($this->split_type_id == 'Percentage') {
                foreach($userValue as $key => $value) {
                    $sum += $value;
                }

                if ($sum != 100) {
                    throw new Exception('Niepoprawna suma');
                }
            } elseif($this->split_type_id == 'Amount') {
                foreach($userValue as $key => $value) {
                    $sum += $value;
                }

                if ($sum != $this->value) {
                    throw new Exception('Niepoprawna suma');
                }
            } else {
                throw new Exception('Niepoprawny typ podziału');
            }


            parent::insert();
            $attr = array();
            $sql = "INSERT INTO expense_user_tab (expense_id, user_id, value) VALUES (:expense_id, :user_id, :value)";

            foreach($userId as $key => $user) {
                $attr['user_id'] = $user;
                $attr['expense_id'] = $this->id();
                $attr['value'] = $userValue[$key] ?: null;

                self::$_db->execDML($sql, $attr);
            }

            self::$_db->commit();
        } catch (Exception $e) {
            self::$_db->rollback();
            throw $e;
        }
    }
}