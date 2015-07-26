<?php

namespace Core;


/**
 * Filter helper
 * @author Michał Nosek <mmnosek@gmail.com>
 */
class Filter
{
    /**
     * Converts string from dash to camel case
     * @param string $text
     * @param bool $capitalizeFirst
     *
     * @return string
     */
    public static function dashToCamelCase($string, $capitalizeFirst = false) 
    {

    $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

    if (!$capitalizeFirstCharacter) {
        $str[0] = lcfirst($str[0]);
    }

    return $str;
}

    
    
}