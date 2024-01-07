<?php

namespace app;

use app\controllers\IController;

/**
 *
 */
class Application {

    /**
     * @param $uri
     * @return array
     */
    private function splitURI($uri): array{
        $uri = strtolower(str_replace("/"," ", $uri));

        return explode(" ", $uri);
    }

    /**
     * @param $page
     * @return void
     */
    public function loadApplication($page): void
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