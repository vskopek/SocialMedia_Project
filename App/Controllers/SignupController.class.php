<?php

namespace app\controllers;

use app\Models\UserModel;
use app\Views\TemplateLoader;

/**
 * Controller for handling signup page
 */
class SignupController implements IController
{
    /**
     * @var UserModel User model instance
     */
    private UserModel $userModel;

    /**
     * Initializes user model instance
     */
    public function __construct()
    {
        $this->userModel = UserModel::getUserModel();
    }


    public function show(array $pageInfo, array $uriParams): void
    {
        $res = $this->userModel->checkForRegister($_POST);

        if($res){
            header("Location: /");
        }

        if(!empty($_POST["logout"])) {
            $this->userModel->userLogout();
        }

        $templateLoader = new TemplateLoader();

        $templateLoader->printOutput(array("title" => $pageInfo["title"], "userLogged"=>$this->userModel->isUserLogged()), $pageInfo["template"]);
    }
}