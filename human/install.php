<?php
require('../include/common.php');
get_login($_USER->id);
$step = $_POST['step'];
if($step=='2'){
	global $db;
	$db->query("UPDATE ".DB_TABLEPRE."plugin set type='2',date='".get_date('Y-m-d H:i:s',PHP_TIME)."' WHERE id = '".$_POST['pid']."' ");
	$dbhost = DB_HOST;		// 数据库服务器
	$dbuser = DB_USER;			// 数据库用户名
	$dbpwd = DB_PWD;				// 数据库密码
	$dbname = DB_NAME;		// 数据库名
	include("../include/dbbackup.class.php");
	include("../include/msg.class.php");
	$dbbackup = new dbbackup($dbhost, $dbuser, $dbpwd, $dbname);
	$msg = new msg();
	$bakfile = $dbbackup->get_backup();
	if($dbbackup->import("mysql.sql")){				//导入数据
		show_msg('人事管理组件模块安装成功！', '../admin.php?ac=plugin&fileurl=mana');
	}
}elseif($step=='1'){
	global $db;
	$db->query("UPDATE ".DB_TABLEPRE."plugin set type='1' WHERE id = '".$_POST['pid']."' ");
	//权限
	//$db->query("DELETE FROM ".DB_TABLEPRE."keytable WHERE id = 391");
	for($i=410;$i<=413;$i++){
		$db->query("DELETE FROM ".DB_TABLEPRE."keytable WHERE id = ".$i."");
	}
	//菜单
	for($i=237;$i<=248;$i++){
		$db->query("DELETE FROM ".DB_TABLEPRE."menu WHERE menuid = ".$i."");
	}
	//$db->query("DELETE FROM ".DB_TABLEPRE."menu WHERE menuid = 81");
	//数据库
	$db->query("DROP TABLE toa_human_db");
	$db->query("DROP TABLE toa_human_form");
	$db->query("DROP TABLE toa_human_info");
	show_msg('人事管理组件模块卸载成功！', '../admin.php?ac=plugin&fileurl=mana');
}else{
	global $db;
	$sql = "SELECT * FROM ".DB_TABLEPRE."plugin  WHERE id = '".$_GET['pid']."'";
	$row = $db->fetch_one_array($sql);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="../template/default/content/css/style.css">
<title>天生创想OA办公系统组件集成安装程序</title>
</head>
<body class="bodycolor">
<table width="60%" border="0" align="center" cellpadding="3" cellspacing="0" class="small" style="margin-top:20px;margin-bottom:10px;">
  <tr>
    <td class="Big"><img src="../template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 人事管理集成组件安装</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right; margin-right:20px;">
	
	<a href="../admin.php?ac=plugin&fileurl=mana" style="font-size:12px;"><<返回组件列表页</a></span>
    </td>
  </tr>
</table>
<form name="form" method="post" action="install.php">
<input type="hidden" name="pid" value="<?php echo $row['id']?>" />
<table class="TableBlock" border="0" width="60%" align="center">
	<tr>
      <td nowrap class="TableHeader" width="120" style="font-size:16px;">组件名称</td>
      <td class="TableData"><?php echo $row['title']?></td>
    </tr>
	<tr>
      <td nowrap class="TableHeader" width="120" style="font-size:16px;">开发商</td>
      <td class="TableData"><?php echo $row['company']?></td>
    </tr>
	<tr>
      <td nowrap class="TableHeader" width="120" style="font-size:16px;">版本号</td>
      <td class="TableData"><?php echo $row['version']?> </td>
    </tr>
	<tr>
      <td nowrap class="TableHeader" width="120" style="font-size:16px;">描述</td>
      <td class="TableData">暂无</td>
    </tr>
	 <tr>
      <td nowrap class="TableHeader" width="120" style="font-size:16px;"></td>
      <td class="TableData">
	<?php if($_GET['type']=='1'){?>
	<input type="hidden" name="step" value="2" />
	<input type="submit" value="开始安装" class="BigButtonBHover" />
	<?php }else{?>
	<input type="hidden" name="step" value="1" />
	<input type="submit" value="开始卸载" class="BigButtonBHover" />
	<?php }?>
</td>
    </tr>
  </table>
</form>
</body>
</html>