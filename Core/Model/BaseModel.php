<?php

namespace Core\Model;

use Core\App;
use ArrayObject;


/**
 * Base application model. All models except core should extends it.
 * @author Michał Nosek <mmnosek@gmail.com>
 */
abstract class BaseModel extends ArrayObject
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