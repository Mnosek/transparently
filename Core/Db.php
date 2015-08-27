<?php

namespace Core;

use PDO;    

/**
 * Database mysql driver
 * @author Michał Nosek <mmnosek@gmail.com>
 */
final class Db
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
    
        $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->_connected = true;
        return $this;
    }


    /**
     * Executes sql statement
     * @param string $sql
     * @param array $bind
     * @return array
     */
    public function query($sql, $bind = array())
    {
        if (!$this->_connected) {
            $this->connect();
        }

        if (is_array($bind) && count($bind)) {

            $stm = $this->_pdo->prepare($sql);

            foreach ($bind as $key => &$val) {

                if (is_int($val)) {
                    $stm->bindParam(':' . $key, $val, PDO::PARAM_INT);
                } else {

                    $stm->bindParam(':' . $key, $val, PDO::PARAM_STR);
                }
            }
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            $stm->closeCursor();

            return $result;
        } else {

            return $this->_pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        }

    }


    /**
     * Executes DML statement (insert, update, delete)
     * @param string $sql
     * @param array $bind
     * @return int|\PDOStatement
     */
    public function execDML($sql, $bind =array())
    {
        if (!$this->_connected) {
            $this->connect();
        }

        if (is_array($bind) && count($bind)) {

            $stm = $this->_pdo->prepare($sql);

            foreach ($bind as $key => &$val) {

                if (is_int($val)) {
                    $stm->bindParam(':' . $key, $val, PDO::PARAM_INT);
                } else {
                    $stm->bindParam(':' . $key, $val, PDO::PARAM_STR);
                }
            }

            $stm->execute();
            $this->lastId = $this->_pdo->lastInsertId();

            return $stm;

        } else {

            $stm = $this->_pdo->exec($sql);
            $this->lastId = $this->_pdo->lastInsertId();

            return $stm;
        }
    }


    /**
     * Returns last insert id
     * @return int
     */
    public function getId()
    {
        return $this->lastId;
    }


    /**
     * Starts db transaction
     */
    public function beginTransaction()
    {
        if (!$this->$_connected) {
            $this->connect();
        }

        $this->_pdo->beginTransaction();
    }


    /**
     * Commits db transaction
     */
    public function commit()
    {
        if (!$this->$_connected) {
            $this->connect();
        }

        $this->_pdo->commit();
    }


    /**
     * Rollbacks db transaction
     */
    public function rollback()
    {
        if (!$this->$_connected) {
            $this->connect();
        }

        $this->_pdo->rollBack();
    }

    /**
     * Quotes a string for use in a query.
     * @param string $param
     * @return string
     */
    public function quote($param)
    {
        if (!$this->$_connected) {
            $this->connect();
        }

        return $this->_pdo->quote($param);
    }


    /**
     * Returns true if db is connected
     * @return boolean
     */
    public function isConnected()
    {
        if ($this->_connected) {
            return true;
        }

        return false;
    }
}