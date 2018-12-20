<?php
//新上传组件
define('IN_TOA',true);
set_time_limit(36000000000);
require('../config.php');
require('../include/class_mysql.php');
$db = new Mysql();
$db->connect(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PCONNECT);
error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');
$upload_handler = new UploadHandler();
function UserId(){
	if($_GET['userid']!=''){
		return $_GET['userid'];
	}else{
		return $_POST['userid'];
	}
}
?>