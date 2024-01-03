<?php

namespace app\controllers;

use app\Models\DatabaseModel;
use app\Models\UserModel;
use app\Views\TemplateLoader;

class SignupController implements IController
{
    private $db;
    private $userModel;

    public function __construct()
    {
        $this->db = DatabaseModel::getDatabase();
        $this->userModel = UserModel::getUserModel();
    }


    public function show(array $pageInfo)
    {
        $this->userModel->checkForRegister($_POST);

        if(!empty($_POST["logout"])) {
            $this->userModel->userLogout();
        }

        $templateLoader = new TemplateLoader();

        $templateLoader->printOutput(array("title" => $pageInfo["title"], "userLogged"=>$this->userModel->isUserLogged()), $pageInfo["template"]);
    }
}