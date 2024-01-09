<?php

namespace app\controllers;

use app\Models\PostModel;
use app\Views\TemplateLoader;

/**
 * Controller for comment page
 * @author Václav Škopek
 */
class CommentController implements IController
{
    /**
     * @var PostModel Post model instance
     */
    private PostModel $postModel;

    /**
     * Initializes post model instance
     */
    public function __construct(){
        $this->postModel=PostModel::getPostModel();
    }

    public function show(array $pageInfo, array $uriParams): void
    {
        $templateLoader = new TemplateLoader();

        if(!isset($uriParams[1]))
            header('Location: /error');

        $articleId = $uriParams[1];
        $post = $this->postModel->getPostByID($articleId);

        $result = $this->postModel->commentPost($articleId, $_POST);

        if($this->postModel->deleteComment($_POST) != null){
            header('Location: /');
        }

        if($result != null){
            header('Location: /comments/'.$articleId);
        }

        if($post == null){
            header('Location: /error');
        }

        $comments = $this->postModel->returnPostComments($articleId);

        $templateLoader->printOutput(
            array(
                "title" => $pageInfo["title"],
                "post" => $this->postModel->translateToTemplatePost($post),
                "comments" => $this->postModel->translateToTemplatePosts($comments)
            ),
            $pageInfo["template"]
        );
    }
}