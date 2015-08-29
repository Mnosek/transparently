<?php

namespace Application\Controller;

use Core\Mvc\BaseController;
use Core\App;


/**
 * Login controller
 * @author Michał Nosek <mmnosek@gmail.com>
 */
class LoginController extends BaseController
{
    /**
     * Sets public access
     */
    public function __construct()
    {
        $this->_isPublic = true;
        parent::__construct();
    }


    /**
     * Login page
     */
    public function indexAction()
    {
        if (App::$user->isLogged()) {
            $this->info('Jesteś już zalogowany!');
            $this->_redirect('/application/index/index');
        }
    }


    /**
     * Log user into application
     */
    public function loginAction()
    {
        $this->noRender();

        if (App::$user->isLogged()) {
            $this->info('Jesteś już zalogowany!');
            return $this->back();
        }
    }
}

