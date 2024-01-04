<?php

namespace app\controllers;

interface IController
{
    public function show(array $pageInfo, array $uriParams): void;
}