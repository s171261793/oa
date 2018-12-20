<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: index.php 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/
define('IN_ADMIN',True);
require_once('include/common.php');
get_login($_USER->id);
header('Location: desktop.php');
exit;
?>