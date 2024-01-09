<?php

namespace app\controllers;

use app\Views\TemplateLoader;

/**
 * Controller for showing error page
 * @author Václav Škopek
 */
class ErrorController implements IController
{
    public function show(array $pageInfo, array $uriParams): void
    {
        $templateLoader = new TemplateLoader();

        $templateLoader->printOutput(array("title" => $pageInfo["title"]), $pageInfo["template"]);
    }
}