<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
//get_key("workclass");
empty($do) && $do = 'list';
if ($do == 'list') {
	if($_POST['view']!=''){
		$perid=getGP('perid','P');//当前审批ID
		$content=getGP('content','P');//批示
		$pkey=getGP('pkey','P');//状态
		$viewid=getGP('viewid','P');//流程ID
		$oldappkey=getGP('oldappkey','P');//状态
		$oldappkey1=getGP('oldappkey1','P');//状态
		//if($type['appkey']==1){
			$sql = "SELECT * FROM ".DB_TABLEPRE."crm_flow  WHERE fid = '".getGP('oldappflow','P')."'";
			$flow = $db->fetch_one_array($sql);
			$perlnum = $db->result("SELECT COUNT(*) AS perlnum FROM ".DB_TABLEPRE."crm_personnel_log where perid='".$perid."' and pertype=0 and modid='".getGP('modid','P')."' and viewid='".$viewid."'");
			if($oldappkey==1){
				if($oldappkey1==1 && $perlnum>1 && $pkey!=2){
					$pkeys=4;
				}elseif($flow['flowkey']==2){
					$pkeys=5;
				}else{
					$pkeys=$pkey;
				}
			}else{
				$pkeys=$pkey;
				if($flow['flowkey']==2 && $pkey!=2){
					$pkeys=5;
				}
			}
			$personnel1 = array(
				'pertype' =>$pkeys,
				'approvaldate' =>get_date('Y-m-d H:i:s',PHP_TIME),
				'lnstructions' =>$content
				);
			update_db('crm_personnel',$personnel1, array('perid' => $perid));
			if($oldappkey==1){
				$per_log = array(
					'pertype' =>$pkey,
					'approvaldate' =>get_date('Y-m-d H:i:s',PHP_TIME),
					'lnstructions' =>$content
					);
				update_db('crm_personnel_log',$per_log, array('perid' => $perid,'uid' => $_USER->id));
				if($pkey==2){
					$personnel1 = array(
					'pertype' =>$pkey,
					'approvaldate' =>get_date('Y-m-d H:i:s',PHP_TIME),
					'lnstructions' =>$content
					);
					update_db('crm_personnel',$personnel1, array('perid' => $perid));
				}
			}
			//创建下一步审批人员
			if(getGP('staffid','P')!='' && $pkeys!=2){
				$personnel2 = array(
					'name' => getGP('staff','P'),
					'uid' =>getGP('staffid','P'),
					'pertype' =>0,
					'viewid' =>$viewid,
					'flowid' => getGP('flowid','P'),
					'appkey' => getGP('appkey','P'),
					'appkey1' => getGP('appkey1','P'),
					'modid' => getGP('modid','P')
					);
				insert_db('crm_personnel',$personnel2);
				$pid=$db->insert_id();
				if(getGP('appkey','P')=='1'){
					$staff=explode(',',getGP('staff','P'));
					$staffid=explode(',',getGP('staffid','P'));
					for($i=0;$i<sizeof($staffid);$i++){
						$personnel_log = array(
							'name' => $staff[$i],
							'uid' =>$staffid[$i],
							'pertype' =>0,
							'perid' =>$pid,
							'viewid' =>$viewid,
							'modid' =>getGP('modid','P')
							);
						insert_db('crm_personnel_log',$personnel_log);
					}
				}
			}
		//处理库存
		if($pkeys==5 && getGP('modid','P')=='crm_purchase'){
			global $db;
			$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_prod_view where viewid='".$viewid."' and type=2 ORDER BY id Asc");
			while ($rs = $db->fetch_array($query)) {
				$crm_stock = array(
						'pid' => $rs['pid'],
						'stocknum' => $rs['number'],
						'unit' => $rs['unit'],
						'number' => "T".get_date('YmdHis',PHP_TIME),
						'type' => 2,
						'date'=>get_date('Y-m-d H:i:s',PHP_TIME),
						'uid'=>$_USER->id
					);
				insert_db('crm_stock',$crm_stock);
			}
			
		}
		//通知审批人员
		if(getGP('sms_info_box_shownamemaster','P')!=''){
			$content1='您有一个工作流程需要审批,请点击进入工作流进行审批!';
			SMS_ADD_POST(getGP('staff','P'),$content1,0,0,$_USER->id);
		}
		//手机短信
		if(getGP('sms_phone_box_shownamemaster','P')!=''){
			$content2='您有一个工作流程需要审批,请登录OA进行审批!';
			PHONE_ADD_POST(getGP('staffphone','P'),$content2,getGP('staff','P'),0,0,$_USER->id);
		}
		$content=serialize($personnel1);
		$title='审批工作流';
		get_logadd($id,$content,$title,14,$_USER->id);
		show_msg('工作流己成功审批！', 'admin.php?ac='.str_replace('crm_','',getGP('modid','P')).'&fileurl='.$fileurl.'');
	}else{
		//获取工作流信息
		$sql = "SELECT * FROM ".DB_TABLEPRE.$_GET['modid']."  WHERE id = '".$_GET['viewid']."'";
		$row = $db->fetch_one_array($sql);
			//获取当前流程
			$sql = "SELECT a.*,b.flowname,b.flownum,b.flowuser,b.flowkey,b.flowkey1,b.flowkey2,b.flowkey3 FROM ".DB_TABLEPRE."crm_personnel a,".DB_TABLEPRE."crm_flow b  WHERE a.flowid=b.fid and a.viewid = '".$_GET['viewid']."' and a.modid = '".$_GET['modid']."' and (a.pertype=0 or a.pertype=4) order by a.perid desc";
			$per = $db->fetch_one_array($sql);
			if($per['flowkey']!='2'){
				//获取下一步流程
				$sql = "SELECT * FROM ".DB_TABLEPRE."crm_flow  WHERE flownum >'".$per['flownum']."' and modid='".$_GET['modid']."' order by flownum asc";
				$flow = $db->fetch_one_array($sql);
			}
			$perlnums = $db->result("SELECT COUNT(*) AS perlnums FROM ".DB_TABLEPRE."crm_personnel_log where perid='".$per['perid']."' and pertype=0 and viewid = '".$_GET['viewid']."' and modid='".$_GET['modid']."'");
			if($per['appkey']==1 && $per['appkey1']==1){
				$wherestr=$perlnums<2 && $per['flowkey']!=2;
			}else{
				$wherestr=$per['flowkey']!=2;
			}
		include_once('mana/personnel.php');
	}
}
?>