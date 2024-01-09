<?php


/**
 * Root namespace for application
 */
const DEFAULT_NAMESPACE_BASE = "app";
/**
 * Root directory for application
 */
const DEFAULT_DIRECTORY_NAME = "App";

/**
 * Allowed file extensions that will be loaded upon requesting
 */
const ALLOWED_FILE_EXTENSIONS = array(
    ".class.php",
    ".tpl.php",
    ".interface.php"
);

/**
 * Autoload function that's passed to autoload_register
 * Searches for the requested file and requires it once
 * @param string $className Name of file
 * @return void
 */
function autoloadClass(string $className): void
{
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