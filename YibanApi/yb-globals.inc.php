<?php
    if (!function_exists('curl_init')) {
        throw new Exception('YiBan needs the CURL PHP extension.');
    }
    if (!function_exists('json_decode')) {
        throw new Exception('YiBan needs the JSON PHP extension.');
    }
    if (!function_exists('mcrypt_decrypt')) {
        throw new Exception('YiBan needs the mcrypt PHP extension.');
    }
	if(!defined('YBAPI_CLASSESS_DIR')) {
		define('YBAPI_CLASSESS_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);
		require(YBAPI_CLASSESS_DIR.'lang.zh_CN.UTF8.php');
		require(YBAPI_CLASSESS_DIR.'YBException.class.php');
		require(YBAPI_CLASSESS_DIR.'YBOpenApi.class.php');
		require(YBAPI_CLASSESS_DIR.'YBAPI'.DIRECTORY_SEPARATOR.'IApp.class.php'); //轻应用模块
	}
?>