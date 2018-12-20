<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: oa 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/

(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');

//if ( !is_superadmin() && !check_purview('manage_link') ) prompt('对不起，你没有权限执行本操作！');
empty($do) && $do = 'list';
if ($do == 'list') {
	//列表信息 
	$wheresql = '';
	if ($number = getGP('number','G')) {
		$wheresql .= " AND number='".$number."'";
	}
	if ($title = getGP('title','G')) {
		$wheresql .= " AND title LIKE'%".$title."%'";
	}
    $sql = "SELECT * FROM ".DB_TABLEPRE.getGP('modid','G')."  WHERE 1 $wheresql  ORDER BY id desc LIMIT 50";
	$result = $db->fetch_all($sql);
	include_once('mana/public.php');
}elseif($do=='ck'){
	$wheresql = '';
	if ($number = getGP('number','G')) {
		$wheresql .= " AND number='".$number."'";
	}
	if ($title = getGP('title','G')) {
		$wheresql .= " AND title LIKE'%".$title."%'";
	}
	//权限判断
	$sqls = "SELECT keytypeuser,keytype FROM ".DB_TABLEPRE."user where id='".$_USER->id."' and keytype!='2'";
	if($rows = $db->fetch_one_array($sqls)){
		$keytype=$rows['keytype'];
		$keytypeuser=$rows['keytypeuser'];
	}
	if($keytype!='3'){
		$wheresqls .= " AND b.name in('".str_replace(",","','",$keytypeuser)."')";
	}
	if ($name = getGP('name','G')) {
		$wheresqls .= " AND b.name LIKE'%".$name."%'";
	}
    $sqlss = "SELECT a.id,b.name FROM ".DB_TABLEPRE."user a,".DB_TABLEPRE."user_view b  WHERE 1 $wheresqls  and a.id=b.uid ORDER BY numbers asc LIMIT 600";
	$results = $db->fetch_all($sqlss);
	foreach ($sqlss as $r) {
		global $db;
		$sql = "SELECT name,uid FROM ".DB_TABLEPRE."user_view where uid='".$r['id']."'";
		if($row = $db->fetch_one_array($sql)){
			$uid.=$r['uid'].',';
			$name.=$r['name'].',';
		}
	}
	if(!is_superadmin() && $uid==''){
		$wheresql .= " and (uid='".$_USER->id."' or user='".get_realname($_USER->id)."')";
	}
	if ($uid!='') {
		$wheresql .= " and (uid in(".$uid.") or user in('".str_replace(",","','",$name)."'))";
	}
    $sql = "SELECT * FROM ".DB_TABLEPRE."crm_company  WHERE 1 $wheresql  ORDER BY id desc LIMIT 100";
	$result = $db->fetch_all($sql);
	include_once('mana/ckpublic.php');
}elseif($do=='update'){
	$idarr = getGP('id','P','array');
	foreach ($idarr as $id) {
		$sql = "SELECT title,id FROM ".DB_TABLEPRE."crm_company where id='".$id."'";
		if($row = $db->fetch_one_array($sql)){
			$uid.=$row['id'].',';
			$name.=$row['title'].',';
		}
	}
	echo "<script>window.opener.document.save.cid.value='".substr($uid, 0, -1)."';</script>";
	echo "<script>window.opener.document.save.cname.value='".substr($name, 0, -1)."';</script>";
	echo '<script language="JavaScript">window.close()</script>';
}elseif($do=='crmlog'){
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac='.$ac.'&do=crmlog&fileurl='.$fileurl.'&modid='.$_GET['modid'].'&viewid='.$_GET['viewid'].'';
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."crm_log WHERE modid='".$_GET['modid']."' and viewid='".$_GET['viewid']."'");
    $sql = "SELECT * FROM ".DB_TABLEPRE."crm_log WHERE modid='".$_GET['modid']."' and viewid='".$_GET['viewid']."' ORDER BY id desc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	include_once('mana/crmlog.php');
}
?>
