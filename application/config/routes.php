<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'site/home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['signup'] = 'auth/signup';
$route['signin'] = 'auth/signin';
$route['signout'] = 'auth/signout';
$route['forgot'] = 'auth/forgot';
$route['oauth']['post'] = 'auth/oauth/index';
$route['reset/(:any)'] = 'auth/reset/index/$1';
$route['activation/(:any)'] = 'auth/activation/index/$1';

$route['privacy-policy'] = 'site/privacy_policy';
$route['terms-services'] = 'site/terms_services';

$route['expired'] = 'app/expired';
$route['dashboard'] = 'app/dashboard';
$route['profile'] = 'app/profile';
$route['users'] = 'app/users';
$route['users/new'] = 'app/users/add';
$route['users/(:num)'] = 'app/users/update/$1';
$route['settings'] = 'app/settings';
$route['settings/email'] = 'app/settings/email';
$route['settings/recaptcha'] = 'app/settings/recaptcha';
$route['settings/social-login'] = 'app/settings/social_login';
$route['settings/db-backup'] = 'app/settings/db_backup';

