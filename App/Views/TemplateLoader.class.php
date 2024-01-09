<?php

namespace app\Views;

use app\Models\UserModel;

/**
 * Template loader class that takes care of building page
 * for controllers to render.
 * Builds the page from Header, Content and Footer.
 * @author Václav Škopek
 */
class TemplateLoader
{
    /**
     * @var UserModel User model instance
     */
    private UserModel $userModel;

    /**
     * Page header path
     */
    const PAGE_HEADER = "PageHeader.tpl.php";
    /**
     * Page footer path
     */
    const PAGE_FOOTER = "PageFooter.tpl.php";

    /**
     * Home template path
     */
    const HOME_PAGE = "Home.tpl.php";
    /**
     * Error template path
     */
    const ERROR_PAGE = "Error.tpl.php";
    /**
     * Signup template path
     */
    const SIGNUP_PAGE = "Signup.tpl.php";
    /**
     * Profile template path
     */
    const PROFILE_PAGE = "Profile.tpl.php";
    /**
     * Comments template path
     */
    const COMMENTS_PAGE = "Comments.tpl.php";
    /**
     * Users template path
     */
    const USERS_PAGE = "Users.tpl.php";

    /**
     * Initializes user model instance
     */
    public function __construct()
    {
        $this->userModel = UserModel::getUserModel();
    }


    /**
     * Builds the page from Header and Footer
     * inserts template between them based on query
     * @param array $data Data to pass into the template
     * @param string $page Template
     * @return void
     */
    public function printOutput(array $data, string $page): void
    {
        $loggedUserData = $this->userModel->getCurrentUserData();
        global $templateData;
        $templateData = array_merge($data, array(
            "user_data"=> $loggedUserData != null ? $loggedUserData : null
        ));

        require_once(self::PAGE_HEADER);

        require_once($page);

        require_once(self::PAGE_FOOTER);
    }
}