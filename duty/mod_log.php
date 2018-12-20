<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
get_key("office_duty_sum");
$duty = $db->fetch_one_array("SELECT id,title,dkey FROM ".DB_TABLEPRE."duty  WHERE id = '".$_GET['did']."'  ");
$uid = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."duty_user  WHERE dutyid = '".$_GET['did']."' and user='".$_USER->id."' ");
if($uid['user']==''){
	show_msg('记录被删除或无执行权限,请联系任务发起人！', 'admin.php?ac=duty&fileurl='.$fileurl.'');
}
empty($do) && $do = 'list';
if ($do == 'list') {
	//列表信息 
	$wheresqltype = '';
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&did='.$_GET['did'].'';
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."duty_log WHERE 1 $wheresql  and dutyid='".$_GET['did']."' and duid='".$uid['id']."' order by id asc");
	$sql = "SELECT * FROM ".DB_TABLEPRE."duty_log WHERE 1 $wheresql and dutyid='".$_GET['did']."'  and duid='".$uid['id']."' order by id asc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	include_once('template/log.php');

}elseif ($do == 'update') {
	$idarr = getGP('id','P','array');
	foreach ($idarr as $id) {
		$db->query("DELETE FROM ".DB_TABLEPRE."duty WHERE id= '$id'  ");
		$db->query("DELETE FROM ".DB_TABLEPRE."duty_user WHERE dutyid= '$id'  ");
		$db->query("DELETE FROM ".DB_TABLEPRE."duty_log WHERE dutyid= '$id'  ");	
	}
	$content=serialize($idarr);
	$title='删除任务信息';
	get_logadd($id,$content,$title,33,$_USER->id);
	show_msg('删除任务信息成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');

}elseif ($do == 'add') {
	if($_POST['view']!=''){
			$did = check_str(getGP('did','P'));
			$duid = check_str(getGP('duid','P'));
			$progress = check_str(getGP('progress','P'));
			$appendix = check_str(getGP('appendix','P'));
			$note = check_str(getGP('note','P'));
			$content = getGP('content','P');
			$uid=$_USER->id;
			$date = get_date('Y-m-d H:i:s',PHP_TIME);
			$duty_log = array(
				'dutyid' => $did,
				'content' => $content,
				'progress' => $progress,
				'appendix' => $appendix,
				'note' => $note,
				'date' => $date,
				'uid' => $uid,
				'duid' => $duid
			);
			insert_db('duty_log',$duty_log);
			$id=$db->insert_id();
			$content=serialize($duty_log);
			$title='新建任务进度信息';
			get_logadd($id,$content,$title,33,$_USER->id);
		show_msg('任务进度信息操作成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&did='.$did.'');
	}else{
		include_once('template/logadd.php');
	}
}
?>