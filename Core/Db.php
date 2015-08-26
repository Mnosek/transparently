<?php

namespace Core;

use PDO;    

class Db
{
    /**
     * PDO instance
     * @var PDO
     */
    protected $_pdo;


    /**
     * True if connection is open
     * @var boolean
     */
    private $_connected = false;


    /**
     * Connects to database
     * @return \Core\Db
     */
    public function connect()
    {


        $this->_pdo = new PDO (
            'mysql:host=' . App::$config->dbhost . ';dbname=' . App::$config->dbname, 
            App::$config->dbuser, 
            App::$config->dbpass
        );

        $this->_connected = true;
        return $this;
    }
}