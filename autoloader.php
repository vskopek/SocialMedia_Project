<?php


const DEFAULT_NAMESPACE_BASE = "app";
const DEFAULT_DIRECTORY_NAME = "App";

const ALLOWED_FILE_EXTENSIONS = array(
    ".class.php"
);

function autoloadClass($className) {
    $className = str_replace(DEFAULT_NAMESPACE_BASE, DEFAULT_DIRECTORY_NAME, $className);
    $fileName = dirname(__FILE__) . "\\" . $className;

    foreach (ALLOWED_FILE_EXTENSIONS as $extension){
        $filePath = $fileName . $extension;
        if(file_exists($filePath)){
            $fileName = $filePath;
            break;
        }
    }

    require_once($fileName);
}

spl_autoload_register('autoloadClass');