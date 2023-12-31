<?php
require_once ("autoloader.php");
require_once("settings.inc.php");


$application = new app\Application;

$application -> loadApplication($_GET);
