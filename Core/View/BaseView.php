<?php

namespace Core\View;

abstract class BaseView
{
    private $_data;

    public function bindData($data)
    {
        $this->$_data = $data;
    }
}