<?php

define("MYSQL_SERVER", "localhost");
define("MYSQL_DB", "test");
define("MYSQL_USERNAME", "root");
define("MYSQL_PASSWORD", "root");


const PAGES = array(
    "home" => array(
        "title" => "Home",

        "controller_class" => \app\controllers\HomeController::class,
        "model_class" => \app\Models\AModel::class,
        "template" => \app\Views\TemplateLoader::HOME_PAGE
    ),
    "signup" => array(
        "title" => "Signup",

        "controller_class" => \app\controllers\SignupController::class,
        "model_class" => \app\Models\UserModel::class,
        "template" => \app\Views\TemplateLoader::SIGNUP_PAGE
    ),
    "404" => array(
        "title" => "Error 404",

        "controller_class" => \app\controllers\ErrorController::class,
        "template" => \app\Views\TemplateLoader::ERROR_PAGE
    )
);
?>