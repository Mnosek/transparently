<?php

namespace Core\Http;

/**
 * Http header model
 * @author Michał Nosek <mmnosek@gmail.com>
 */
class Header
{
    /**
     * Header constructor
     * @param string $key
     * @param string $value
     */
    public function __construct($key, $value)
    {
        $this->_key   = $key;
        $this->_value = $value;
    }


    /**
     * Returns prepared HTTP header string
     * @return string
     */
    public function __toString()
    {
        return $this->_key . ': ' . $this->_value;
    }
}