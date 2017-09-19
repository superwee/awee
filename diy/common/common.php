<?php
require_once BASE_ROOT.'common/config/config.php';
//检查路由是否包含该url
function check_url_is_exist () {
	require_once BASE_ROOT.'common/router/routers.php';
	$uri = $_SERVER['REQUEST_URI'];
	if(strpos($uri,'index.php')) {
		$uri = substr($uri,10);
	}
	if(strpos($uri,'asset') == 1 || strpos($uri,'favicon.ico')){
		return true;
	}
	//默认的访问路径
	if($uri == '/' || $uri == '') {
		$filename = BASE_ROOT.'controller/home/IndexController.php';
		if(file_exists($filename)) {
			require_once $filename;
			$class = new home\IndexController();
			$class->index();
			return true;
		}
	}

	$temp_uri = ltrim($uri,'/');
	if(isset($routers[$uri]) || isset($routers[$temp_uri])){
		$action_router = isset($routers[$uri]) ? $routers[$uri] : $routers[$temp_uri];	//路由对应的控制器和方法
		$path_arr = explode('/',$action_router);
		$action = array_pop($path_arr);		//方法名
		$class = array_pop($path_arr);		//类名
		if(count($path_arr) > 1){			//判断类是否在某个目录下面
			$dir = array_pop($path_arr);
		}

		//查找文件和类名
		$filename = BASE_ROOT.'controller/'.$dir.'/'.$class.'.php';
		if(file_exists($filename)) {
			require_once $filename;

			$class = new home\IndexController();
			$class->$action();
			return true;
		}
	}
	return false;
}

//错误抛出
function my_error_handler($errorno,$error,$file,$line) {
	if(error_reporting() == 0) {
		return false;
	}
	switch ($errorno) {
		case E_USER_WARNING:
			$type = 'Warning';
			break;
		case E_NOTICE: case E_USER_NOTICE:
			$type = 'Notice';
			break;
		default:
			$type = 'Fatel_Error';
			break;
	}
	$file = basename($file);
	print "$type: $error\n";
}

//加载核心文件
function loadLib () {
	require_once BASE_ROOT.'lib/core/Controller.php';
	require_once BASE_ROOT.'lib/core/Model.php';
	require_once BASE_ROOT.'common/config/config.php';
}

//加载模版引擎
function loadPlate () {
	require_once BASE_ROOT.'/lib/plates-3.2.0/src/Engine.php';
	loadPlateLib();

	$directory = BASE_ROOT.'tpl';
	$ext = 'php';
	return new League\Plates\Engine($directory,$ext);
}

//加载模版引擎所需的文件
function loadPlateLib ($filename = '') {
	static $files = array();
	if($filename == '') {
		$filename = '../lib/plates-3.2.0/src/';
	}
	
	if(is_dir($filename)){
		if($dh = opendir($filename)){
			while(false !== ($file = readdir($dh))){
				$temp_file = $filename.'/'.$file;
				if(is_dir($temp_file) && $file != '.' && $file != '..' && $file != 'Extension') {
					loadPlateLib($temp_file);
				}else{
					if(is_file($temp_file) && file_exists($temp_file) && $file != 'Engine.php'){
						require_once $temp_file;
					}
				}
			}
		}
	}
}

//加载模型文件
function loadModel ($filename = '') {
	static $files = array();
	if($filename == '') {
		$filename = BASE_ROOT.'model';
	}
	
	if(is_dir($filename)){
		if($dh = opendir($filename)){
			while(false !== ($file = readdir($dh))){
				$temp_file = $filename.'/'.$file;
				if(is_dir($temp_file) && $file != '.' && $file != '..') {
					loadPlateLib($temp_file);
				}else{
					if(is_file($temp_file) && file_exists($temp_file)){
						require_once $temp_file;
					}
				}
			}
		}
	}
}

//获取http参数
function post($key = '',$default = '') {
	if($key){
		if(isset($_POST[$key])) {
			return htmlspecialchars(strip_tags($_POST[$key]));
		}else{
			if($default) {
				return $default;
			}
			return false;
		}
	}else{
		return $_POST;
	}
}

function get($key = '',$default = '') {
	if($key) {
		if(isset($_GET[$key])) {
			return htmlspecialchars(strip_tags($_GET[$key]));
		}else{
			if($default) {
				return $default;
			}
			return false;
		}
	}else{
		return $_GET;
	}
}

// //自动加载类方法 由于改了命名空间所以把它去掉了
// function __autoload ($class) {
// 	require_once BASE_ROOT.'lib/core/'.$class.'.php';
// }
// 
loadLib();
loadModel();