<?php

namespace Core;

use Core\App;
use Core\Model\BaseModel;

/**
 * Flash messenger model
 */
class FlashMessenger
{

    /**
     * Available msg types
     * @var string
     */
    const SUCCESS = 'success';
    const INFO    = 'info';
    const ERROR   = 'error';


    /**
     * Singleton instance
     * @var \Core\FlashMessenger
     */
    private static $instance;


    /**
     * Flash messages
     * @var array
     */
    public $messages = array();


    /**
     * Privat constructor to force singleton
     */
    private function __construct(){}


    /**
     * Returns singleton instance
     * @return \Core\FlashMessenger
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new FlashMessenger();
        }

        return self::$instance;
    }


    /**
     * Adds message to flash msg stack
     * @param  string $message
     * @param  $type
     */
    public function setMessage($message, $type)
    {   
        $var = App::$session->messenger;
        $var[$type][] = $message;
        App::$session->messenger = $var;
    }


    /**
     * Returns messages
     * @return string[]
     */
    public function getMessages()
    {
        if (!$this->messages) {
            $this->messages = App::$session->messenger;
            App::$session->messenger = null;
        }

        return $this->messages;
    }

}