<?php

namespace app\controllers;

use app\Views\TemplateLoader;

class HomeController implements IController
{

    public function show(array $pageInfo)
    {
        $templateLoader = new TemplateLoader();

        $templateLoader->printOutput(array("title" => $pageInfo["title"]), $pageInfo["template"]);
    }
}