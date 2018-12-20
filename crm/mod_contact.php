<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
empty($do) && $do = 'list';
require('function/form.php');
if ($do == 'list') {
	//列表信息
	if($_GET['type']=='2'){ 
		get_key("crm_contact_2");
	}else{
		get_key("crm_contact_1");
	}
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&type='.$_GET['type'];
	if ($type = getGP('type','G')) {
		$wheresql .= " AND a.type='".$type."'";
	}else{
		$wheresql .= " AND a.type='1'";
		$type=1;
	}
	if ($cid = getGP('cid','G')) {
		$wheresql .= " AND a.cid='".$cid."'";
		$url .= '&cid='.rawurlencode($cid);
	}
	if ($name = getGP('name','G')) {
		$wheresql .= " AND a.name LIKE'%".$name."%'";
		$url .= '&name='.rawurlencode($name);
	}
	//权限判断
	$un = getGP('un','G');
	$ui = getGP('ui','G');
	if(!is_superadmin() && $ui==''){
		$wheresql .= " and (a.uid='".$_USER->id."' or b.user='".get_realname($_USER->id)."')";
	}
	if ($ui!='') {
		$wheresql .= " and (a.uid in(".$ui.") or b.user in('".str_replace(",","','",$un)."'))";
		$url .= '&ui='.$ui.'&un='.$un;
	}
	$vstartdate = getGP('vstartdate','G');
	$venddate = getGP('venddate','G');
	if ($vstartdate!='' && $venddate!='') {
		$wheresql .= " AND (a.date>='".$vstartdate."' and a.date<='".$venddate."')";
		$url .= '&vstartdate='.$vstartdate.'&venddate='.$venddate;
	}
	//处理表单数据
	$fromkeywordarr = getGP('fromkeyword','G','array');
	$kinputname = getGP('kinputname','G','array');
	$arrcid = array();
	$nums=0;
	foreach ($kinputname as $inputname) {
		$fromkeyword[$inputname]=$fromkeywordarr[$inputname];
		if($fromkeywordarr[$inputname]!=''){
			$nums++;
			//获取企业ID
			$sql = "SELECT * FROM ".DB_TABLEPRE."crm_db WHERE type='crm_contact' and inputname ='".$inputname."' and content LIKE '%".trim($fromkeywordarr[$inputname])."%'  ORDER BY did desc";
			$query = $db->query($sql);
			while ($row = $db->fetch_array($query)) {
				$arrcid[]= $row['viewid'];
			}
		}
		
	}
	if($nums>0){
		$arrcid1=array_unique($arrcid);//去掉重复
		//print_r(array_count_values($arrcid));
		$arrcids=array_count_values($arrcid);//获取重复数量
		rsort($arrcids);
		$idnum=0;
		$whsql='ssss';
		for($i=0;$i<count($arrcid1);$i++){
			if($arrcids[$i]==$nums){
				$idnum++;
				$whsql .=" or a.id=".$arrcid[$i];
			}
		}
		if($idnum<=0 && $number=='' && $vstartdate=='' && $title==''){
			$wheresql .=" and a.id=0";
		}else{
			if($idnum>0){
				$sqlstrname=str_replace('ssss or','',$whsql);
				$wheresql .=" and (".str_replace('ssss','',$sqlstrname).")";
			}
		}
	}
	$ischeck = getGP('ischeck','G');
	$url .= '&ischeck='.$ischeck;
	if ($ischeck=='1') {
		$wheresql .= " AND DATE_SUB(CURDATE(), INTERVAL 1 DAY)<=date(a.date) ";		
	}
	if ($ischeck=='2') {
		$wheresql .= " AND DATE_SUB(CURDATE(), INTERVAL 3 DAY)<=date(a.date) ";	
	}
	if ($ischeck=='3') {
		$wheresql .= " AND DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=date(a.date) ";	
	}
	if ($ischeck=='4') {
		$wheresql .= " AND DATE_SUB(CURDATE(),INTERVAL 1 MONTH)<=date(a.date) ";	
	}
	if ($ischeck=='5') {
		$wheresql .= " AND DATE_SUB(CURDATE(),INTERVAL 6 MONTH)<=date(a.date) ";	
	}
	if($type==1){
		$company='crm_company';
	}else{
		$company='crm_business';
	}
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."crm_contact a,".DB_TABLEPRE.$company." b WHERE 1 $wheresql and a.cid=b.id");
    $sql = "SELECT a.*,b.title FROM ".DB_TABLEPRE."crm_contact a,".DB_TABLEPRE.$company." b WHERE 1 $wheresql  and a.cid=b.id ORDER BY a.id desc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	//表单
	$companylist = array();
	$sql = "SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_contact' and type in('0','3','4','5') and inputtype in('1','2','3','5') ORDER BY inputnumber Asc";
	$query = $db->query($sql);
	while ($row = $db->fetch_array($query)) {
		$companylist[] = $row;
	}
	//表单汇总
	$fromnum = $db->result("SELECT COUNT(*) AS fromnum FROM ".DB_TABLEPRE."crm_form where type1='crm_contact' and type2='1' ORDER BY inputnumber Asc");
	include_once('company/contact.php');

} elseif ($do == 'update') {
	if($_POST['type']=='2'){ 
		get_key("crm_contact_del_2");
	}else{
		get_key("crm_contact_del_1");
	}
	$idarr = getGP('id','P','array');
	foreach ($idarr as $id) {
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_contact WHERE id = '$id' ");
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_db WHERE type='crm_contact' and viewid= '$id' ");
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_log WHERE modid='crm_contact' and viewid= '$id' ");	
	}
	$content=serialize($idarr);
	$title='删除联系人信息';
	get_logadd($id,$content,$title,36,$_USER->id);
    show_msg('联系人信息删除成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&type='.$_POST['type'].'&cid='.$_POST['cid'].'');

}elseif ($do == 'excel') {
	if($_POST['type']=='2'){ 
		get_key("crm_contact_excel_2");
	}else{
		get_key("crm_contact_excel_1");
	}
	$datename="contact_".get_date('YmdHis',PHP_TIME);
	$outputFileName = 'data/excel/'.$datename.'.xls';
			$wheresql = '';
			if ($type = getGP('type','P')) {
				$wheresql .= " AND a.type='".$type."'";
			}else{
				$wheresql .= " AND a.type='1'";
			}
			if ($cid = getGP('cid','P')) {
				$wheresql .= " AND a.cid='".$cid."'";
			}
			if ($name = getGP('name','P')) {
				$wheresql .= " AND a.name LIKE'%".$name."%'";
			}
			//权限判断
			$un = getGP('un','P');
			$ui = getGP('ui','P');
			if(!is_superadmin() && $ui==''){
				$wheresql .= " and (a.uid='".$_USER->id."' or b.user='".get_realname($_USER->id)."')";
			}
			if ($ui!='') {
				$wheresql .= " and (a.uid in(".$ui.") or b.user in('".str_replace(",","','",$un)."'))";
			}
			$vstartdate = getGP('vstartdate','P');
			$venddate = getGP('venddate','P');
			if ($vstartdate!='' && $venddate!='') {
				$wheresql .= " AND (a.date>='".$vstartdate."' and a.date<='".$venddate."')";
			}
			//处理表单数据
			$fromkeywordarr = getGP('fromkeyword','P','array');
			$kinputname = getGP('kinputname','P','array');
			$arrcid = array();
			$nums=0;
			foreach ($kinputname as $inputname) {
				$fromkeyword[$inputname]=$fromkeywordarr[$inputname];
				if($fromkeywordarr[$inputname]!=''){
					$nums++;
					//获取企业ID
					$sql = "SELECT * FROM ".DB_TABLEPRE."crm_db WHERE type='crm_contact' and inputname ='".$inputname."' and content LIKE '%".trim($fromkeywordarr[$inputname])."%'  ORDER BY did desc";
					$query = $db->query($sql);
					while ($row = $db->fetch_array($query)) {
						$arrcid[]= $row['viewid'];
					}
				}
				
			}
			if($nums>0){
				$arrcid1=array_unique($arrcid);//去掉重复
				//print_r(array_count_values($arrcid));
				$arrcids=array_count_values($arrcid);//获取重复数量
				rsort($arrcids);
				$idnum=0;
				$whsql='ssss';
				for($i=0;$i<count($arrcid1);$i++){
					if($arrcids[$i]==$nums){
						$idnum++;
						$whsql .=" or a.id=".$arrcid[$i];
					}
				}
				if($idnum<=0 && $number=='' && $vstartdate=='' && $title==''){
					$wheresql .=" and a.id=0";
				}else{
					if($idnum>0){
						$sqlstrname=str_replace('ssss or','',$whsql);
						$wheresql .=" and (".str_replace('ssss','',$sqlstrname).")";
					}
				}
			}
			$ischeck = getGP('ischeck','P');
			if ($ischeck=='1') {
				$wheresql .= " AND DATE_SUB(CURDATE(), INTERVAL 1 DAY)<=date(a.date) ";		
			}
			if ($ischeck=='2') {
				$wheresql .= " AND DATE_SUB(CURDATE(), INTERVAL 3 DAY)<=date(a.date) ";	
			}
			if ($ischeck=='3') {
				$wheresql .= " AND DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=date(a.date) ";	
			}
			if ($ischeck=='4') {
				$wheresql .= " AND DATE_SUB(CURDATE(),INTERVAL 1 MONTH)<=date(a.date) ";	
			}
			if ($ischeck=='5') {
				$wheresql .= " AND DATE_SUB(CURDATE(),INTERVAL 6 MONTH)<=date(a.date) ";	
			}
			if($type==1){
				$company='crm_company';
			}else{
				$company='crm_business';
			}
			$sql = "SELECT a.*,b.title FROM ".DB_TABLEPRE."crm_contact a,".DB_TABLEPRE.$company." b WHERE 1 $wheresql  and a.cid=b.id ORDER BY a.id desc";
			//获取表单
			$archive = array();
			$inputname = array();
			$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_contact'  ORDER BY inputnumber Asc");
			$archive[]="<b>公司名称</b>";
			$archive[]="<b>联系人</b>";
			$num=0;
			while ($row = $db->fetch_array($query)) {
				$num++;
				$archive[]="<b>".$row['formname']."</b>";
				$inputname[]=$row['inputname'];
			}
			$archive[]="<b>发布人</b>";
			$archive[]="<b>发布时间</b>";
			$content = array();
			$content[] = $archive;
			//$sql = "SELECT * FROM ".DB_TABLEPRE."crm_contact WHERE 1 $wheresql  ORDER BY id desc";
			$result = $db->query($sql);
			while ($row = $db->fetch_array($result)) {	
				$archive = array();
				$archive[]=$row['title'];
				$archive[]=$row['name'];
				for($i=0;$i<$num;$i++){
					$blog = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_db  WHERE viewid = '".$row['id']."' and inputname='".$inputname[$i]."' and type='crm_contact' ");
					if($blog['type']=='3'){
						$archive[]=str_replace("-",".",$blog['content']);
					}else{
						$archive[]=$blog['content'];
					}
				}
				
				$archive[]=get_realname($row['uid']);
				$archive[]=str_replace("-",".",$row['date']);
				$content[] = $archive;
		}
	$excel = new ExcelWriter($outputFileName);
	if($excel==false) 
		echo $excel->error; 
	foreach($content as $v){
		$excel->writeLine($v);
	}
	$excel->sendfile($outputFileName);
}elseif ($do == 'add'){
	if($_POST['view']!=''){
		//固定选项
		$name = check_str(getGP('name','P'));
		$cid = getGP('cid','P');
		$type = getGP('type','P');
		if($type=='') $type=1;
		$uid = $_USER->id;
		$date=get_date('Y-m-d H:i:s',PHP_TIME);
		//写入主表信息
		$crm_contact = array(
			'name' => $name,
			'cid' => $cid,
			'type' => $type,
			'type1' => 2,
			'uid' => $uid,
			'date' => $date
		);
		insert_db('crm_contact',$crm_contact);
		$vid=$db->insert_id();
		//写入单项数据
		global $db;
		$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_contact' ORDER BY inputnumber Asc");
		while ($row = $db->fetch_array($query)) {
			if($row['inputtype']=='4'){
				$inputvalues='';
				$inputvalue=getGP(''.$row["inputname"].'','P','array');
				foreach ($inputvalue as $arrsave) {
					$inputvalues.=$arrsave.',';
				}
				$inputvalue=substr($inputvalues, 0, -1);
			}elseif($row['inputtype']=='2'){
				$inputvalue=trim(getGP(''.$row["inputname"].'','P'));
			}else{
				$inputvalue=check_str(getGP(''.$row["inputname"].'','P'));
			}
			$crm_db = array(
					'inputname' => $row["inputname"],
					'content' => $inputvalue,
					'viewid' => $vid,
					'formid' => $row["fid"],
					'type' => 'crm_contact'
				);
			insert_db('crm_db',$crm_db);
			$crm_log.=serialize($crm_db).'|515158.com|';
		}
		$content=serialize($crm_contact);
		$title=get_realname($_USER->id).'于'.get_date('Y-m-d H:i:s',PHP_TIME).'新建联系人信息';
		get_logadd($vid,$content,$title,36,$_USER->id);
		crm_log($title,$vid,$content,substr($crm_log, 0, -12),1,'crm_contact');
		show_msg('新建联系人信息成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&type='.$type);
	}else{
		if($_GET['type']=='2'){ 
			get_key("crm_contact_add_2");
		}else{
			get_key("crm_contact_add_1");
		}
		include_once('company/contact_add.php');
	}
}elseif ($do == 'edit'){
	if($_POST['view']!=''){
		//固定选项
		$name = check_str(getGP('name','P'));
		$vid = getGP('id','P');
		//写入主表信息
		$crm_contact = array(
			'name' => $name
		);
		update_db('crm_contact',$crm_contact, array('id' => $vid));
		//写入单项数据
		global $db;
		$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_contact' ORDER BY inputnumber Asc");
		while ($row = $db->fetch_array($query)) {
			if($row['inputtype']=='4'){
				$inputvalues='';
				$inputvalue=getGP(''.$row["inputname"].'','P','array');
				foreach ($inputvalue as $arrsave) {
					$inputvalues.=$arrsave.',';
				}
				$inputvalue=substr($inputvalues, 0, -1);
			}elseif($row['inputtype']=='2'){
				$inputvalue=trim(getGP(''.$row["inputname"].'','P'));
			}else{
				$inputvalue=check_str(getGP(''.$row["inputname"].'','P'));
			}
			$crm_db = array(
					'content' => $inputvalue
				);
			//insert_db('crm_db',$crm_db);
			update_db('crm_db',$crm_db, array('viewid' => $vid,'type' => 'crm_contact','inputname' => $row["inputname"],'formid' => $row["fid"]));
			$crm_log.=serialize($crm_db).'|515158.com|';
		}
		$content=serialize($crm_contact);
		$title=get_realname($_USER->id).'于'.get_date('Y-m-d H:i:s',PHP_TIME).'编辑联系人信息';
		get_logadd($vid,$content,$title,36,$_USER->id);
		crm_log($title,$vid,$content,substr($crm_log, 0, -12),1,'crm_contact');
		show_msg('编辑联系人信息成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&type='.getGP('type','P'));
	}else{
		if($_GET['type']=='2'){ 
			get_key("crm_contact_edit_2");
		}else{
			get_key("crm_contact_edit_1");
		}
		$view = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_contact  WHERE id = '".getGP('id','G','int')."' ");
		include_once('company/contact_edit.php');
	}
}elseif ($do == 'view'){
	if($_GET['type']=='2'){ 
		get_key("crm_contact_2");
	}else{
		get_key("crm_contact_1");
	}
	$view = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_contact  WHERE id = '".getGP('id','G','int')."' ");
	include_once('company/contact_view.php');
}
?>