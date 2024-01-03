<?php

namespace app\Views;

use app\Models\UserModel;

class TemplateLoader
{
    private UserModel $userModel;

    const PAGE_HEADER = "PageHeader.tpl.php";
    const PAGE_FOOTER = "PageFooter.tpl.php";

    const HOME_PAGE = "Home.tpl.php";
    const ERROR_PAGE = "Error.tpl.php";
    const SIGNUP_PAGE = "Signup.tpl.php";
    const PROFILE_PAGE = "Profile.tpl.php";

    /**
     * @param UserModel $userModel
     */
    public function __construct()
    {
        $this->userModel = UserModel::getUserModel();
    }


    public function printOutput(array $data, string $page){
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