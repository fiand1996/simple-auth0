<?php

define('ENVIRONMENT', 'installation');

switch (ENVIRONMENT) {
    case 'installation':
        header("Location: ./install");
        exit(0);
        break;
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', 1);
    break;
    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        if (version_compare(PHP_VERSION, '5.3', '>=')) {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        } else {
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        }
    break;

    default:
        header('HTTP/1.1 503 Service Unavailable.', true, 503);
        echo 'The application environment is not set correctly.';
        exit(1);
}

    $system_path = '../system';
    
    $application_folder = '../application';

    $view_folder = '';

    if (defined('STDIN')) {
        chdir(dirname(__FILE__));
    }

    if (($_temp = realpath($system_path)) !== false) {
        $system_path = $_temp.DIRECTORY_SEPARATOR;
    } else {
        $system_path = strtr(
            rtrim($system_path, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
        ).DIRECTORY_SEPARATOR;
    }

    if (! is_dir($system_path)) {
        header('HTTP/1.1 503 Service Unavailable.', true, 503);
        echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
        exit(3);
    }

    define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

    define('BASEPATH', $system_path);

    define('FCPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

    define('SYSDIR', basename(BASEPATH));

    if (is_dir($application_folder)) {
        if (($_temp = realpath($application_folder)) !== false) {
            $application_folder = $_temp;
        } else {
            $application_folder = strtr(
                rtrim($application_folder, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
            );
        }
    } elseif (is_dir(BASEPATH.$application_folder.DIRECTORY_SEPARATOR)) {
        $application_folder = BASEPATH.strtr(
            trim($application_folder, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
        );
    } else {
        header('HTTP/1.1 503 Service Unavailable.', true, 503);
        echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
        exit(3);
    }

    define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);

    if (! isset($view_folder[0]) && is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR)) {
        $view_folder = APPPATH.'views';
    } elseif (is_dir($view_folder)) {
        if (($_temp = realpath($view_folder)) !== false) {
            $view_folder = $_temp;
        } else {
            $view_folder = strtr(
                rtrim($view_folder, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
            );
        }
    } elseif (is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR)) {
        $view_folder = APPPATH.strtr(
            trim($view_folder, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
        );
    } else {
        header('HTTP/1.1 503 Service Unavailable.', true, 503);
        echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
        exit(3);
    }

    $ssl = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] && $_SERVER["HTTPS"] != "off" 
        ? true 
        : false;
    define("SSL_ENABLED", $ssl);

    $app_url = (SSL_ENABLED ? "https" : "http")
            . "://"
            . $_SERVER["SERVER_NAME"]
            . (dirname($_SERVER["SCRIPT_NAME"]) == DIRECTORY_SEPARATOR ? "" : "/")
            . trim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"])), "/");
    define("APPURL", $app_url);
    
    define('VIEWPATH', $view_folder.DIRECTORY_SEPARATOR);

    define("APP_VERSION", "1.0");

    date_default_timezone_set('Asia/Jakarta');
    
require_once BASEPATH.'core/CodeIgniter.php';
