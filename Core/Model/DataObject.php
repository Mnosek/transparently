<?php

namespace Core\Model;

use Exception;

/**
 * Base data model.
 * @author Michał Nosek <mmnosek@gmail.com>
 */
abstract class DataObject extends BaseModel
{
    /**
     * For tables with multifield PK
     * @var array
     */
    protected $multiPrimaryKey = array();


    /**
     * Should return table name
     */
    abstract public function getTableName();

    protected static $customParam = array();
    protected static $customValue = array();

    /**
     * Returns object private fields
     * @param $name
     * @return mixed
     */
    public function __get($name) {
        if ($this->offsetExists($name)) {
            return $this[$name];
        }
    }


    /**
     * Sets value to private object fields
     * @param $name
     * @param $value
     * @return mixed
     */
    public function __set($name, $value)
    {
        return $this[$name] = $value;
    }


    /**
     * Fills object private storage
     * @param  $data[]
     */
    public function __construct($data = null)
    {
        if ($data) {
            parent::__construct($data);
        }

    }


    /**
     * Creates object instance
     * @param mixed $idObject value Primary key or associative array[]
     * @return static
     * @throws \Exception
     */
    public static function instance($idObject)
    {
        if ($idObject == null || $idObject == '') {
            return null;
        }

        $instance = new static();

        if (method_exists(get_called_class(), 'getViewName')) {
            $tableName = $instance->getViewName();
        } else {
            $tableName = $instance->getTableName();

        }

        $sql = "SELECT * FROM " . $tableName . " WHERE 1=1 ";

        $primaryKey = $instance->getPrimaryKeyFields();

        if (!is_array($primaryKey)) {
            if (!is_array($idObject)) {
                $sql .= "AND " . $primaryKey ." = :" . $primaryKey;
                $idObject = array($primaryKey => $idObject);
            } else if ($instance->checkPrimaryKey($idObject)) {
                $sql .= "AND " . $primaryKey ." = :" . array_values($idObject);
            } else {
                throw new Exception("Invalid object Id array");
            }
        } else {
            if ($instance->checkPrimaryKey($idObject)) {
                foreach ($idObject as $key => $val) {
                    $sql .= "AND " . $key . " = :" . $key . " ";
                }
            } else {
                throw new Exception("Invalid object Id array");
            }
        }
      

        foreach (self::$_db->query($sql, $idObject) as $row) {
            $objects = new static($row);
        }

        return isset($objects)? $objects : null;
    }


    public static function find($params = null, $order = null)
    {
        $instance = new static();

        if (method_exists(get_called_class(), 'getViewName')) {
            $tableName = $instance->getViewName();
        } else {
            $tableName = $instance->getTableName();
        }

        $sql = 'SELECT * FROM ' . $tableName . ' WHERE 1=1';

        if ($params || self::$customParam) {
            $prepareParam = $instance->prepareParams($params);
            if ($prepareParam) {
                $sql .=' AND ' . $prepareParam;
            }
        }

        if ($order && preg_match('/([a-zA-z]+)\s(ASC|DESC)/i', $order)) {
            $sql .= " ORDER BY " . $order;
        }


        $objects = array();

        foreach (self::$_db->query($sql, $params) as $row) {
            $object = new static($row);
            if ($object->id()) {
                $objects[$object->id()] = $object;
            } else {
                $objects[] = $object;
            }
        }

        return $objects;

    }


    /**
     * Updates object in db;
     * @return $this
     */
    public function update()
    {
        if ($this->checkPrimaryKey()) {

            if ($this instanceof Sanitizable) {
                $this->sanitize();
            }

            $params = $this->getArrayCopy();
            $primaryKeyFields = $this->getPrimaryKeyFields();

            $sql = 'UPDATE ' . $this->getTableName() . ' SET ';

            if (!is_array($primaryKeyFields)) {
                unset($params[$primaryKeyFields]);

                foreach ($params as $key => $param) {
                    $sql .= $key . ' = :' . $key . ',';
                }

                $sql = rtrim($sql,',');

                $sql .= ' WHERE ' . $primaryKeyFields . '= :' . $primaryKeyFields . ';';
            } else {
                $primaryKey = array();
                $where = ' WHERE ';

                foreach ($primaryKeyFields as $field) {
                    $primaryKey[] = $field;
                    unset($params[$field]);

                    $where .= $field . ' = :' . $field;
                }

                foreach ($params as $key => $val) {
                    $sql .= $key . ' = :' . $key . ',';
                }

                $sql = rtrim($sql,',');

                $sql .= $where;
            }

            self::$_db->execDML($sql, $this->getArrayCopy());

            return $this;
        }
    }


