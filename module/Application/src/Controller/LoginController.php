<?php

namespace Application\Controller;

use Core\Mvc\BaseController;
use Core\App;
use Exception;


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

        $this->setBlank();
        $this->setTitle('Zaloguj się');
    }


    /**
     * Log user into application
     */
    public function loginAction()
    {
        $this->noRender();

        try {
            if (!$this->input->post('login') || !$this->input->post('password')) {
                throw new Exception('Brak danych logowania');
            }

            if (App::$user->login($this->input->post('login'), $this->input->post('password'))) {
                $this->success('Cześć ' . App::$user . '! Zostałeś poprawnie zalogowany do systemu');
                return $this->_redirect('/');
            } else {
                throw new Exception('Niepoprawne dane logowania');
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
            $this->back();
        } 
    }


    /**
     * Logout
     */
    public function logoutAction()
    {
        $this->noRender();
        session_destroy();
        return $this->_redirect('/application/login/index');
    }


    /**
     * Signup page
     */
    public function signupAction()
    {
        if (App::$user->isLogged()) {
            $this->info('Jesteś już zalogowany!');
            $this->_redirect('/application/index/index');
        }

        $this->setBlank();
        $this->setTitle('Rejestracja');

    }
}

