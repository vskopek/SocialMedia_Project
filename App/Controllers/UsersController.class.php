<?php

namespace app\controllers;

use app\Models\PostModel;
use app\Models\UserModel;
use app\Views\TemplateLoader;

/**
 * Controller for handling users editing page and checking for user edit query
 */
class UsersController implements IController
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
        $templateLoader = new TemplateLoader();

        if(isset($uriParams[1])){
            if(isset($_POST["role"]) && isset($_POST["edit-role"])) {
                $this->userModel->updateUserRole($uriParams[1], $this->userModel::roleToNumber($_POST["role"]));
                header("Location: /users");
            }
            if(isset($_POST["delete-user"])){
                $this->userModel->deleteUser($uriParams[1]);
                header("Location: /users");
            }
        }


        $templateLoader->printOutput(
            array(
                "title" => $pageInfo["title"],
                "users" => $this->userModel->getAllUsers()
            ),
            $pageInfo["template"]
        );
    }
}