    /**
     * Saves object into db
     * @return $this
     */
    public function insert()
    {

        if ($this->checkPrimaryKey()) {

            $params = $this->getArrayCopy();

            $sql = 'INSERT INTO ' . $this->getTableName() . '('
                . implode(',', array_keys($params)) . ') VALUES ';

            $values = '';
            foreach ($this as $key => $val) {
                $values .= ':' . $key . ',';
            }

            $values = rtrim($values,',');
            $sql .= '(' . $values  . ')';

            self::$_db->execDML($sql, $params);
            $this->setId(self::$_db->getId());

        }

        return $this;

    }


    /**
     * Returns primary key fields
     * @return array|string
     */
    private function getPrimaryKeyFields()
    {
        if (!empty($this->multiPrimaryKey)) {
            return $this->multiPrimaryKey;
        } else {
            $tableName = $this->getTableName();

            $primaryKey = str_replace('_tab', '_id', $tableName);

            return $primaryKey;
        }

    }


    /**
     * Check if primary key exists
     * @param null $params
     * @return bool
     */
    private function checkPrimaryKey($params = null)
    {
        if ($params == null) {
            $primaryKeys = $this->getPrimaryKeyFields();
        } else {
            $primaryKeys = $params;
        }

        if (is_array($primaryKeys)) {

            foreach($primaryKeys as $key) {
                if ($this->$key == null) {
                    return false;
                }
            }
        } else {
            $this->$primaryKeys == null? false : true;
        }

        return true;
    }


    /**
     * Prepares sql WHERE condition, and bind params
     * @param $params
     * @return string
     */
    private function prepareParams(&$params)
    {
        $conditions = array();
        $bindParam = array();

        foreach ($params as $key => $param) {

            if (is_array($param)) {

                foreach ($param as $i => $val) {
                    $bindParam[$key . '_' . $i] = $val;
                    $sqlParam[] = ':' .$key . '_' . $i;
                }
                unset($params[$key]);
                $conditions[] = $key . ' IN (' .implode(',', $sqlParam) . ')';
            } else if ($param != ''){
                if (strpos($param, '%') !== false) {
                    $conditions[] = $key . ' LIKE ' . $key;
                } else {
                    $conditions[] = $key . '= :' . $key;
                }
            } else {
                unset($params[$key]);
            }
        }

        foreach (self::$customParam as $param) {
            $conditions[] = $param;
        }  

        foreach (self::$customValue as $key => $value) {
            $params[$key] = $value;
        }
     
        self::$customParam = array();
        self::$customValue = array();

       
        $params = array_merge($params, $bindParam);

        return implode(' AND ', $conditions);
    }


    /**
     * Sets object id
     * @param [type] $ids [description]
     */
    private function setId($ids)
    {
        $primaryFields = $this->getPrimaryKeyFields();
        if (!is_array($primaryFields) && count($ids) == 1) {
            $this->$primaryFields = $ids;
        } else if ($this->checkPrimaryKey($ids)) {
            foreach ($ids as $key => $val) {
                $this->$key = $val;
            }
        } else {
            throw new Exception("Can't set ids");
        }
    }


    /**
     * Returns object id
     * @return int | array
     */
    public function id()
    {
        $primaryKey = $this->getPrimaryKeyFields();

        if (is_array($primaryKey)) {

        } else {
            return $this->$primaryKey;
        }
    }


    /**
     * Get table columns from information_schema
     * @return array()
     */
    public static function getTableFields()
    {
        $sql = 'SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = :table_name';
        $params = array('table_name' => static::getTableName());

        return self::$_db->query($sql,$params);
    }


    /**
     * Loads values from view
     * @return 
     */
    public function load()
    {

        if (!method_exists($this, 'getViewName')) {
            throw new Exception("Model doesn't have view");
        }

        $sql = "SELECT * FROM " . $this->getViewName() . " WHERE 1=1 ";

        $primaryKey = $this->getPrimaryKeyFields();
        $idObject = $this->id();

        if (!is_array($primaryKey)) {
            if (!is_array($idObject)) {
                $sql .= "AND " . $primaryKey ." = :" . $primaryKey;
                $idObject = array($primaryKey => $idObject);
            } else {
                throw new Exception("Invalid object Id array");
            }
        } else {
            if ($this->checkPrimaryKey($idObject)) {
                foreach ($idObject as $key => $val) {
                    $sql .= "AND " . $key . " = :" . $key . " ";
                }
            } else {
                throw new Exception("Invalid object Id array");
            }
        }

        $this->exchangeArray(self::$_db->query($sql, $idObject)[0]);
        return isset($objects)? $objects : null;

    }

}