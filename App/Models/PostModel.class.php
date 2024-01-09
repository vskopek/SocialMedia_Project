<?php

namespace app\Models;

/**
 * Post model that handles creating and commenting posts
 * Gives access to post data and editing / deleting posts
 * Singleton class
 * @author Václav Škopek
 */
class PostModel
{
    /**
     * @var PostModel|null Post model instance
     */
    private static ?PostModel $postModel = null;

    /**
     * @var UserModel User model instance
     */
    private UserModel $userModel;
    /**
     * @var DatabaseModel Database model instance
     */
    private DatabaseModel $db;


    /**
     * Initializes user model and database model instances
     */
    public function __construct()
    {
        $this->userModel=UserModel::getUserModel();
        $this->db=DatabaseModel::getDatabase();
    }

    /**
     * Singleton method to return post model instance
     * @return PostModel Post model instance
     */
    public static function getPostModel(): PostModel
    {
        if(self::$postModel==null){
            self::$postModel = new PostModel();
        }

        return self::$postModel;
    }

    /**
     * Checks if data contains info about creating post
     * Creates post data if given info and saves it to database
     * gives back id of the post
     * @param $data $_POST data containing info about the submitted form
     * @return int|null post id | null if no data
     */
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

    /**
     * Returns all posts from database
     * @return bool|array array with posts
     */
    public function getAllPosts(): bool|array
    {
        $statement = "SELECT * FROM article";

        return $this->db->prepareAndExecuteStatement($statement, array());

    }

    /**
     * Returns posts bound to currently logged user with his user id
     * @return bool|array Posts bound to logged user
     */
    public function getPostsFromLoggedUser(): bool|array
    {
        $userId = $this->userModel->getUserId();
        $statement = "SELECT * FROM article WHERE id_user=:id_user";

        return $this->db->prepareAndExecuteStatement($statement, array("id_user" => $userId));
    }

    /**
     * Retrieves post from database by its ID
     * @param int $articleID ID of post
     * @return array|null post data | null if ID isn't bound to post
     */
    public function getPostByID(int $articleID): array | null
    {
        $statement = "SELECT * FROM article WHERE id_article=:id_article";

        $result = $this->db->prepareAndExecuteStatement($statement, array("id_article" => $articleID));

        if(count($result) > 0){
            return $result[0];
        }else{
            return null;
        }
    }

    /**
     * Transforms post data from database into readable data for templates
     * @param array $post Post data from database
     * @param array $authorData Author data from database
     * @return array Template data
     */
    private function transformDataIntoTemplateData(array $post, array $authorData): array
    {
        $newPostData = array();
        $newPostData["id_article"] = $post["id_article"];
        $newPostData["id_comment"] = $post["id_comment"] ?? null;
        $newPostData["content"] = $post["content"];
        $newPostData["author_name"] = sprintf("%s %s", $authorData["firstname"],$authorData["lastname"]);
        $newPostData["author_username"] = sprintf("@%s", $authorData["username"]);
        $newPostData["author_profile_picture"] = str_replace(SITE_ROOT, "", $authorData["profile_picture"]);

        return  $newPostData;
    }

    /**
     * Translates one post from database into readable data for templates
     * @param array $post Post data from database
     * @return array|null Template data | null if there's no author bound to the post
     */
    public function translateToTemplatePost(array $post): array|null{
        $authorData = $this->userModel->getUserData($post["id_user"]);

        if($authorData != null){
            return $this->transformDataIntoTemplateData($post, $authorData);
        }

        return null;
    }

    /**
     * Translates array of posts from database into readable data for templates
     * @param array $posts Array of post data from database
     * @return array Array of transformed post data
     */
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

    /**
     * Checks if there's info about commenting post
     * and creates comment data which saves into database
     * gives back ID of the comment
     * @param string $articleId ID of post to be commented
     * @param array $data Data from submitted form
     * @return string|null ID of comment | null if there's no data
     */
    public function commentPost(string $articleId, array $data): string|null
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

    /**
     * Removes all comments and articles bound to article id from $_POST on delete query
     * @param array $data $_POST from delete query
     * @return array|null
     */
    public function deletePost(array $data): array|null
    {
        if(isset($data["delete-post"]) && !empty($data["id"])) {
            $statement = "DELETE FROM comment WHERE id_article=:id_article;
                          DELETE FROM article WHERE id_article=:id_article;";
            return $this->db->prepareAndExecuteStatement($statement, array("id_article" => $data["id"]));
        }
        return null;
    }

    /**
     * Removes comment bound to comment ID from $_POST on delete query
     * @param array $data $_POST from delete query
     * @return array|null
     */
    public function deleteComment(array $data): array|null
    {
        if(isset($data["delete-comment"]) && !empty($data["id"])) {
            $statement = "DELETE FROM comment WHERE id_comment=:id_comment";
            return $this->db->prepareAndExecuteStatement($statement, array("id_comment" => $data["id"]));
        }
        return null;
    }

    /**
     * Gives back array of comments from database bound to article ID
     * @param string $articleId Article ID
     * @return array Array of comments
     */
    public function returnPostComments(string $articleId): array
    {
        $statement = "SELECT * FROM comment WHERE id_article=:id_article";

        return $this->db->prepareAndExecuteStatement($statement, array("id_article" => $articleId));
    }
}