<?php

namespace Core\Http;


/**
 * HTTP Response model
 * @author Michał Nosek <mmnosek@gmail.com>
 */
class Response
{
    /**
     * Allowed HTTP codes
     * @var int[]
     */
    private static $_allowedHttp = array(
        200,
        500
    );


    /**
     * Response http code
     * @var int
     */
    private $_httpCode;


    /**
     * Headers array
     * @var string[]
     */
    private $_headers = array();


    /**
     * Rendered response body
     * @var string
     */
    private $_content;


    /**
     * Sets http response code
     * @param integer $httpCode http code (from allowed list)
     */
    public function setCode($httpCode = 200)
    {
        if (!in_array($httpCode, self::$_allowedHttp)) {
            $this->_httpCode = 500;
        }
    }   


    /**
     * Returns response http code
     * @return int
     */
    public function getCode()
    {
        return $this->_httpCode;
    }


    /**
     * Sets response content
     * @param string $content
     */
    public function setContent($content) {
        $this->_content = $content;
    }


    /**
     * Returns rendered content
     * @return string
     */
    public function getContent()
    {   
        return $this->_content;
    }


    /**
     * Sets header
     * @param string $key
     * @param string $value
     */
    public function setHeader($key, $value)
    {
        $this->_headers[$key] = new Header($key, $value);
    }


    /**
     * Returns HTTP headers
     * @return \Core\Http\Header[]
     */
    public function getHeaders()
    {
        return $this->_headers;
    }

}