<?php

use app\controllers\AjaxController;
use app\controllers\CommentController;
use app\controllers\ErrorController;
use app\controllers\HomeController;
use app\controllers\ProfileController;
use app\controllers\SignupController;
use app\controllers\UsersController;
use app\Views\TemplateLoader;

/**
 * MySQL server that will be initialized with PDO
 */
const MYSQL_SERVER = "localhost";
/**
 * MySQL database table that will be used
 */
const MYSQL_DB = "vskopek_test";
/**
 * MySQL's user username that will be connected with
 */
const MYSQL_USERNAME = "root";
/**
 * MySQL's user password that's bound to username
 */
const MYSQL_PASSWORD = "root";

/**
 * Root directory of the server application is running on
 */
const SITE_ROOT = __DIR__;

/**
 * Info about pages
 */
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
        "controller_class" => AjaxController::class,
        "ajax_file" => "app\\ajax\\role.php"
    ),
    "404" => array(
        "title" => "Error 404",

        "controller_class" => ErrorController::class,
        "template" => TemplateLoader::ERROR_PAGE
    )
);
