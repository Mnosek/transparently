<?php

namespace Application\Controller;

use Core\Mvc\BaseController;
use Core\App;
use Core\App\User as AppUser;
use User\User;
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


    public function createUserAction()
    {
        $this->noRender();

        $data = $this->input->post();
        
        try {
            if (!$data['name'] || !$data['last_name'] || !$data['email'] || ($data['password'] != $data['password_repeat'])) {
                throw new Exception('Podane hasła są różne');
            }

            unset($data['password_repeat']);
            $password = $data['password'];
            $data['password'] = AppUser::getPasswordHash($password, $data['email']);
            
            $user = new User($data);
            $user->insert();

            $this->success('Dziękujemy za rejestrację, możesz się zalogować.');


        } catch (Exception $e) {
            if ($e->getCode() == 23000) {
                $this->error('Użytkownik o podanym adresie email istnieje już w systemie');
            } else {
                $this->error($e->getMessage());
            }
        } finally {
            return $this->_redirect('/application/login/index');
        }
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

