<?php

namespace Core\App;

use Core\App;


/**
 * Application user model
 * @author Michał Nosek <mmnosek@gmail.com>
 */
final class User
{
    /**
     * Creates new user
     * @param mixed $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);

        if (App::$session->isLogged) {
            if (!isset(App::$session->userPrivs) || !isset(App::$session->userRoles)) {
                $this->_loadPrivs();
                $this->_loadRoles();
            } else {
                $this->_privs = App::$session->userPrivs;
            }
        }
    }
}