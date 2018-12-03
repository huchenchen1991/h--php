<?php
/**
*h框架
*create by 胡陈晨
*2018.11.28  14.47
*使用规范见根目录下readme.md
*/
define('ROOT_PATH',__DIR__.'/');  //C:\wamp\www\h/

define('APP_DEBUG',true);//打开开发者模式，展示所有错误信息,false线上模式

define('APP_PATH', ROOT_PATH.'application/');

define('CONF_PATH', ROOT_PATH.'config/');

define('SYS_PATH', ROOT_PATH.'system/');

define('RUN_PATH', ROOT_PATH.'runtime/');

define('LIB_PATH', ROOT_PATH.'libraries/');

define('FUN_PATH', ROOT_PATH.'functions/');


//检测开发环境，设置错误错误报告
if(APP_DEBUG){
	error_reporting(E_ALL);
	ini_set('display_errors','On');
	ini_set('log_error', 'On');
	ini_set('error_log', RUN_PATH.'logs/error_debug.log');
}else{
	error_reporting(E_ALL);
	ini_set('display_errors', 'Off');
	ini_set('log_error', 'On');
	ini_set('error_log', RUN_PATH.'logs/error.log');
}

//引入core.php  h框架的核心
require_once(SYS_PATH.'core.php');


//实例化core类，并启动框架
core::get_instance()->start();

?>