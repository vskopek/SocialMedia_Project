<?php

namespace app\controllers;

/**
 * Controller for ajax implementation
 * @author Václav Škopek
 */
class AjaxController implements IController
{
    public function show(array $pageInfo, array $uriParams): void
    {
        require_once ($pageInfo["ajax_file"]);
    }
}