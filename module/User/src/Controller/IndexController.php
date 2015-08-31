<?php

namespace User\Controller;


use Core\Mvc\BaseController;


class IndexController extends BaseController
{
    public function profileAction()
    {
        $this->setTitle('Twój profil');
    }


    public function saveProfileAction()
    {
        $this->noRender();
    }
}