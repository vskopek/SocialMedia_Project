<?php

namespace app;

class Application {

    private function splitURI($uri): array{
        $uri = strtolower(str_replace("/"," ", $uri));

        return explode(" ", $uri);
    }

    public function loadApplication($page){
        if(isset($page["params"])){
            $uriParams = $this->splitURI($page["params"]);
        }else{
            $uriParams = array("home");
        }

        if(!key_exists($uriParams[0], PAGES)){
            $uriParams[0] = "404";
        }

        echo "Loading page: $uriParams[0]";
    }

}