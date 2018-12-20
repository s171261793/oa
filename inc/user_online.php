<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="../template/default/im/css/chatonline.css" />
<script type="text/javascript" src="../template/default/im/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../template/default/im/js/chatonline.js"></script>
<!--[if lt IE 7]>
<script src="../template/default/im/js/IE7.js" type="text/javascript"></script>
<![endif]-->
<!--[if IE 6]>
<script src="../template/default/im/js/iepng.js" type="text/javascript"></script>
<script type="text/javascript">
EvPNG.fix('body, div, ul, img, li, input, a, span ,label'); 
</script>
<![endif]-->
<?php
 /*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: user_online.php 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/
define('IN_ADMIN',True);
require_once('../include/common.php');
get_login($_USER->id);
global $db;
$query = $db->query("SELECT a.id,b.name,a.departmentid,b.pic FROM ".DB_TABLEPRE."user a,".DB_TABLEPRE."user_view b WHERE a.id=b.uid and a.online='1'   ORDER BY a.id ASC");
	echo '<ul>';
	while ($row = $db->fetch_array($query)) {
	if($row['pic']!=''){
		$src='../'.$row['pic'];
	}else{
		$src='../template/default/images/sex01.gif';
	}
	echo '<li>
                                <!--<label class="online">
                                </label> -->
                                <a href="javascript:;">
                                    <img src="'.$src.'"></a><a href="javascript:;" class="chat03_id" style="display:none;">'.$row['id'].'</a><a href="javascript:;" class="chat03_uid" style="display:none;">'.$_USER->id.'</a><a href="javascript:;" class="chat03_name">'.$row['name'].'</a><a href="javascript:;" class="chat03_group">'.get_realdepaname($row['departmentid']).'</a>
                            </li>';

}
echo '</ul>';
?>
</body>
</html>