<?php
defined('BASEPATH') or exit('No direct script access allowed');

$hook['pre_controller'][] = array(
    'function' => 'middleware',
    'filename' => 'Middleware.php',
    'filepath' => 'hooks',
);

$hook['pre_system'][] = array(
    'class' => 'ErrorHandler',
    'function' => 'run',
    'filename' => 'ErrorHandler.php',
    'filepath' => 'hooks',
    'params' => array(),
);
