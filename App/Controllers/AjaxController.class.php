<?php

namespace app\controllers;

use app\Views\TemplateLoader;

class AjaxController implements IController
{


    public function show(array $pageInfo, array $uriParams): void
    {
        require_once ($pageInfo["ajax_file"]);
    }
}