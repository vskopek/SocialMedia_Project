<?php

namespace app\Models;

class PostModel
{
    private static ?PostModel $postModel = null;

    private UserModel $userModel;
    private DatabaseModel $db;



    public function __construct()
    {
        $this->userModel=UserModel::getUserModel();
        $this->db=DatabaseModel::getDatabase();
    }

    public static function getPostModel(): ?PostModel
    {
        if(self::$postModel==null){
            self::$postModel = new PostModel();
        }

        return self::$postModel;
    }

    public function createPost($data): null|int
    {
        if(!empty($data["createpost"]) && !empty($data["postcontent"])) {
            if ($this->userModel->isUserLogged()) {
                $userData = $this->userModel->getCurrentUserData();

                if ($userData["role"] > UserModel::COMMENTER) {
                    $statement = "INSERT INTO article (content, id_user) VALUES (:content, :id_user)";
                    $this->db->prepareAndExecuteStatement($statement, array(
                        "content"=>$data["postcontent"],
                        "id_user"=>$userData["id_user"]
                    ));

                    return $this->db->returnLastInsertID();
                }
            }
        }

        return null;
    }

    public function getAllPosts(): bool|array
    {
        $statement = "SELECT * FROM article";

        return $this->db->prepareAndExecuteStatement($statement, array());

    }

    public function getPostsFromUser(int $userId): bool|array
    {
        $statement = "SELECT * FROM article WHERE id_user=:id_user";

        return $this->db->prepareAndExecuteStatement($statement, array("id_user" => $userId));
    }

    public function getPostByID(int $articleID){
        $statement = "SELECT * FROM article WHERE id_article=:id_article";

        $result = $this->db->prepareAndExecuteStatement($statement, array("id_article" => $articleID));

        if(count($result) > 0){
            return $result[0];
        }else{
            return null;
        }
    }

    private function transformDataIntoTemplateData($post, $authorData): array
    {
        $newPostData = array();
        $newPostData["id_article"] = $post["id_article"];
        $newPostData["content"] = $post["content"];
        $newPostData["author_name"] = sprintf("%s %s", $authorData["firstname"],$authorData["lastname"]);
        $newPostData["author_username"] = sprintf("@%s", $authorData["username"]);


        return  $newPostData;
    }

    public function translateToTemplatePost(array $post): array|null{
        $authorData = $this->userModel->getUserData($post["id_user"]);

        if($authorData != null){
            return $this->transformDataIntoTemplateData($post, $authorData);
        }

        return null;
    }

    public function translateToTemplatePosts(array $posts): array
    {
        $translatedPosts = array();

        foreach ($posts as $post){
            $authorData = $this->userModel->getUserData($post["id_user"]);

            if($authorData != null){
                $translatedPosts[] = $this->transformDataIntoTemplateData($post, $authorData);
            }
        }

        return array_reverse($translatedPosts);
    }

    public function commentPost($articleId, $data): bool|string|null
    {
        if(!empty($data["comment-post"]) && !empty($data["comment-content"])) {
            if ($this->userModel->isUserLogged()) {
                $userData = $this->userModel->getCurrentUserData();

                if ($userData["role"] >= UserModel::COMMENTER) {
                    $statement = "INSERT INTO comment (content, id_article, id_user) VALUES (:content, :id_article, :id_user)";
                    $this->db->prepareAndExecuteStatement($statement, array(
                        "content"=>$data["comment-content"],
                        "id_user"=>$userData["id_user"],
                        "id_article"=>$articleId
                    ));

                    return $this->db->returnLastInsertID();
                }
            }
        }

        return null;
    }

    public function returnPostComments($articleId): bool|array
    {
        $statement = "SELECT * FROM comment WHERE id_article=:id_article";

        return $this->db->prepareAndExecuteStatement($statement, array("id_article" => $articleId));
    }
}