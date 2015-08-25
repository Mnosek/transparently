<?php

namespace Core\Http;

use Core\View\Html;


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
            throw new \RuntimeException('Invalid HTTP Code');
        }

        $this->_httpCode = $httpCode;
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


    /**
     * Sets fatal error view
     * @param \Exception $e
     */
    public function setFatalError(\Exception $e)
    {
        $this->setHeader('Content-Type', 'text/html; charset=utf-8');
        $view = new Html($this->_getErrorTemplate());
        $view->bindData(array('e' => $e));
        $this->setContent($view->render(true));
        $this->setCode(500);

        return $this;
    }


    /**
     * Returns error template path
     * @return string
     */
    private function _getErrorTemplate()
    {
        return MODULE_PATH . DIRECTORY_SEPARATOR . 'Application' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'element' . DIRECTORY_SEPARATOR . 'fatal-error.php';
    }

}