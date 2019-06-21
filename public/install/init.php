<?php

error_reporting(0);

date_default_timezone_set("UTC"); 

define("ROOTPATH", dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR);
define('PUBLICPATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
define('INSTALLPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

$ssl = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] && $_SERVER["HTTPS"] != "off" 
     ? true : false;
define("SSL_ENABLED", $ssl);

$app_url = (SSL_ENABLED ? "https" : "http")
         . "://"
         . $_SERVER["SERVER_NAME"]
         . (dirname($_SERVER["SCRIPT_NAME"]) == DIRECTORY_SEPARATOR ? "" : "/")
         . trim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"])), "/");

$p = strrpos($app_url, "/install");
if ($p !== false) {
    $app_url = substr_replace($app_url, "", $p, strlen("/install"));
}

define("APPURL", $app_url);

require_once INSTALLPATH."app/helpers/common.helper.php";
require_once INSTALLPATH."app/core/Autoloader.php";

$loader = new Autoloader;
$loader->register();
$loader->addBaseDir(INSTALLPATH.'app/core');