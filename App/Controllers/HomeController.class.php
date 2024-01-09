<?php

namespace app\controllers;

use app\Models\PostModel;
use app\Models\UserModel;
use app\Views\TemplateLoader;

/**
 * Controller for handling home page and checking for login/register and posting
 * @author Václav Škopek
 */
class HomeController implements IController
{
    /**
     * @var UserModel User model instance
     */
    private UserModel $userModel;
    /**
     * @var PostModel Post model instance
     */
    private PostModel $postModel;

    /**
     * Initializes user and post model instances
     */
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

        if($this->postModel->deletePost($_POST) != null){
            header('Location: /');
        }

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