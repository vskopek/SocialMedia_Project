<?php

use app\controllers\CommentController;
use app\controllers\ErrorController;
use app\controllers\HomeController;
use app\controllers\ProfileController;
use app\controllers\SignupController;
use app\controllers\UsersController;
use app\Views\TemplateLoader;

const MYSQL_SERVER = "localhost";
const MYSQL_DB = "test";
const MYSQL_USERNAME = "root";
const MYSQL_PASSWORD = "root";


const PAGES = array(
    "home" => array(
        "title" => "Home",

        "controller_class" => HomeController::class,
        "template" => TemplateLoader::HOME_PAGE
    ),
    "signup" => array(
        "title" => "Signup",

        "controller_class" => SignupController::class,
        "template" => TemplateLoader::SIGNUP_PAGE
    ),
    "profile" => array(
        "title" => "Profile",

        "controller_class" => ProfileController::class,
        "template" => TemplateLoader::PROFILE_PAGE
    ),
    "comments" => array(
        "title" => "Comments",

        "controller_class" => CommentController::class,
        "template" => TemplateLoader::COMMENTS_PAGE
    ),
    "users" => array(
        "title" => "Users",

        "controller_class" => UsersController::class,
        "template" => TemplateLoader::USERS_PAGE
    ),
    "role_ajax" => array(
        "title" => "",
        "controller_class" =>\app\controllers\AjaxController::class,
        "ajax_file" => "app\\role_ajax.php"
    ),
    "404" => array(
        "title" => "Error 404",

        "controller_class" => ErrorController::class,
        "template" => TemplateLoader::ERROR_PAGE
    )
);
