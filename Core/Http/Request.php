<?php

namespace Core\Http;


class Request
{
    /**
     * Requested url
     * @var string
     */
    protected $_url;


    /**
     * Request constructor
     */
    public function __construct()
    {
        $this->_url = $_GET['_url'];
        unset($_GET['url']);
    }


    /**
     * Returns requested url
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    } 


    /**
     * Returns requested path array
     * @return string[]
     */
    public function getPath()
    {
        return explode('/', trim($this->_url, '/'));
    }
}