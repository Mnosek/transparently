<?php

namespace Core;

use Core\Model\BaseModel;


/**
 * User input model
 */
class Input extends BaseModel
{
    /**
     * Returns value from $_GET
     * @param  string $key
     * @return mixed
     */
    public function get($key = null)
    {
        if ($key) {
            return $_GET[$key];
        }

        return $_GET;
    }


    /**
     * Returns value from $_POST
     * @param  string $key
     * @return mixed
     */
    public function post($key = null)
    {
        if ($key) {
            return $_POST[$key];
        }
        
        return $_POST;
    }

}