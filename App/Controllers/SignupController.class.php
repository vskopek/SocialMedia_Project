<?php

namespace app\controllers;

use app\Models\UserModel;
use app\Views\TemplateLoader;

class SignupController implements IController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = UserModel::getUserModel();
    }


    public function show(array $pageInfo, array $uriParams): void
    {
        $this->userModel->checkForRegister($_POST);

        if(!empty($_POST["logout"])) {
            $this->userModel->userLogout();
        }

        $templateLoader = new TemplateLoader();

        $templateLoader->printOutput(array("title" => $pageInfo["title"], "userLogged"=>$this->userModel->isUserLogged()), $pageInfo["template"]);
    }
}