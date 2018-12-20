<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
get_key("office_duty");
$duty = $db->fetch_one_array("SELECT id,title FROM ".DB_TABLEPRE."duty  WHERE id = '".$_GET['did']."'  ");
empty($do) && $do = 'list';
if ($do == 'list') {
	//列表信息 
	$wheresqltype = '';
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = 50;
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&did='.$_GET['did'].'';
	$user = getGP('user','G');
	if ($userid = getGP('userid','G')) {
		$wheresql .= " AND user='".$userid."'";
		$url .= '&user='.rawurlencode($user).'&userid='.rawurlencode($userid);
	}
	if ($number = getGP('number','G')) {
		$wheresql .= " AND number='".$number."'";
		$url .= '&number='.rawurlencode($number);
	}
	if ($dkey = getGP('dkey','G')) {
		$wheresql .= " AND dkey='".$dkey."'";
		$url .= '&dkey='.rawurlencode($dkey);
	}
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."duty_user WHERE 1 $wheresql  and dutyid='".$_GET['did']."' order by id desc");
	$sql = "SELECT * FROM ".DB_TABLEPRE."duty_user WHERE 1 $wheresql and dutyid='".$_GET['did']."' order by id desc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	include_once('template/user.php');

}elseif ($do == 'view') {
	$sql = "SELECT * FROM ".DB_TABLEPRE."duty_user  WHERE id = '".$_GET['id']."' and dutyid = '".$_GET['did']."'";
	$row = $db->fetch_one_array($sql);
	include_once('template/user_view.php');
}elseif ($do == 'update') {
	$idarr = getGP('id','P','array');
	foreach ($idarr as $id) {
		$db->query("DELETE FROM ".DB_TABLEPRE."duty_user WHERE id= '".$id."'  ");
		$db->query("DELETE FROM ".DB_TABLEPRE."duty_log WHERE duid= '".$id."'  ");	
	}
	$content=serialize($idarr);
	$title='删除任务信息';
	get_logadd($id,$content,$title,33,$_USER->id);
	show_msg('删除任务信息成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&did='.getGP('did','G'));

}elseif ($do == 'excel') {
	$datename="duty_".get_date('YmdHis',PHP_TIME);
	$outputFileName = 'data/excel/'.$datename.'.xls';
	//生成数据
    $content = array();
	$archive=array("任务名称","执行人","任务开始时间","任务结束时间","任务描述","备注","任务状态","完成进度");
	$content[] = $archive;
	$wheresql = '';
	//根据条件导出
	$vstartdate = getGP('vstartdate','G');
	$venddate = getGP('venddate','G');
	if ($vstartdate!='' && $venddate!='') {
		$wheresql .= " AND (startdate>='".$vstartdate."' and enddate<='".$venddate."')";
	}
	//权限判断
	$un = getGP('un','P');
	$ui = getGP('ui','P');
	if(!is_superadmin() && $ui==''){
		$wheresql .= " and (user like'%".get_realname($_USER->id).",%' or uid='".$_USER->id."')";
	}
	if ($ui!='') {
		$wheresql .= " and uid in(".$ui.")";
	}
	if ($number = getGP('number','P')) {
		$wheresql .= " AND number=".$number."";
	}
	if ($dkey = getGP('dkey','P')) {
		$wheresql .= " AND dkey=".$dkey."";
	}
	if ($title = getGP('title','P')) {
		$wheresql .= " AND title LIKE '%$title%'";
	}
	//SQL查询要导出的内容
	$sql = "SELECT * FROM ".DB_TABLEPRE."duty_user WHERE dutyid='".$duty['id']."' ORDER BY id desc";
	$result = $db->query($sql);
	while ($row = $db->fetch_array($result)) {	
	if($row['dkey']=='1'){
		$dkey='进行中';
	}elseif($row['dkey']=='2'){
		$dkey='未完成';
	}elseif($row['dkey']=='3'){
		$dkey='己完成';
	}
	$key1 = $db->fetch_one_array("SELECT sum(progress) as progress FROM ".DB_TABLEPRE."duty_log WHERE dutyid='".$duty['id']."' and duid='".$row['id']."' ");
	//将数据传递给数组
	$archive = array("".$duty[title]."","".get_realname($row['user'])."","".str_replace("-",".",$row['startdate'])."","".str_replace("-",".",$row['enddate'])."","".$row[content]."","".$row[note]."","".$dkey."","'".$key1["progress"]."%'");
	//初使化数组数据
	$content[] = $archive;
	}
//$myArr=$content;
$excel = new ExcelWriter($outputFileName);
if($excel==false) 
echo $excel->error; 
foreach($content as $v){
$excel->writeLine($v);
}
$excel->sendfile($outputFileName);
}elseif ($do == 'add') {
	get_key("office_duty_add");
	if($_POST['view']!=''){
		$id = getGP('id','P','int');
		if($id!=''){
			$startdate = check_str(getGP('startdate','P'));
			$enddate = check_str(getGP('enddate','P'));
			$appendix = check_str(getGP('appendix','P'));
			$note = check_str(getGP('note','P'));
			$content = getGP('content','P');
			$did = getGP('did','P');
			$duty_user = array(
				'startdate' => $startdate,
				'enddate' => $enddate,
				'appendix' => $appendix,
				'note' => $note,
				'content' => $content
			);
			update_db('duty_user',$duty_user, array('id' => $id,'dutyid' => $did));
		}
		show_msg('任务执行人信息操作成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&did='.$did);
	}else{
		$id = getGP('id','G','int');
		if($id!=''){
			$user = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."duty_user  WHERE id = '$id' and dutyid= '".$_GET['did']."' ");
			
			$_title['name']='编辑';
		}
		include_once('template/user_edit.php');
	}
}
?>