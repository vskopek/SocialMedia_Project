<?php

namespace app;

use app\controllers\IController;

/**
 * Application boot class
 * @author Václav Škopek
 */
class Application {

    /**
     * Splits URl into parameters
     * ex. /home/id/501/profile => array("home", "id", 501, "profile)
     * @param string $uri URL to be split from
     * @return array URL parameters
     */
    private function splitURI(string $uri): array{
        $uri = strtolower(str_replace("/"," ", $uri));

        return explode(" ", $uri);
    }

    /**
     * Loads the page based on URL
     * gets controller of the page which takes care
     * of building the page from models to view
     * @param array $page Page info
     * @return void
     */
    public function loadApplication(array $page): void
    {
        if(isset($page["params"])){
            $uriParams = $this->splitURI($page["params"]);
        }else{
            $uriParams = array("home");
        }

        if(!key_exists($uriParams[0], PAGES)){
            $uriParams[0] = "404";
        }

        $pageInfo = PAGES[$uriParams[0]];

        /** @var IController $controller */
        $controller = new $pageInfo["controller_class"];

        $controller->show($pageInfo, $uriParams);
    }

}