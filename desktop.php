<?php
/*
	[Office 515158] (C) 2009-2019 天生创想 Inc.
	$Id: home.php 1209087 2014-08-30 08:58:28Z baiwei.jiang $
*/
define('IN_ADMIN',True);
require_once('include/common.php');
require_once('include/function_home.php');
get_login($_USER->id);

//重新获取背景
if(getGP('hometype','G')!=''){
	$db->query("update ".DB_TABLEPRE."user_view set hometype='".getGP('hometype','G')."' WHERE uid = '".$_USER->id."' ");
}
if(getGP('homeico','G')!=''){
	$db->query("update ".DB_TABLEPRE."user_view set homemana='' WHERE uid = ".$_USER->id." ");
	header('Location: desktop.php');
	exit;	
}

//获取旧数据
$sql = "SELECT homemana,homemanaleft,homebg,pic,sex,home_txt,hometype FROM ".DB_TABLEPRE."user_view  WHERE uid='".$_USER->id."'";
$bguser = $db->fetch_one_array($sql);


$homemana=$bguser['homemana'];
$homemanaleft=$bguser['homemanaleft'];

// $homemanaleft='"17",';
$nums=28;
$num=0;
//初使化数据
if($homemanaleft==''){
	// $homemanaleft='"17","21","20","272","31","303",';
	$homemanaleft='"17",'; //默认是
	$db->query("update ".DB_TABLEPRE."user_view set homemanaleft='".$homemanaleft."' WHERE uid = ".$_USER->id." ");	
}
if($homemana==''){
		$html='';
		$s=1;
		$j=1;
		$html.=$s.':,';
		$sql = "SELECT menuid,keytable FROM ".DB_TABLEPRE."menu where fatherid!=0 and menutype='2' ORDER BY menunum asc ";
		$query = $db->query($sql);
		// dump($sql);die;
		while ($row = $db->fetch_array($query)) {
			if($row['keytable']!=''){
				if(is_superadmin() || check_purview($row['keytable'])){
					$j++;
					$html.='"'.$row['menuid'].'",';
				}
			}else{
				$j++;
				$html.='"'.$row['menuid'].'",';
			}
			if($j%29==0){
				$s++;
				$html.='|';
				$html.=$s.':,';
				
			}
		}
	$db->query("update ".DB_TABLEPRE."user_view set homemana='".substr($html, 0, -1)."' WHERE uid = ".$_USER->id." ");	
	$homemana=substr($html, 0, -1);

}
// $homemana=explode('|',$homemana);
// // var_dump($homemana) ;
// // exit;
// for($i=0;$i<sizeof($homemana);$i++){
// 	$homemana_data=explode(',',str_replace($j.':','',$homemana[$i]));
// 	for($m=0;$m<sizeof($homemana_data);$m++)
// 	{
// 		if(str_replace('"','',trim($homemana_data[$m]))!='')
// 		{
// 			$sqls = "SELECT * FROM ".DB_TABLEPRE."menu  WHERE menuid=".str_replace('"','',trim(preg_replace('/[^0-9]/i','',$homemana_data[$m])))." and menutype='2'";
// 			echo $sqls;
// 		}
// 	}
// }
// exit;
include_once template.'desktop.php';



