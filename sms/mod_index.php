<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
get_key("office_info");

empty($do) && $do = 'list';
if ($do == 'list') {
	//列表信息 
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$vuidtype = getGP('vuidtype','G');
	$url = 'admin.php?ac=index&fileurl=sms&userkeytype='.$userkeytype;
	$vstartdate = getGP('vstartdate','G');
	$venddate = getGP('venddate','G');
	if ($vstartdate!='' && $venddate!='') {
		$wheresql .= " AND (date>='".$vstartdate."' and date<='".$venddate."')";
		$url .= '&vstartdate='.$vstartdate.'&venddate='.$venddate;
	}
	//权限判断
	$un = getGP('un','G');
	$ui = getGP('ui','G');
	if(!is_superadmin() && $ui==''){
		$wheresql .= " and uid='".$_USER->id."'";
	}
	if ($ui!='') {
		$wheresql .= " and uid in(".$ui.")";
		$url .= '&ui='.$ui.'&un='.$un;
	}
	if ($contents = getGP('contents','G')) {
		$wheresql .= " AND content LIKE '%$contents%' ";
		$url .= '&contents='.rawurlencode($contents);
	}
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."sms_send WHERE 1 $wheresql ");
     $sql = "SELECT * FROM ".DB_TABLEPRE."sms_send WHERE 1 $wheresql ORDER BY id desc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);

	include_once('template/index.php');

} elseif ($do == 'update') {
	
	get_key("office_info_delete");

	$idarr = getGP('id','P','array');
	foreach ($idarr as $id) {
	$db->query("DELETE FROM ".DB_TABLEPRE."sms_send WHERE id = '$id' ");
	//db->query("DELETE FROM ".DB_TABLEPRE."user_view WHERE uid = '$id'");
	
	if($id!='')
	{
   $oalog = array(
		'uid' => $_USER->id,
		'content' => '删除内部短信',
		'title' => '删除内部短信',
		'startdate' => get_date('Y-m-d H:i:s',PHP_TIME),
		'contentid' => $id,
		'type' => '4'
	);
	insert_db('oalog',$oalog);
	
	}
	}
	show_msg('短消息删除成功！', 'admin.php?ac=index&fileurl=sms&userkeytype='.getGP('userkeytype','P').'');

}elseif ($do == 'excel') {
	$datename="sms_".get_date('YmdHis',PHP_TIME);
	$outputFileName = 'data/excel/'.$datename.'.xls';
		$content = array();
		$archive=array("接收人","发送人","发送时间","内容");
		$content[] = $archive;
		$wheresql = '';
		$vstartdate = getGP('vstartdate','P');
		$venddate = getGP('venddate','P');
		if ($vstartdate!='' && $venddate!='') {
			$wheresql .= " AND (date>='".$vstartdate."' and date<='".$venddate."')";
		}
		//权限判断
		$un = getGP('un','P');
		$ui = getGP('ui','P');
		if(!is_superadmin() && $ui==''){
			$wheresql .= " and uid='".$_USER->id."'";
		}
		if ($ui!='') {
			$wheresql .= " and uid in(".$ui.")";
		}
		if ($contents = getGP('contents','P')) {
			$wheresql .= " AND content LIKE '%$contents%' ";
		}
		$sql = "SELECT * FROM ".DB_TABLEPRE."sms_send WHERE 1 $wheresql ORDER BY id desc";
		$result = $db->query($sql);
		while ($row = $db->fetch_array($result)) {	
			$archive = array(
				"".$row['receiveperson']."",
				"".get_realname($row['uid'])."",
				"".str_replace("-",".",$row[date])."",
				"".$row['content'].""
			);
			$content[] = $archive;
		}
	$excel = new ExcelWriter($outputFileName);
	if($excel==false) 
		echo $excel->error; 
	foreach($content as $v){
		$excel->writeLine($v);
	}
	$excel->sendfile($outputFileName);
} 
?>