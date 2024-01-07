<?php

namespace app\controllers;

use app\Models\PostModel;
use app\Models\UserModel;
use app\Views\TemplateLoader;

class UsersController implements IController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = UserModel::getUserModel();
    }

    public function show(array $pageInfo, array $uriParams): void
    {
        $templateLoader = new TemplateLoader();

        if(isset($uriParams[1]) && isset($_POST["role"]))


        $templateLoader->printOutput(
            array(
                "title" => $pageInfo["title"],
                "users" => $this->userModel->getAllUsers()
            ),
            $pageInfo["template"]
        );
    }
}