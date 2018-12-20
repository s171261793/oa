<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
empty($do) && $do = 'list';
require('function/prod.php');
require('function/form.php');
//处理流程
$_flow=crm_flow('crm_purchase');
get_key("crm_purchase");
if ($do == 'list') {
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
	//审批权限
	if($_flow==1 && $ui==''){
		$hhhhh='';
		$sqlss = "SELECT b.viewid FROM ".DB_TABLEPRE."crm_purchase a,".DB_TABLEPRE."crm_personnel b WHERE  a.id=b.viewid and b.name like '%".get_realname($_USER->id)."%' and b.modid='crm_purchase' order by b.perid asc";
		$queryss = $db->query($sqlss);
		while ($rss = $db->fetch_array($queryss)) {
			$hhhhh.='id='.$rss['viewid'].' or ';
		}
		$hhhhh=substr($hhhhh, 0, -4);
		if($hhhhh!=''){
			$wheresql .= " or ".$hhhhh." ";
		}
	}
	//权限结束
	$vstartdate = getGP('vstartdate','G');
	$venddate = getGP('venddate','G');
	if ($vstartdate!='' && $venddate!='') {
		$wheresql .= " AND (date>='".$vstartdate."' and date<='".$venddate."')";
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
			$sql = "SELECT * FROM ".DB_TABLEPRE."crm_db WHERE type='crm_purchase' and inputname ='".$inputname."' and content LIKE '%".trim($fromkeywordarr[$inputname])."%'  ORDER BY did desc";
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
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."crm_purchase WHERE 1 $wheresql");
    $sql = "SELECT * FROM ".DB_TABLEPRE."crm_purchase WHERE 1 $wheresql ORDER BY id desc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	//表单
	$companylist = array();
	$sql = "SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_purchase' and type in('0','3','4','5') and inputtype in('1','2','3','5') ORDER BY inputnumber Asc";
	$query = $db->query($sql);
	while ($row = $db->fetch_array($query)) {
		$companylist[] = $row;
	}
	//表单汇总
	$fromnum = $db->result("SELECT COUNT(*) AS fromnum FROM ".DB_TABLEPRE."crm_form where type1='crm_purchase' and type2='1' ORDER BY inputnumber Asc");
	
	include_once('purchase/purchase.php');

} elseif ($do == 'update') {
	get_key("crm_purchase_del");
	$idarr = getGP('id','P','array');
	foreach ($idarr as $id) {
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_purchase WHERE id = '$id' ");
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_db WHERE type='crm_purchase' and viewid= '$id' ");
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_log WHERE modid='crm_purchase' and viewid= '$id' ");	
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_prod_view WHERE type='2' and viewid= '$id' ");
	}
	$content=serialize($idarr);
	$title='删除采购信息';
	get_logadd($id,$content,$title,36,$_USER->id);
    show_msg('采购信息删除成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');

}elseif ($do == 'excel') {
	get_key("crm_purchase_excel");
	$datename="purchase_".get_date('YmdHis',PHP_TIME);
	$outputFileName = 'data/excel/'.$datename.'.xls';
			$wheresql = '';
			if ($number = getGP('number','P')) {
				$wheresql .= " AND number='".$number."'";
			}
			if ($title = getGP('title','P')) {
				$wheresql .= " AND title LIKE'%".$title."%'";
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
					$sql = "SELECT * FROM ".DB_TABLEPRE."crm_db WHERE type='crm_purchase' and inputname ='".$inputname."' and content LIKE '%".trim($fromkeywordarr[$inputname])."%'  ORDER BY did desc";
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
			$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_purchase'  ORDER BY inputnumber Asc");
			$archive[]="<b>采购编号</b>";
			$archive[]="<b>采购名称</b>";
			$archive[]="<b>申请人</b>";
			$archive[]="<b>金额合计</b>";
			$archive[]="<b>供应商</b>";
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
			$sql = "SELECT * FROM ".DB_TABLEPRE."crm_purchase WHERE 1 $wheresql  ORDER BY id desc";
			$result = $db->query($sql);
			while ($row = $db->fetch_array($result)) {	
				$archive = array();
				$archive[]=$row['number'];
				$archive[]=$row['title'];
				$archive[]=$row['user'];
				$archive[]=$row['pricenum'];
				$archive[]=$row['sname'];
				for($i=0;$i<$num;$i++){
					$blog = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_db  WHERE viewid = '".$row['id']."' and inputname='".$inputname[$i]."' and type='crm_purchase' ");
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
	get_key("crm_purchase_add");
	if($_GET['prod']=='' && $_POST['view']==''){
		//列表信息 
		if ($number = getGP('number','G')) {
			$wheresql .= " AND number='".$number."'";
		}
		if ($title = getGP('title','G')) {
			$wheresql .= " AND title LIKE'%".$title."%'";
		}
		if ($type = getGP('type','G')) {
			$wheresql .= " AND type='".$type."'";
		}
		$sql = "SELECT * FROM ".DB_TABLEPRE."crm_product WHERE 1 $wheresql ORDER BY id desc LIMIT 0,50";
		$result = $db->fetch_all($sql);
		include_once('purchase/prodlist.php');
	}elseif($_POST['view']!=''){
		//固定选项
		$number = check_str(getGP('number','P'));
		$title = check_str(getGP('title','P'));
		//$pricenum = check_str(getGP('pricenum','P'));
		$sname = check_str(getGP('cname','P'));
		$sid = check_str(getGP('cid','P'));
		$user = getGP('user','P');
		$uid = $_USER->id;
		$date=get_date('Y-m-d H:i:s',PHP_TIME);
		$pids = getGP('pid','P','array');
		$pricenum=0;
		foreach ($pids as $pid) {
			$pricenum+=getGP('price_'.trim($pid),'P')*getGP('number_'.trim($pid),'P');
		}
		//写入主表信息
		$crm_purchase = array(
			'number' => $number,
			'user' => $user,
			'date' => $date,
			'pricenum' => $pricenum,
			'uid' => $uid,
			'sid' => $sid,
			'title' => $title,
			'sname' => $sname
		);
		insert_db('crm_purchase',$crm_purchase);
		$vid=$db->insert_id();
		foreach ($pids as $pid) {
			$crm_prod_view = array(
				'pid' => $pid,
				'price' => getGP('price_'.trim($pid),'P'),
				'number' => getGP('number_'.trim($pid),'P'),
				'unit' => getGP('unit_'.trim($pid),'P'),
				'viewid' => $vid,
				'type' => 2
			);
			insert_db('crm_prod_view',$crm_prod_view);
		}
		//写入单项数据
		global $db;
		$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_purchase' ORDER BY inputnumber Asc");
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
					'type' => 'crm_purchase'
				);
			insert_db('crm_db',$crm_db);
			$crm_log.=serialize($crm_db).'|515158.com|';
		}
		//处理数据入库
		if($_flow!=1){
			foreach ($pids as $pid) {
				$crm_stock = array(
					'pid' => $pid,
					'stocknum' => getGP('number_'.trim($pid),'P'),
					'unit' => getGP('unit_'.trim($pid),'P'),
					'number' => "T".get_date('YmdHis',PHP_TIME),
					'type' => 2,
					'date'=>get_date('Y-m-d H:i:s',PHP_TIME),
					'uid'=>$_USER->id
				);
				insert_db('crm_stock',$crm_stock);
			}
		}
		//处理流程
		if($_flow==1){
			crm_flow_save('crm_purchase',$vid,getGP('userkey','P'),getGP('userkeyid','P'),getGP('flowid','P'),getGP('appkey','P'),getGP('appkey1','P'),getGP('sms_info_box_work','P'),getGP('sms_phone_box_work','P'),getGP('userkeyphone','P'));
		}
		$content=serialize($crm_purchase);
		$title=get_realname($_USER->id).'于'.get_date('Y-m-d H:i:s',PHP_TIME).'新建采购信息';
		get_logadd($vid,$content,$title,36,$_USER->id);
		crm_log($title,$vid,$content,substr($crm_log, 0, -12),1,'crm_purchase');
		show_msg('新建采购信息成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
	}else{
		$pid='';
		if($_GET['prod']=='2'){
			$idarr = getGP('id','G','array');
			foreach ($idarr as $id) {
				$pid.=$id.',';
			}
			$pid=substr($pid, 0, -1);
		}else{
			$pid=$_GET['pid'];
		}
		include_once('purchase/purchase_add.php');
	}
}elseif ($do == 'edit'){
	get_key("crm_purchase_edit");
	if($_POST['view']!=''){
		//固定选项
		$number = check_str(getGP('number','P'));
		$title = check_str(getGP('title','P'));
		$user = getGP('user','P');
		//$pricenum = getGP('pricenum','P');
		$vid = getGP('id','P');
		$pids = getGP('viewid','P','array');
		$pricenum=0;
		foreach ($pids as $pid) {
			$pricenum+=getGP('price_'.trim($pid),'P')*getGP('number_'.trim($pid),'P');
		}
		//写入主表信息
		$crm_purchase = array(
			'number' => $number,
			'title' => $title,
			'user' => $user,
			'pricenum' => $pricenum
		);
		update_db('crm_purchase',$crm_purchase, array('id' => $vid));
		foreach ($pids as $pid) {
			$crm_prod_view = array(
				'price' => getGP('price_'.trim($pid),'P'),
				'number' => getGP('number_'.trim($pid),'P'),
				'unit' => getGP('unit_'.trim($pid),'P')
			);
			update_db('crm_prod_view',$crm_prod_view, array('id' => $pid,'viewid' => $vid,'type' => 2));
		}
		//写入单项数据
		global $db;
		$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_purchase' ORDER BY inputnumber Asc");
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
			update_db('crm_db',$crm_db, array('viewid' => $vid,'type' =>'crm_purchase','inputname' => $row["inputname"],'formid' => $row["fid"]));
			$crm_log.=serialize($crm_db).'|515158.com|';
		}
		$content=serialize($crm_purchase);
		$title=get_realname($_USER->id).'于'.get_date('Y-m-d H:i:s',PHP_TIME).'编辑采购信息';
		get_logadd($vid,$content,$title,36,$_USER->id);
		crm_log($title,$vid,$content,substr($crm_log, 0, -12),1,'crm_purchase');
		show_msg('编辑采购信息成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
	}else{
		$view = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_purchase  WHERE id = '".getGP('id','G','int')."' ");
		$sql = "SELECT * FROM ".DB_TABLEPRE."crm_prod_view WHERE viewid='".$view['id']."' and type=2 ORDER BY id asc LIMIT 0,50";
		$result = $db->fetch_all($sql);
		include_once('purchase/purchase_edit.php');
	}
}elseif ($do == 'view'){
	$view = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_purchase  WHERE id = '".getGP('id','G','int')."' ");
	$sql = "SELECT * FROM ".DB_TABLEPRE."crm_prod_view WHERE viewid='".$view['id']."' and type=2 ORDER BY id asc LIMIT 0,50";
	$result = $db->fetch_all($sql);
	include_once('purchase/purchase_view.php');
}
?>