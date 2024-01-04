<?php

namespace app\controllers;

use app\Models\PostModel;
use app\Views\TemplateLoader;

class ProfileController implements IController
{
    private PostModel $postModel;

    public function __construct()
    {
        $this->postModel=PostModel::getPostModel();
    }


    public function show(array $pageInfo, array $uriParams): void
    {
        $templateLoader = new TemplateLoader();

        $posts = $this->postModel->getAllPosts();

        $templateLoader->printOutput(
            array(
            "title" => $pageInfo["title"],
            "posts" => $this->postModel->translateToTemplatePosts($posts)
            ),
            $pageInfo["template"]
        );
    }
}