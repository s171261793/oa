<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
empty($do) && $do = 'list';
require('function/form.php');
get_key("crm_company");
if ($do == 'list') {
	if($_GET['cok']=='' && getGP('page','G','int')==''){
		setcookie('whesql',"");
	}
	//列表信息 
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'';
	if ($number = getGP('number','G')) {
		$wheresql .= " AND number='".$number."'";
		$url .= '&number='.rawurlencode($number);
	}
	if ($bid = getGP('bid','G')) {
		$wheresql .= " AND bid='".$bid."'";
		$url .= '&bid='.rawurlencode($bid);
	}
	if ($title = getGP('title','G')) {
		$wheresql .= " AND title LIKE'%".$title."%'";
		$url .= '&title='.rawurlencode($title);
	}
	//权限判断
	$un = getGP('un','G');
	$ui = getGP('ui','G');
	if(!is_superadmin() && $ui==''){
		$wheresql .= " and (uid='".$_USER->id."' or user='".get_realname($_USER->id)."')";
	}
	if ($ui!='') {
		$wheresql .= " and (uid in(".$ui.") or user in('".str_replace(",","','",$un)."'))";
		$url .= '&ui='.$ui.'&un='.$un;
	}
	//权限结束
	$vstartdate = getGP('vstartdate','G');
	$venddate = getGP('venddate','G');
	if ($vstartdate!='' && $venddate!='') {
		$wheresql .= " AND (date>='".$vstartdate."' and date<='".$venddate."')";
		$url .= '&vstartdate='.$vstartdate.'&venddate='.$venddate;
	}
	//处理表单数据
	if($_GET['cok']!=''){
		$fromkeywordarr = getGP('fromkeyword','G','array');
		$kinputname = getGP('kinputname','G','array');
		$arrcid = array();
		$nums=0;
		foreach ($kinputname as $inputname) {
			$fromkeyword[$inputname]=$fromkeywordarr[$inputname];
			if($fromkeywordarr[$inputname]!=''){
				$nums++;
				//获取企业ID
				$sql = "SELECT * FROM ".DB_TABLEPRE."crm_db WHERE type='crm_company' and inputname ='".$inputname."' and content LIKE '%".trim($fromkeywordarr[$inputname])."%'  ORDER BY did desc";
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
					$whsql .=" or id=".$arrcid[$i];
				}
			}
			if($idnum<=0 && $number=='' && $vstartdate=='' && $title=='' && $user=='' && $bid==''){
				$wheresql .=" and id=0";
				setcookie('whesql'," and id=0");
			}else{
				if($idnum>0){
					$sqlstrname=str_replace('ssss or','',$whsql);
					$wheresql .=" and (".str_replace('ssss','',$sqlstrname).")";
					setcookie('whesql'," and (".str_replace('ssss','',$sqlstrname).")");
				}
			}
		}
	
	}else{
		$wheresql .=$_COOKIE['whesql'];
	}
	$ischeck = getGP('ischeck','G');
	$url .= '&ischeck='.$ischeck;
	if ($ischeck=='1') {
		$wheresql .= " AND DATE_SUB(CURDATE(), INTERVAL 1 DAY)<=date(date) ";		
	}
	if ($ischeck=='2') {
		$wheresql .= " AND DATE_SUB(CURDATE(), INTERVAL 3 DAY)<=date(date) ";	
	}
	if ($ischeck=='3') {
		$wheresql .= " AND DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=date(date) ";	
	}
	if ($ischeck=='4') {
		$wheresql .= " AND DATE_SUB(CURDATE(),INTERVAL 1 MONTH)<=date(date) ";	
	}
	if ($ischeck=='5') {
		$wheresql .= " AND DATE_SUB(CURDATE(),INTERVAL 6 MONTH)<=date(date) ";	
	}
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."crm_company WHERE 1 $wheresql");
    $sql = "SELECT * FROM ".DB_TABLEPRE."crm_company WHERE 1 $wheresql ORDER BY id desc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	//表单
	$companylist = array();
	$sql = "SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_company' and type in('0','3','4','5') and inputtype in('1','2','3','5') ORDER BY inputnumber Asc";
	$query = $db->query($sql);
	while ($row = $db->fetch_array($query)) {
		$companylist[] = $row;
	}
	//表单汇总
	$fromnum = $db->result("SELECT COUNT(*) AS fromnum FROM ".DB_TABLEPRE."crm_form where type1='crm_company' and type2='1' ORDER BY inputnumber Asc");
	include_once('company/company.php');

} elseif ($do == 'update') {
	get_key("crm_company_del");
	$idarr = getGP('id','P','array');
	foreach ($idarr as $id) {
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_company WHERE id = '$id' ");
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_db WHERE type='crm_company' and viewid= '$id' ");
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_log WHERE modid='crm_company' and viewid= '$id' ");	
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_contact WHERE type='1' and cid= '$id' ");
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_service WHERE cid= '$id' ");
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_care WHERE type='1' and cid= '$id' ");
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_complaints WHERE type='1' and cid= '$id' ");
	}
	$content=serialize($idarr);
	$title='删除客户信息';
	get_logadd($id,$content,$title,36,$_USER->id);
    show_msg('客户信息删除成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');

}elseif ($do == 'excel') {
	get_key("crm_company_excel");
	$datename="company_".get_date('YmdHis',PHP_TIME);
	$outputFileName = 'data/excel/'.$datename.'.xls';
			$wheresql = '';
			if ($number = getGP('number','P')) {
				$wheresql .= " AND number='".$number."'";
			}
			if ($title = getGP('title','P')) {
				$wheresql .= " AND title LIKE'%".$title."%'";
			}
			if ($bid = getGP('bid','P')) {
				$wheresql .= " AND bid='".$bid."'";
				$url .= '&bid='.rawurlencode($bid);
			}
			//权限判断
			$un = getGP('un','P');
			$ui = getGP('ui','P');
			if(!is_superadmin() && $ui==''){
				$wheresql .= " and (uid='".$_USER->id."' or user='".get_realname($_USER->id)."')";
			}
			if ($ui!='') {
				$wheresql .= " and (uid in(".$ui.") or user in('".str_replace(",","','",$un)."'))";
			}
			$vstartdate = getGP('vstartdate','P');
			$venddate = getGP('venddate','P');
			if ($vstartdate!='' && $venddate!='') {
				$wheresql .= " AND (date>='".$vstartdate."' and date<='".$venddate."')";
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
					$sql = "SELECT * FROM ".DB_TABLEPRE."crm_db WHERE type='crm_company' and inputname ='".$inputname."' and content LIKE '%".trim($fromkeywordarr[$inputname])."%'  ORDER BY did desc";
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
						$whsql .=" or id=".$arrcid[$i];
					}
				}
				if($idnum<=0 && $number=='' && $vstartdate=='' && $title==''){
					$wheresql .=" and id=0";
				}else{
					if($idnum>0){
						$sqlstrname=str_replace('ssss or','',$whsql);
						$wheresql .=" and (".str_replace('ssss','',$sqlstrname).")";
					}
				}
			}
			$ischeck = getGP('ischeck','P');
			if ($ischeck=='1') {
				$wheresql .= " AND DATE_SUB(CURDATE(), INTERVAL 1 DAY)<=date(date) ";		
			}
			if ($ischeck=='2') {
				$wheresql .= " AND DATE_SUB(CURDATE(), INTERVAL 3 DAY)<=date(date) ";	
			}
			if ($ischeck=='3') {
				$wheresql .= " AND DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=date(date) ";	
			}
			if ($ischeck=='4') {
				$wheresql .= " AND DATE_SUB(CURDATE(),INTERVAL 1 MONTH)<=date(date) ";	
			}
			if ($ischeck=='5') {
				$wheresql .= " AND DATE_SUB(CURDATE(),INTERVAL 6 MONTH)<=date(date) ";	
			}
			//获取表单
			$archive = array();
			$inputname = array();
			$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_company'  ORDER BY inputnumber Asc");
			$archive[]="<b>客户编号</b>";
			$archive[]="<b>客户名称</b>";
			$archive[]="<b>业务人员</b>";
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
			$sql = "SELECT * FROM ".DB_TABLEPRE."crm_company WHERE 1 $wheresql  ORDER BY id desc";
			$result = $db->query($sql);
			while ($row = $db->fetch_array($result)) {	
				$archive = array();
				$archive[]=$row['number'];
				$archive[]=$row['title'];
				$archive[]=$row['user'];
				for($i=0;$i<$num;$i++){
					$blog = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_db  WHERE viewid = '".$row['id']."' and inputname='".$inputname[$i]."' and type='crm_company' ");
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
	get_key("crm_company_add");
	if($_POST['view']!=''){
		//固定选项
		$number = check_str(getGP('number','P'));
		$title = check_str(getGP('title','P'));
		$user = getGP('user','P');
		$bid = getGP('bid','P');
		$uid = $_USER->id;
		$date=get_date('Y-m-d H:i:s',PHP_TIME);
		$addnum = $db->result("SELECT COUNT(*) AS addnum FROM ".DB_TABLEPRE."crm_company WHERE title='".trim($title)."'");
		if($addnum>0){
			show_msg('对不起！你发布的信息名称己经存在，请重新发布！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=add');
		}
		//写入主表信息
		$crm_company = array(
			'number' => $number,
			'title' => $title,
			'user' => $user,
			'bid' => $bid,
			'uid' => $uid,
			'date' => $date
		);
		insert_db('crm_company',$crm_company);
		$vid=$db->insert_id();
		//写入单项数据
		global $db;
		$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_company' ORDER BY inputnumber Asc");
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
					'type' => 'crm_company'
				);
			insert_db('crm_db',$crm_db);
			$crm_log.=serialize($crm_db).'|515158.com|';
		}
		$content=serialize($crm_company);
		$title=get_realname($_USER->id).'于'.get_date('Y-m-d H:i:s',PHP_TIME).'新建客户信息';
		get_logadd($vid,$content,$title,36,$_USER->id);
		crm_log($title,$vid,$content,substr($crm_log, 0, -12),1,'crm_company');
		
		
		//处理联系人数据 
		
		$name = check_str(getGP('name','P'));
		$uid = $_USER->id;
		$date=get_date('Y-m-d H:i:s',PHP_TIME);
		//写入主表信息
		$crm_contact = array(
			'name' => $name,
			'cid' => $vid,
			'type' => 1,
			'type1' => 1,
			'uid' => $uid,
			'date' => $date
		);
		insert_db('crm_contact',$crm_contact);
		$pid=$db->insert_id();
		$crm_log='';
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
					'viewid' => $pid,
					'formid' => $row["fid"],
					'type' => 'crm_contact'
				);
			insert_db('crm_db',$crm_db);
			$crm_log.=serialize($crm_db).'|515158.com|';
		}
		$content=serialize($crm_contact);
		$title=get_realname($_USER->id).'于'.get_date('Y-m-d H:i:s',PHP_TIME).'新建联系人信息';
		get_logadd($pid,$content,$title,36,$_USER->id);
		crm_log($title,$pid,$content,substr($crm_log, 0, -12),1,'crm_contact');
		show_msg('新建客户信息成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
	}else{
		include_once('company/company_add.php');
	}
}elseif ($do == 'edit'){
	get_key("crm_company_edit");
	if($_POST['view']!=''){
		//固定选项
		$number = check_str(getGP('number','P'));
		$title = check_str(getGP('title','P'));
		$user = getGP('user','P');
		$vid = getGP('id','P');
		$bid = getGP('bid','P');
		//写入主表信息
		$crm_company = array(
			'number' => $number,
			'title' => $title,
			'user' => $user,
			'bid' => $bid
		);
		update_db('crm_company',$crm_company, array('id' => $vid));
		//写入单项数据
		global $db;
		$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_company' ORDER BY inputnumber Asc");
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
			update_db('crm_db',$crm_db, array('viewid' => $vid,'type' =>'crm_company','inputname' => $row["inputname"],'formid' => $row["fid"]));
			$crm_log.=serialize($crm_db).'|515158.com|';
		}
		$content=serialize($crm_company);
		$title=get_realname($_USER->id).'于'.get_date('Y-m-d H:i:s',PHP_TIME).'编辑客户信息';
		get_logadd($vid,$content,$title,36,$_USER->id);
		crm_log($title,$vid,$content,substr($crm_log, 0, -12),1,'crm_company');
		
		//处理联系人信息
		$pid = getGP('pid','P');
		$name = check_str(getGP('name','P'));
		//写入主表信息
		$crm_contact = array(
			'name' => $name
		);
		update_db('crm_contact',$crm_contact, array('id' => $pid));
		//写入单项数据
		$crm_log='';
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
			update_db('crm_db',$crm_db, array('viewid' => $pid,'type' =>'crm_contact','inputname' => $row["inputname"],'formid' => $row["fid"]));
			$crm_log.=serialize($crm_db).'|515158.com|';
		}
		$content=serialize($crm_contact);
		$title=get_realname($_USER->id).'于'.get_date('Y-m-d H:i:s',PHP_TIME).'编辑联系人信息';
		get_logadd($pid,$content,$title,36,$_USER->id);
		crm_log($title,$pid,$content,substr($crm_log, 0, -12),1,'crm_contact');
		
		show_msg('编辑客户信息成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
	}else{
		$view = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_company  WHERE id = '".getGP('id','G','int')."' ");
		include_once('company/company_edit.php');
	}
}elseif ($do == 'view'){
	$view = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_company  WHERE id = '".getGP('id','G','int')."' ");
	include_once('company/company_view.php');
}
?>