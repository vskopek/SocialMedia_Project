<?php

namespace app\controllers;

use app\Models\DatabaseModel;
use app\Models\UserModel;
use app\Views\TemplateLoader;

class HomeController implements IController
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
        $loggedIn = false;
        $wrongCredentials = false;
        if (!empty($_POST["login"])){
            $loggedIn = $this->userModel->checkForLogin($_POST);
            $wrongCredentials = !$loggedIn;
        }

        $templateLoader = new TemplateLoader();

        $templateLoader->printOutput(
            array(
                "title" => $pageInfo["title"],
                "loggedIn"=>$loggedIn,
                "wrongCredentials"=>$wrongCredentials
            )
            , $pageInfo["template"]);
    }
}