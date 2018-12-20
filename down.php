<?php
//下载文件
define('IN_ADMIN',True);
require_once('include/common.php');
get_login($_USER->id);
$filename=str_replace('..','',$_GET['urls']);
$filename=str_replace('./','',$filename);
$phps=explode('/',$filename);
if($phps[0]!='data' && $phps[0]!='ntko'){
	echo '下载失败！';
	exit;
}
$phps1=explode('.',$filename);
if($phps1[1]=='php'){
	echo '下载失败,请不要非法下载！';
	exit;
}
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=".basename($filename));  
readfile($filename);
?>

