<?php

namespace Core\Model;

use Core\App;


/**
 * Base application model. All models except core should extends it.
 * @todo
 */
abstract class BaseModel
{
    /**
     * Database handle
     * @var \Core\Db
     */
    protected static $_db;


    /**
     * Model initialization (sets db handler)
     */
    public static function init()
    {
        self::$_db = App::getDb();
    }
}