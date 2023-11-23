<?php

require_once("settings.inc.php");

require_once ("autoloader.php");

$application = new app\Application;

$application -> loadApplication($_GET);
