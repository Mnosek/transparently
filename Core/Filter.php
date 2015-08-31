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


    /**
     * Converts string from camel case to dash
     * @param string $text
     *
     * @return string
     */
    public static function camelCaseToDash($string) 
    {

            $pattern     = array('#(?<=(?:[A-Z]))([A-Z]+)([A-Z][A-z])#', '#(?<=(?:[a-z0-9]))([A-Z])#');
            $replacement = array('\1' . '-' . '\2', '-' . '\1');

        return strtolower(preg_replace($pattern, $replacement, $string));
    }




    
    
}