function get_home_nums($type){
	global $db,$_USER;
	//短消息
	if($type=='admin.php?ac=receive&fileurl=sms'){
		$sql = "SELECT COUNT(*) as nums FROM ".DB_TABLEPRE."sms_receive where receiveperson='".$_USER->id."' and smskey='1'";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	//考勤
	}elseif($type=='admin.php?ac=registration&fileurl=workbench'){
		$sql = "SELECT COUNT(*) as nums FROM ".DB_TABLEPRE."registration where uid='".$_USER->id."' AND month='".get_date('m',PHP_TIME)."'";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	//新闻
	}elseif($type=='admin.php?ac=news&fileurl=workbench&type=1'){
		$sql = "SELECT COUNT(*) as nums FROM ".DB_TABLEPRE."news where type='1' AND (receive like'%".get_realname($_USER->id)."%' or receive='0')";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	//公告
	}elseif($type=='admin.php?ac=news&fileurl=workbench&type=3'){
		$sql = "SELECT COUNT(*) as nums FROM ".DB_TABLEPRE."news where type='3' AND (receive like'%".get_realname($_USER->id)."%' or receive='0')";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	//大事记
	}elseif($type=='admin.php?ac=news&fileurl=workbench&type=5'){
		$sql = "SELECT COUNT(*) as nums FROM ".DB_TABLEPRE."news where type='5' AND (receive like'%".get_realname($_USER->id)."%' or receive='0')";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	//通知
	}elseif($type=='admin.php?ac=news&fileurl=workbench&type=4'){
		$sql = "SELECT COUNT(*) as nums FROM ".DB_TABLEPRE."news where type='4' AND (receive like'%".get_realname($_USER->id)."%' or receive='0')";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}elseif($type=='admin.php?ac=duty&fileurl=duty'){
	//任务管理
		$sql = "SELECT COUNT(*) as nums FROM ".DB_TABLEPRE."duty where user='".get_realname($_USER->id)."' and dkey='1'";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}elseif($type=='admin.php?ac=workdate&fileurl=workbench'){
	//日程安排
		$venddate=get_date('Y-m-d H:i:s',PHP_TIME);
		$sql = "SELECT COUNT(*) as nums FROM ".DB_TABLEPRE."workdate where uid='".$_USER->id."'  AND (startdate>='".$vstartdate."' and enddate<='".$venddate."')";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}elseif($type=='admin.php?ac=plan&fileurl=workbench'){
	//工作计划
		$venddate=get_date('Y-m-d H:i:s',PHP_TIME);
		$sql = "SELECT COUNT(*) as nums FROM ".DB_TABLEPRE."plan where (participation like'%".get_realname($_USER->id)."%' or person like'%".get_realname($_USER->id)."%')  AND (startdate>='".$vstartdate."' and enddate<='".$venddate."')";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}elseif($type=='admin.php?ac=blog&fileurl=workbench'){
		//工作日记
		$sql = "SELECT COUNT(*) as nums FROM ".DB_TABLEPRE."blog where uid=".$_USER->id." AND DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=date(date)";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}elseif($type=='admin.php?ac=conference&fileurl=administrative'){
		//会议管理
		$venddate=get_date('Y-m-d H:i:s',PHP_TIME);
		$sql = "SELECT COUNT(*) as nums FROM ".DB_TABLEPRE."conference where (attendance like'%".get_realname($_USER->id)."%' or staffid =".$_USER->id.") AND (startdate>='".$vstartdate."' and enddate<='".$venddate."')";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}elseif($type=='admin.php?ac=list&fileurl=workclass'){
		//工作流
		$venddate=get_date('Y-m-d H:i:s',PHP_TIME);
		$sql = "SELECT COUNT(*) as nums FROM ".DB_TABLEPRE."workclass where uid='".$_USER->id."'";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}elseif($type=='admin.php?ac=list&fileurl=workclass&type=2'){
		//工作流[经我审批]
		$venddate=get_date('Y-m-d H:i:s',PHP_TIME);
		$sql = "SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."workclass a,".DB_TABLEPRE."workclass_personnel b WHERE a.id=b.workid and b.pertype!=0 and b.name like '%".get_realname($_USER->id)."%' order by b.perid desc";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}elseif($type=='admin.php?ac=list&fileurl=workclass&type=1'){
		//工作流[待我审批]
		$venddate=get_date('Y-m-d H:i:s',PHP_TIME);
		$sql = "SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."workclass a,".DB_TABLEPRE."workclass_personnel b WHERE  a.id=b.workid and (b.pertype=0 or b.pertype=4) and b.name like '%".get_realname($_USER->id)."%' and a.type!=1 order by b.perid asc";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}elseif($type=='admin.php?ac=attachment&fileurl=app&type=1'){
		//公文[收文审批]
		$sql = "SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."attachment a,".DB_TABLEPRE."personnel b where a.id=b.fileid and (b.pkey=0 or b.pkey=4) and b.name like '%".get_realname($_USER->id)."%' and a.attakey!=1 and b.type=1 order by b.id asc";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}elseif($type=='admin.php?ac=attachment&fileurl=app&type=3'){
		//公文[收文阅读]
		$sql = "SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."attachment a,".DB_TABLEPRE."distribution b where a.id=b.fileid and b.uid='".$_USER->id."' and b.dkey=1 and b.viewdate='' order by b.viewdate asc";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}elseif($type=='admin.php?ac=attachment&fileurl=app'){
		//公文[收文列表]
		$sql = "SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."attachment WHERE uid='".$_USER->id."'  order by id desc";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}elseif($type=='admin.php?ac=approval&fileurl=app'){
		//公文[发文列表]
		$sql = "SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."approval WHERE userid='".$_USER->id."' order by id desc";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}elseif($type=='admin.php?ac=approval&fileurl=app&type=1'){
		//公文[发文办理]
		$sql = "SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."approval a,".DB_TABLEPRE."personnel b where a.id=b.fileid and (b.pkey=0 or b.pkey=4) and b.name like '%".get_realname($_USER->id)."%' and a.akey!=1 and b.type=2 order by b.id asc";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}elseif($type=='admin.php?ac=approval&fileurl=app&type=3'){
		//公文[发文阅读]
		$sql = "SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."approval a,".DB_TABLEPRE."distribution b where a.id=b.fileid and b.uid='".$_USER->id."' and b.dkey=2 and b.viewdate='' order by b.viewdate asc";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}elseif($type=='admin.php?ac=list&fileurl=project'){
		//项目[项目列表]
		$sql = "SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."project WHERE  uid='".$_USER->id."'  order by id desc";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}elseif($type=='admin.php?ac=list&fileurl=project&type=1'){
		//项目[项目审批]
		$sql = "SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."project a,".DB_TABLEPRE."project_personnel b WHERE a.id=b.projectid and (b.pertype=0 or b.pertype=4) and b.name like '%".get_realname($_USER->id)."%' and a.type!=1 and b.appkey2=1 order by b.perid asc";
		$nums = $db->result($sql);
		if($nums>0){
			return $nums;
		}else{
			return '0';
		}
	
	}else{//无数据
		return '0';
	}
}
?>