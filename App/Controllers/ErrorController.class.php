<?php

namespace app\controllers;

use app\Views\TemplateLoader;

class ErrorController implements IController
{


    public function show(array $pageInfo, array $uriParams): void
    {
        $templateLoader = new TemplateLoader();

        $templateLoader->printOutput(array("title" => $pageInfo["title"]), $pageInfo["template"]);
    }
}