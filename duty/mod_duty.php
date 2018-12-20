<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
get_key("office_duty");
empty($do) && $do = 'list';
if ($do == 'list') {
	//列表信息 
	$wheresqltype = '';
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl;
	if ($title = getGP('title','G')) {
		$wheresql .= " AND title LIKE '%$title%' ";
		$url .= '&title='.rawurlencode($title);
	}
	if ($number = getGP('number','G')) {
		$wheresql .= " AND number='".$number."'";
		$url .= '&number='.rawurlencode($number);
	}
	if ($dkey = getGP('dkey','G')) {
		$wheresql .= " AND dkey='".$dkey."'";
		$url .= '&dkey='.rawurlencode($dkey);
	}
	$vstartdate = getGP('vstartdate','G');
	$venddate = getGP('venddate','G');
	if ($vstartdate!='' && $venddate!='') {
		$wheresql .= " AND (startdate>='".$vstartdate."' and enddate<='".$venddate."')";
		$url .= '&vstartdate='.$vstartdate.'&venddate='.$venddate;
	}
	//权限判断
	$un = getGP('un','G');
	$ui = getGP('ui','G');
	if(!is_superadmin() && $ui==''){
		$wheresql .= " and (user like'%".get_realname($_USER->id).",%' or uid='".$_USER->id."')";
	}
	if ($ui!='') {
		$wheresql .= " and uid in(".$ui.")";
		$url .= '&ui='.$ui.'&un='.$un;
	}
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."duty WHERE 1 $wheresql  order by id desc");
	$sql = "SELECT * FROM ".DB_TABLEPRE."duty WHERE 1 $wheresql  order by id desc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	include_once('template/list.php');

}elseif ($do == 'view') {
	get_key("office_duty_reda");
	$sql = "SELECT * FROM ".DB_TABLEPRE."duty  WHERE id = '".$_GET['id']."'";
	require(TOA_ROOT.'include/function_charts.php');
	$row = $db->fetch_one_array($sql);
		$strtype  = "<chart caption='' xAxisName='执行人进度统计' yAxisName='执行人' showValues='0' formatNumberScale='0' showBorder='1'>";
		global $db;
		$sql = $db->query("SELECT id,user FROM ".DB_TABLEPRE."duty_user where dutyid='".$row['id']."' ORDER BY id Asc");
		while ($user = $db->fetch_array($sql)) {
			$numuser = $db->result("SELECT sum(progress) as numuser FROM ".DB_TABLEPRE."duty_log WHERE dutyid='".$row['id']."' and duid='".$user['id']."'");
			$strtype .= "<set label='".get_realname($user['user'])."' value='".$numuser."' />";
		}
		$strtype .= "</chart>";
	include_once('template/view.php');
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

}elseif ($do == 'excel') {
	$datename="duty_".get_date('YmdHis',PHP_TIME);
	$outputFileName = 'data/excel/'.$datename.'.xls';
	//生成数据
    $content = array();
	$archive=array("任务编号","任务名称","执行人","任务开始时间","任务结束时间","任务描述","备注","任务状态","分配人");
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
	$sql = "SELECT * FROM ".DB_TABLEPRE."duty WHERE 1 $wheresql ORDER BY id desc";
	$result = $db->query($sql);
	while ($row = $db->fetch_array($result)) {	
	if($row['dkey']=='1'){
		$dkey='进行中';
	}elseif($row['dkey']=='2'){
		$dkey='未完成';
	}elseif($row['dkey']=='3'){
		$dkey='己完成';
	}
	//将数据传递给数组
	$archive = array("".$row[number]."","".$row[title]."","".$row[user]."","".str_replace("-",".",$row['startdate'])."","".str_replace("-",".",$row['enddate'])."","".$row[content]."","".$row[note]."","".$dkey."","".get_realname($row['uid'])."");
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
			$number = check_str(getGP('number','P'));
			$title = check_str(getGP('title','P'));
			$user = check_str(getGP('user','P'));
			$startdate = check_str(getGP('startdate','P'));
			$enddate = check_str(getGP('enddate','P'));
			$appendix = check_str(getGP('appendix','P'));
			$note = check_str(getGP('note','P'));
			$content = getGP('content','P');
			$duty = array(
				'number' => $number,
				'title' => $title,
				'user' => $user.',',
				'startdate' => $startdate,
				'enddate' => $enddate,
				'appendix' => $appendix,
				'note' => $note,
				'content' => $content
			);
			update_db('duty',$duty, array('id' => $id));
			//更新成员信息
			$user=explode(',',getGP('userid','P'));
			for($i=0;$i<sizeof($user);$i++){
				if($user[$i]!=''){
					$uid = $db->fetch_one_array("SELECT id FROM ".DB_TABLEPRE."duty_user  WHERE dutyid = '".$id."' and user = '".trim($user[$i])."' ");
					if($uid['id']==''){
						$duty_user = array(
							'dutyid' => $id,
							'user' =>$user[$i],
							'startdate' => $startdate,
							'enddate' => $enddate,
							'appendix' => $appendix,
							'note' => $note,
							'content' => $content,
							'dkey' =>1
							);
						insert_db('duty_user',$duty_user);
					}
				}
			}
			if(getGP('sms_info_box_user','P')!=''){
				$content='您有一个任务需要执行,编号为：'.$number.';请进行处理!';
				//接收人；内容；类型（1：有返回回值;0：无返回值）;URL
				SMS_ADD_POST(getGP('user','P'),$content,0,0,$_USER->id);
			}
			//手机短信
			if(getGP('sms_phone_box_user','P')!=''){
				$content='您有一个任务需要执行,编号为：'.$number.';请登录OA进行处理!';
				PHONE_ADD_POST(getGP('userphone','P'),$content,getGP('user','P'),0,0,$_USER->id);
			}
			$content='';
			$content=serialize($duty);
			$title='编辑任务信息';
			get_logadd($id,$content,$title,33,$_USER->id);
			
		}else{
			$number = check_str(getGP('number','P'));
			$title = check_str(getGP('title','P'));
			$user = check_str(getGP('user','P'));
			$startdate = check_str(getGP('startdate','P'));
			$enddate = check_str(getGP('enddate','P'));
			$appendix = check_str(getGP('appendix','P'));
			$note = check_str(getGP('note','P'));
			$content = getGP('content','P');
			$uid=$_USER->id;
			$date = get_date('Y-m-d H:i:s',PHP_TIME);
			$duty = array(
				'number' => $number,
				'title' => $title,
				'user' => $user.',',
				'startdate' => $startdate,
				'enddate' => $enddate,
				'appendix' => $appendix,
				'note' => $note,
				'content' => $content,
				'dkey' => 1,
				'date' => $date,
				'uid' => $uid
			);
			insert_db('duty',$duty);
			$id=$db->insert_id();
			//更新成员信息
			$user=explode(',',getGP('userid','P'));
			for($i=0;$i<sizeof($user);$i++){
				if($user[$i]!=''){
					$duty_user = array(
						'dutyid' => $id,
						'user' =>$user[$i],
						'startdate' => $startdate,
						'enddate' => $enddate,
						'appendix' => $appendix,
						'note' => $note,
						'content' => $content,
						'dkey' =>1
						);
					insert_db('duty_user',$duty_user);
				}
			}
			if(getGP('sms_info_box_user','P')!=''){
				$content='您有一个任务需要执行,编号为：'.$number.';请进行处理!';
				//接收人；内容；类型（1：有返回回值;0：无返回值）;URL
				SMS_ADD_POST(getGP('user','P'),$content,0,0,$_USER->id);
			}
			//手机短信
			if(getGP('sms_phone_box_user','P')!=''){
				$content='您有一个任务需要执行,编号为：'.$number.';请登录OA进行处理!';
				PHONE_ADD_POST(getGP('userphone','P'),$content,getGP('user','P'),0,0,$_USER->id);
			}
			$content=serialize($duty);
			$title='新建任务表信息';
			get_logadd($id,$content,$title,33,$_USER->id);
		}
		show_msg('任务信息操作成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
	}else{
		$id = getGP('id','G','int');
		if($id!=''){
			$user = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."duty  WHERE id = '$id' ");
			
			$_title['name']='编辑';
		}else{ 
			$user['number']=get_date('YmdHis',PHP_TIME);
			$_title['name']='发布';
		}
		include_once('template/add.php');
	}
}
?>