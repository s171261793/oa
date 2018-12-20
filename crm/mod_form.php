<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
get_key("crm_form");
$modlist='crm_company,crm_contact,crm_service,crm_care,crm_complaints,crm_product,crm_stock,crm_business,crm_supplier,crm_purchase,crm_offer,crm_program,crm_contract,crm_order,crm_price,crm_payment';
$r=explode(',',$modlist);
if($_GET["type1"]=='') $_GET["type1"]='crm_company';
if($_GET["type1"]!=''){
	$crm_form_type=form_mod($_GET["type1"]);
}else{
	$crm_form_type='';
}
empty($do) && $do = 'list';
if ($do == 'list') {
	//列表信息 
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&type1='.$_GET["type1"].'';
	
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."crm_form WHERE type1='".$_GET["type1"]."'  ");
    $sql = "SELECT * FROM ".DB_TABLEPRE."crm_form WHERE type1='".$_GET["type1"]."' ORDER BY inputnumber ASC LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	include_once('mana/form.php');

}elseif ($do == '删 除') {
	$idarr = getGP('id','P','array');
	foreach ($idarr as $id) {
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_form WHERE fid = '$id' ");
	}
	$content=serialize($idarr);
	$title='删除CRM表单';
	get_logadd($id,$content,$title,36,$_USER->id);	
	oa_where_recache('crm_form','id','inputnumber',"type1='".$_GET[type1]."'",$_GET[type1]);
	show_msg('删除CRM表单成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&type1='.$_GET["type1"].'');

}elseif ($do == '排 序') {
	
	$idarr = getGP('id','P','array');
	$inputnumberarr = getGP('inputnumber','P','array');
	foreach ($idarr as $id) {
		if($inputnumberarr[$id]!='0'){
			$db->query("update ".DB_TABLEPRE."crm_form set inputnumber='".$inputnumberarr[$id]."'  WHERE fid = '$id' ");
		}else{
			$db->query("update ".DB_TABLEPRE."crm_form set inputnumber='999'  WHERE fid = '$id' ");
		}
	}
	oa_where_recache('crm_form','id','inputnumber',"type1='".$_GET[type1]."'",$_GET[type1]);
	$content=serialize($idarr);
	$title='更新CRM表单';
	get_logadd($id,$content,$title,36,$_USER->id);	
	show_msg('更新CRM表单成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&type1='.$_GET["type1"].'');

}elseif ($do == 'add') {
	if($_POST['view']!=''){
		$formname = getGP('formname','P');
		$filenumber=random(4,'0123456789').'_'.get_date('ymdHis',PHP_TIME);
		$inputname = "toa_".getGP('type1','P').$filenumber;
		$inputvalue = getGP('inputvalue','P');
		$type = getGP('type','P');
		$inputtype = getGP('inputtype','P');
		$inputvaluenum = getGP('inputvaluenum','P');
		$confirmation = getGP('confirmation','P');
		$type1 = getGP('type1','P');
		$type2 = getGP('type2','P');
		$w = getGP('w','P');
		$h = getGP('h','P');
		//主表信息
		$crm_form = array(
			'formname' => $formname,
			'inputname' => $inputname,
			'inputvalue' => $inputvalue,
			'type' => $type,
			'inputtype' => $inputtype,
			'inputvaluenum' => $inputvaluenum,
			'confirmation' => $confirmation,
			'type1' => $type1,
			'type2' => $type2,
			'inputnumber'=>999,
			'w' => $w,
			'h' => $h
		);
		//写入主表信息
		insert_db('crm_form',$crm_form);
		$id=$db->insert_id();
		oa_where_recache('crm_form','fid','inputnumber',"type1='".$type1."'",$type1);
		$content=serialize($crm_form);
		$title='添加CRM表单';
		get_logadd($id,$content,$title,36,$_USER->id);
		show_msg('添加CRM表单成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&type1='.$type1.'');
	}else{
		include_once('mana/form_add.php');
	}
}elseif ($do == 'edit') {
	if($_POST['view']!=''){
		$fid = getGP('fid','P','int');
		$formname = getGP('formname','P');
		$inputvalue = getGP('inputvalue','P');
		$type = getGP('type','P');
		$inputtype = getGP('inputtype','P');
		$inputvaluenum = getGP('inputvaluenum','P');
		$confirmation = getGP('confirmation','P');
		$type1 = getGP('type1','P');
		$type2 = getGP('type2','P');
		$w = getGP('w','P');
		$h = getGP('h','P');
		//主表信息
		$crm_form = array(
			'formname' => $formname,
			'inputvalue' => $inputvalue,
			'type' => $type,
			'inputtype' => $inputtype,
			'inputvaluenum' => $inputvaluenum,
			'confirmation' => $confirmation,
			'type2' => $type2,
			'w' => $w,
			'h' => $h
		);
		update_db('crm_form',$crm_form, array('fid' => $fid));
		oa_where_recache('crm_form','fid','inputnumber',"type1='".$type1."'",$type1);
		$id=$db->insert_id();
		$content=serialize($crm_form);
		$title='编辑CRM表单';
		get_logadd($id,$content,$title,36,$_USER->id);
		show_msg('编辑CRM表单成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&type1='.$type1.'');
	}else{
		$blog = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_form  WHERE fid = '".$_GET['fid']."' ");
		include_once('mana/form_edit.php');
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