<?php

namespace app\controllers;

use app\Models\PostModel;
use app\Models\UserModel;
use app\Views\TemplateLoader;

class HomeController implements IController
{
    private UserModel $userModel;
    private PostModel $postModel;

    public function __construct()
    {
        $this->userModel = UserModel::getUserModel();
        $this->postModel = PostModel::getPostModel();
    }


    public function show(array $pageInfo, array $uriParams): void
    {
        $loggedIn = false;
        $wrongCredentials = false;
        if (!empty($_POST["login"])){
            $loggedIn = $this->userModel->checkForLogin($_POST);
            $wrongCredentials = !$loggedIn;
        }

        $res = $this->postModel->createPost($_POST);

        if($res != null){
            header('Location: /');
        }

        $templateLoader = new TemplateLoader();

        $posts = $this->postModel->getAllPosts();

        $templateLoader->printOutput(
            array(
                "title" => $pageInfo["title"],
                "loggedIn"=>$loggedIn,
                "wrongCredentials"=>$wrongCredentials,
                "posts"=>$this->postModel->translateToTemplatePosts($posts)
            )
            , $pageInfo["template"]);
    }
}