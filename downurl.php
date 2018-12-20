<?php
//下载文件
define('IN_ADMIN',True);
require_once('include/common.php');
get_login($_USER->id);
$filename=str_replace('..','',$_GET['urls']);
$filename=str_replace('./','',$filename);
$phps=explode('/',$filename);
if($phps[0].$phps[1]!='datauploadfile'){
	echo '下载失败！';
	exit;
}
//$filename=dirname(__FILE__).'/'.$filename;
$blogurl = 'http://'.$_SERVER['SERVER_NAME'].'/';
$out_filename = iconv("UTF-8","GB2312",$_GET['filename']);
header("Content-type:application/octet-stream");
header("Accept-Ranges:bytes");
header("Content-transfer-encoding: binary");
header("Content-Type:application/force-download");
header("Content-Disposition:inline;filename=".$out_filename);
header("Accept-Length:".filesize($filename));
readfile($blogurl.$filename);//要下的文件,包括路径
/*header("Content-type: application/octet-stream");
header("Accept-Ranges: bytes");
header("Accept-Length: " . filesize($filename));
header("Content-Transfer-Encoding: binary");
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=". $out_filename);
header("Content-Type: application/octet-stream; name=". $out_filename);
if(is_file($filename) && is_readable($filename)){
	$file = fopen($filename, "r");
	echo fread($file, filesize($filename));
	fclose($file);
	exit;
}*/
?>

