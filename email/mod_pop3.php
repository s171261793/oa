<?php
/*
	[Office 515158] (C) 2009-2014 天生创想 Inc.
	$Id: mod_pop3 1209087 2014-09-08Z baiwei.jiang $
*/
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
empty($do) && $do = 'list';
$_check['ischeck']='  ui-tab-trigger-item-current';
if ($do == 'list') {
	//列表信息 
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'';
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."popmail WHERE 1 $wheresql ORDER BY id desc");
    $sql = "SELECT * FROM ".DB_TABLEPRE."popmail WHERE 1 $wheresql ORDER BY id desc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	include_once('template/pop3list.php');

}elseif ($do == 'update') {
	$idarr = getGP('id','P','array');
	foreach ($idarr as $id) {
		$db->query("DELETE FROM ".DB_TABLEPRE."popmail WHERE id = '$id' ");
	}
	$content=serialize($idarr);
	$title='删除内容';
	get_logadd($id,$content,$title,5,$_USER->id);
	show_msg('信息删除成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');

}elseif ($do == 'add') {
	if($_POST['view']!=''){
		$id = getGP('id','P','int');
		$pop3 = check_str(getGP('pop3','P'));
		$smtp = check_str(getGP('smtp','P'));
		$username = check_str(getGP('username','P'));
		$password = check_str(getGP('password','P'));
		$mail = check_str(getGP('mail','P'));
		$pop3num = check_str(getGP('pop3num','P'));
		$smtpnum = check_str(getGP('smtpnum','P'));
		$uid = $_USER->id;
		if($id!=''){
			$popmail = array(
				'pop3' => $pop3,
				'smtp' => $smtp,
				'pop3num' => $pop3num,
				'smtpnum' => $smtpnum,
				'username' => $username,
				'password' => $password,
				'mail' => $mail
			);
			update_db('popmail',$popmail, array('id' => $id,'uid' => $_USER->id));
			$content=serialize($popmail);
			$title='编辑邮箱';
			get_logadd($id,$content,$title,5,$_USER->id);
		}else{
			$popmail = array(
				'pop3' => $pop3,
				'smtp' => $smtp,
				'pop3num' => $pop3num,
				'smtpnum' => $smtpnum,
				'username' => $username,
				'password' => $password,
				'mail' => $mail,
				'uid' => $uid
			);
			insert_db('popmail',$popmail);
			$id=$db->insert_id();
			$content=serialize($popmail);
			$title='新增邮箱';
			get_logadd($id,$content,$title,5,$_USER->id);
		}
		show_msg('邮箱信息操作成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
	}else{
		$id = getGP('id','G','int');
		if($id!=''){
			$user = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."popmail  WHERE id = '$id' and uid='".$_USER->id."'");
			$_title['name']='编辑';
		}else{ 
			$_title['name']='新增';
			$user['pop3num']='110';
			$user['smtpnum']='25';
		}
		include_once('template/pop3add.php');
		
	}
	
}
?>