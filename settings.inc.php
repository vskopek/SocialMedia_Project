<?php
const PAGES = array(
    "home" => array(
        "title" => "Home",

        "controller_class" => \app\controllers\HomeController::class,
        "model_class" => \app\Models\AModel::class,
        "template" => \app\Views\TemplateLoader::HOME_PAGE
    )
);
?>