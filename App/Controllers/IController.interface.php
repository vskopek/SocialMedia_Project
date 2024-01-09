<?php

namespace app\controllers;

interface IController
{
    /**
     * Obtains data from models and passes it into view
     * renders the view
     * @param array $pageInfo Info about the page
     * @param array $uriParams Parameters from URL
     * @return void
     */
    public function show(array $pageInfo, array $uriParams): void;
}