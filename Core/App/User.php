<?php

namespace Core\App;

use Core\App;
use Core\Model\BaseModel;

/**
 * Application user model
 * @author Michał Nosek <mmnosek@gmail.com>
 */
final class User extends BaseModel
{
    /**
     * User data field
     * @var array[]
     */
    private $data;


    /**
     * Creates new user
     * @param mixed $data
     */
    public function __construct($data = null)
    {
        $this->_appendData($data);
    }


    /**
     * Returns from data array
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->data[$key];
    }


    /**
     * Sets value in data array
     * @param  string $key
     * @return mixed $value
     */
    public function __set($key, $value)
    {
        return $this->data[$key] = $value;
    }


    /**
     * Returns user name and last name
     * @return string
     */
    public function __toString()
    {
        return $this->name . ' ' . $this->last_name;
    }


    /**
     * Appends data from arry
     * @param $data
     */
    private function _appendData($data)
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
    }


    /**
     * Logs user in
     *
     * @param string $login
     * @param string $password
     *
     * @return bool
     */
    public function login($login, $password)
    {
        $params = array (
            'login'    => $login,
            'password' => self::getPasswordHash($password, $login)
        );

        
        $query = "SELECT * FROM user_tab WHERE email=:login AND password=:password";
        $res = self::$_db->query($query, $params);

        if (count($res)) {
            $userData = reset($res);
        
            $this->_appendData($userData);

            App::$session->isLogged = true;
            App::$session->userIp   = $_SERVER['REMOTE_ADDR'];
            App::$session->userData = $userData;

            return true;
        }
        return false;
    }


    /**
     * Returns password hash
     * @param  string $password
     * @param  string $login
     * @return string encoded password hash
     */
    public static function getPasswordHash($password, $login)
    {
        return md5($login . '|' . $password);
    }


    /**
     * Reurns true if user is logged
     * @return boolean
     */
    public function isLogged()
    {
        if (!isset(App::$session)) {
            return false;
        }

        return App::$session->isLogged;
    }

}