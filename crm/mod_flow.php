<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
get_key("crm_flow");
$modlist='crm_purchase,crm_offer,crm_program,crm_contract,crm_order,crm_price,crm_payment';
$r=explode(',',$modlist);
$modid=$_GET['modid'];
if($modid==''){
	$modid='crm_purchase';
}
empty($do) && $do = 'list';
if ($do == 'list') {
	$flow = $db->fetch_one_array("SELECT flownum FROM ".DB_TABLEPRE."crm_flow WHERE modid='".$modid."' ORDER BY fid asc LIMIT 1");
	if($flow['flownum']!='1'){
		$crm_flow = array(
			'flowname' => '申请人提交申请',
			'flownum' => 1,
			'flowkey' => 1,
			'flowkey1' => 1,
			'flowkey2' => 2,
			'flowkey3' => 2,
			'modid' => $modid
			);
		insert_db('crm_flow',$crm_flow);
	}
	//列表信息 
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&modid='.$modid.'';
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."crm_flow WHERE modid='".$modid."' order by fid asc");
     $sql = "SELECT * FROM ".DB_TABLEPRE."crm_flow WHERE modid='".$modid."' order by fid asc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	include_once('mana/flow.php');

} elseif ($do == 'update') {
	$idarr = getGP('id','P','array');
	foreach ($idarr as $id) {
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_flow WHERE fid = '$id' ");
		$query = $db->query("SELECT perid FROM ".DB_TABLEPRE."crm_personnel where flowid='".$id."' ORDER BY perid Asc");
		while ($log = $db->fetch_array($query)) {
			$db->query("DELETE FROM ".DB_TABLEPRE."crm_personnel_log WHERE perid = '".$log['perid']."' ");
		}
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_personnel WHERE flowid = '$id' ");			
	}
	$content=serialize($idarr);
	$title='删除审批流程';
	get_logadd($id,$content,$title,14,$_USER->id);
	show_msg('审批流程信息删除成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&modid='.$modid.'');

}elseif ($do == 'add') {
	if($_POST['view']!=''){
		$fid = getGP('fid','P','int');
		if($fid!=''){
			$flowname = check_str(getGP('flowname','P'));
			$flownum = check_str(getGP('flownum','P'));
			$flowuser = check_str(getGP('flowuser','P'));
			$flowkey = getGP('flowkey','P');
			$flowkey1 = getGP('flowkey1','P');
			$flowkey2 = getGP('flowkey2','P');
			$flowkey3 = getGP('flowkey3','P');
			if($flowkey3==''){
				$flowkey3='2';
			}
			$crm_flow = array(
				'flowname' => $flowname,
				'flowuser' => $flowuser,
				'flowkey' => $flowkey,
				'flowkey1' => $flowkey1,
				'flowkey2' => $flowkey2,
				'flowkey3' => $flowkey3
			);
			update_db('crm_flow',$crm_flow, array('fid' => $fid));
			$content='';
			$content=serialize($crm_flow);
			$title='审批流程信息';
			get_logadd($id,$content,$title,36,$_USER->id);
			
		}else{
			$flowname = check_str(getGP('flowname','P'));
			$flownum = check_str(getGP('flownum','P'));
			$flowuser = check_str(getGP('flowuser','P'));
			$flowkey = getGP('flowkey','P');
			$flowkey1 = getGP('flowkey1','P');
			$flowkey2 = getGP('flowkey2','P');
			$flowkey3 = getGP('flowkey3','P');
			if($flowkey3==''){
				$flowkey3='2';
			}
			$crm_flow = array(
				'flowname' => $flowname,
				'flownum' => $flownum,
				'flowuser' => $flowuser,
				'modid' => $modid,
				'flowkey' => $flowkey,
				'flowkey1' => $flowkey1,
				'flowkey2' => $flowkey2,
				'flowkey3' => $flowkey3
			);
			insert_db('crm_flow',$crm_flow);
			$id=$db->insert_id();
			$content=serialize($crm_flow);
			$title='审批流程信息';
			get_logadd($id,$content,$title,36,$_USER->id);
		}
		show_msg('审批流程信息操作成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&modid='.$modid.'');
	}else{
		$fid = getGP('fid','G','int');
		if($fid!=''){
			$user = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_flow  WHERE fid = '$fid'");
			$flownum=$user['flownum'];
			$_title['name']='编辑';
		}else{ 
			$apps = $db->fetch_one_array("SELECT flownum FROM ".DB_TABLEPRE."crm_flow WHERE modid='".$modid."' ORDER BY fid desc LIMIT 1");
			$flownum=$apps["flownum"]+1;
			$user['flowkey']=1;
			$user['flowkey1']='1';
			$user['flowkey2']=2;
			$_title['name']='发布';
		}
		include_once('mana/flowadd.php');
	}
}


function form_mod($mod=''){
	switch ($mod)
	{
		case 'crm_company':
		  return "客户信息";
		  break;
		case 'crm_contact':
		  return "联系人";
		  break;
		case 'crm_service':
		  return "客户回访";
		  break;
		case 'crm_care':
		  return "客户关怀";
		  break;
		case 'crm_complaints':
		  return "客户投诉";
		  break;
		case 'crm_product':
		  return "产品信息";
		  break;
		case 'crm_stock':
		  return "库存";
		  break;
		case 'crm_business':
		  return "代理商";
		  break;
		case 'crm_supplier':
		  return "供应商";
		  break;
		case 'crm_purchase':
		  return "采购单";
		  break;
		case 'crm_offer':
		  return "报价单";
		  break;
		case 'crm_program':
		  return "解决方案";
		  break;
		case 'crm_contract':
		  return "合同";
		  break;
		case 'crm_order':
		  return "订单";
		  break;
		case 'crm_price':
		  return "收款单";
		  break;
		case 'crm_payment':
		  return "付款单";
		  break;
		default:
		  return "错误类型";
	}
	return ;
}
?>