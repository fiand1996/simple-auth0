<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = "development";
$query_builder = true;

$db['development'] = array(
    'dsn' => '',
    'hostname' => '',
    'username' => '',
    'password' => '',
    'database' => '',
    'dbdriver' => '',
    'dbprefix' => '',
    'pconnect' => false,
    'db_debug' => true,
    'cache_on' => false,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => false,
    'compress' => false,
    'stricton' => false,
    'failover' => array(),
    'save_queries' => true,
);