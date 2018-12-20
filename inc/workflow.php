<?php
 /*
	[Office 515158] (C) 2009-2014 天生创想 Inc.
	$Id: workflow.php 1209087 2013-11-08 08:58:28Z baiwei.jiang $
*/
define('IN_ADMIN',True);
require_once('../include/common.php');
get_login($_USER->id);
//获取流程数据
global $db;
$query = $db->query("SELECT * FROM ".DB_TABLEPRE."workclass_personnel where flowdatetype=1 and flowdate<'".get_date('Y-m-d H:i:s',PHP_TIME)."' and pertype=0 order by perid asc");
	while ($row = $db->fetch_array($query)) {
		//获取当前流程数据
		$flow1 = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."workclass_flow WHERE fid='".$row['flowid']."'");
		//获取下一步流程数据
		$flow2 = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."workclass_flow  WHERE flownum >'".$flow1['flownum']."' and tplid='".$flow1['tplid']."' order by flownum asc");
		//制定审批状态
		$pertype=2;
		$pertypelog=2;
		if($flow2['flowuser']!=''){
			$pertype=1;
			$pertypelog=1;
		}
		if($flow1['flowkey']=='2'){
			$pertype=5;
			$pertypelog=1;
		}
		//处理当前流程
		$personnel1 = array(
				'pertype' =>$pertype,
				'approvaldate' =>get_date('Y-m-d H:i:s',PHP_TIME),
				'lnstructions' =>'此步骤己超时,由系统自动处理!'
				);
		update_db('workclass_personnel',$personnel1, array('perid' => $row['perid']));
		if($row['appkey']==1){//多人审批
			$per_log = array(
					'pertype' =>$pertypelog,
					'approvaldate' =>get_date('Y-m-d H:i:s',PHP_TIME),
					'lnstructions' =>'此步骤己超时,由系统自动处理!'
					);
			update_db('workclass_personnel_log',$per_log, array('perid' => $row['perid']));
		}
		//创建下一步流程[当默认审批人员为空时不创建]
		if($flow2['flowuser']!=''){
			if($flow2['flowdatetype']==1){
				$flowdate=get_date('Y-m-d H:i:s',PHP_TIME+$flow2['flowdate']*60);
			}
			if($flow2['flowkey2']==1){//多人审批
				$personnel2 = array(
					'name' => $flow2['flowuser'],
					'uid' =>get_realid($flow2['flowuser']),
					'pertype' =>0,
					'workid' =>$row['workid'],
					'flowid' => $flow2['fid'],
					'appkey' => $flow2['flowkey2'],
					'appkey1' => $flow2['flowkey3'],
					'typeid' => $row['typeid'],
					'flowdatetype' => $flow2['flowdatetype'],
					'flowdate' => $flowdate
					);
				insert_db('workclass_personnel',$personnel2);
				$pid=$db->insert_id();
					$staff=explode(',',$flow2['flowuser']);
					$staffid=explode(',',get_realid($flow2['flowuser']));
					for($i=0;$i<sizeof($staffid);$i++){
						$personnel_log = array(
							'name' => $staff[$i],
							'uid' =>$staffid[$i],
							'pertype' =>0,
							'perid' =>$pid,
							'workid' =>$row['workid'],
							'typeid' =>$row['typeid']
							);
						insert_db('workclass_personnel_log',$personnel_log);
					}
			}else{
				$flowuser=explode(',',$flow2['flowuser']);
				$personnel2 = array(
					'name' => $flowuser[0],
					'uid' =>get_userid($flowuser[0]),
					'pertype' =>0,
					'workid' =>$row['workid'],
					'flowid' => $flow2['fid'],
					'appkey' => $flow2['flowkey2'],
					'appkey1' => $flow2['flowkey3'],
					'typeid' => $row['typeid'],
					'flowdatetype' => $flow2['flowdatetype'],
					'flowdate' => $flowdate
					);
				insert_db('workclass_personnel',$personnel2);
			}
		}
	}
echo $pid;
?>