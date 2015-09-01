<?php

namespace People\Controller;


use Core\Mvc\BaseController;
use User\User;
use Core\App;
use People\Friend;


class FriendController extends BaseController
{
    public function listAction()
    {
        $this->setTitle('Znajomi');
    }


    public function listPaneAction()
    {
        $this->setBlank();
        $user = App::$user->getUser();  
        
        $this->attach('friends', $user->getFriends());
    }



    public function searchAction()
    {
        $this->setBlank();

        if (!$this->input->post('email')) {
            echo 'Brak adresu email';
            return;
        }

        $this->attach('users', User::find(array('email' => $this->input->post('email'))));
    }


    public function addAction()
    {
        $this->noRender();
        
        $params = array(
            'user_id' => App::$user->user_id,
            'friend_user_id' => $this->input->post('user_id')
        );

        $friend = new Friend($params);
        $friend->insert();

        return;
    }
}