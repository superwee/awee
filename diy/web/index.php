<?php
define('APP_ROOT',$_SERVER['DOCUMENT_ROOT']);
define('BASE_ROOT',APP_ROOT.'/../');

require_once BASE_ROOT.'common/common.php';

// set_error_handler('my_error_handler');

$is_url = check_url_is_exist();

if(!$is_url){
	trigger_error("Not found the router",E_USER_ERROR);
	die;
}
