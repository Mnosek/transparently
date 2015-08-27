<?php

namespace Core\App;

use Core\Model\BaseModel;

/**
 * Custom session handler
 * @author Michał Nosek <mmnosek@gmail.com>
 */
class Session extends BaseModel
{ 
    /**
     * Session lifetime
     * @var int
     */
    private $_lifeTime; 


    /**
     * Session constructor
     * @return [type] [description]
     */
    public function __counstruct()
    {
        parent::__counstruct();
    }


    /**
     * Sets data from $_SESSION
     */
    public function prepare()
    {
        foreach($_SESSION as $key => $value) {
            $this[$key] = $value;
        }
    }


    /**
     * Magic setter to set $_SESSION and instance value
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
        $this[$name] = $value;
    }


    /**
     * Magic getter to return value by ->
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this[$name];
    }


    /**
     * Session open handler
     * @param $savePath
     * @param $sessName
     * @return boolean
     */
    public function open($savePath, $sessName) { 
        $this->_lifeTime = get_cfg_var("session.gc_maxlifetime"); 
       
        if (!self::$_db->isConnected()) {
            self::$_db->connect();
        }
 
        if (!self::$_db->isConnected()) {
           return false; 
        }
       
      return true; 
    } 


    /**
     * Close sesion handler
     * @return [type] [description]
     */
    public function close() { 
        $this->gc(ini_get('session.gc_maxlifetime')); 
    }


    /**
     * Read handler
     * @param  string $sessID
     * @return mixed
     */
    public function read($sessID) { 
        $res = self::$_db->query("SELECT session_data AS d FROM session_tab WHERE session_id = :session_id AND session_expires > ".time(),
                                 array('session_id' => $sessID)); 
        
        if (count($res)) {
            return $res[0]['d']; 
        }
        return ""; 
    } 


    /**
     * Write session handler
     * @param  string $sessID
     * @param  mixed $sessData
     * @return boolean
     */
    public function write($sessID,$sessData) { 

        $newExp = time() + $this->_lifeTime; 

        $res = self::$_db->query("SELECT * FROM session_tab WHERE session_id = :session_id", array('session_id' => $sessID));

        if(count($res)) { 
            self::$_db->execDML("UPDATE session_tab SET session_expires = :exp, session_data = :data WHERE session_id = :sessID",
                                array('exp' => $newExp,
                                      'data' => $sessData,
                                      'sessID' => $sessID));
         
            return true; 
        } else { 
            $res = self::$_db->execDML("INSERT INTO session_tab (session_id, session_expires, session_data) VALUES(:sessID, :exp, :data)",
                                array('sessID'   => $sessID,
                                      'exp'      => $newExp,
                                      'data' => $sessData));
            //@todo
            //Check if session insertted to db 
            return true;
        }
    }


    /**
     * Destroy handler
     * @param  string $sessID
     * @return boolean
     */
    public function destroy($sessID) { 
        self::$_db->execDML("DELETE FROM session_tab WHERE session_id = :session_id", array('session_id' => $sessID));
        return true;
    } 


    /**
     * Garbage collector
     * @param  integer $sessMaxLifeTime
     */
    public function gc($sessMaxLifeTime) { 
        self::$_db->execDML("DELETE FROM session_tab WHERE session_expires < " . time());
    } 
} 