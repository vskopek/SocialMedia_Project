<?php

namespace app\controllers;

use app\Models\DatabaseModel;
use app\Views\TemplateLoader;

class ErrorController implements IController
{


    public function show(array $pageInfo)
    {
        $templateLoader = new TemplateLoader();

        $templateLoader->printOutput(array("title" => $pageInfo["title"]), $pageInfo["template"]);
    }
}