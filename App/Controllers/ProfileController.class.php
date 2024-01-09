<?php

namespace app\controllers;

use app\Models\PostModel;
use app\Views\TemplateLoader;

/**
 * Controller for handling profile page
 * @author Václav Škopek
 */
class ProfileController implements IController
{
    /**
     * @var PostModel Post model instance
     */
    private PostModel $postModel;

    /**
     * Initializes post model instance
     */
    public function __construct()
    {
        $this->postModel=PostModel::getPostModel();
    }


    public function show(array $pageInfo, array $uriParams): void
    {
        $templateLoader = new TemplateLoader();

        $posts = $this->postModel->getPostsFromLoggedUser();

        $templateLoader->printOutput(
            array(
            "title" => $pageInfo["title"],
            "posts" => $this->postModel->translateToTemplatePosts($posts)
            ),
            $pageInfo["template"]
        );
    }
}