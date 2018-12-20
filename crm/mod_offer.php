<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
empty($do) && $do = 'list';
require('function/prod.php');
require('function/form.php');
//处理流程
$_flow=crm_flow('crm_offer');
get_key("crm_offer");
if ($do == 'list') {
	//列表信息 
	
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl;
	if ($number = getGP('number','G')) {
		$wheresql .= " AND number='".$number."'";
		$url .= '&number='.rawurlencode($number);
	}
	if ($cid = getGP('cid','G')) {
		$wheresql .= " AND cid='".$cid."'";
		$url .= '&cid='.rawurlencode($cid);
	}
	if ($title = getGP('title','G')) {
		$wheresql .= " AND title LIKE'%".$title."%'";
		$url .= '&title='.rawurlencode($title);
	}
	//权限判断
	$un = getGP('un','G');
	$ui = getGP('ui','G');
	if(!is_superadmin() && $ui==''){
		$wheresql .= " and uid='".$_USER->id."'";
	}
	if ($ui!='') {
		$wheresql .= " and uid in(".$ui.")";
		$url .= '&ui='.$ui.'&un='.$un;
	}
	//审批权限
	if($_flow==1 && $ui==''){
		$hhhhh='';
		$sqlss = "SELECT b.viewid FROM ".DB_TABLEPRE."crm_offer a,".DB_TABLEPRE."crm_personnel b WHERE  a.id=b.viewid and b.name like '%".get_realname($_USER->id)."%' and b.modid='crm_offer' order by b.perid asc";
		$queryss = $db->query($sqlss);
		while ($rss = $db->fetch_array($queryss)) {
			$hhhhh.='id='.$rss['viewid'].' or ';
		}
		$hhhhh=substr($hhhhh, 0, -4);
		if($hhhhh!=''){
			$wheresql .= " or ".$hhhhh." ";
		}
	}
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
			$sql = "SELECT * FROM ".DB_TABLEPRE."crm_db WHERE type='crm_offer' and inputname ='".$inputname."' and content LIKE '%".trim($fromkeywordarr[$inputname])."%'  ORDER BY did desc";
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
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."crm_offer  WHERE 1 $wheresql ");
    $sql = "SELECT * FROM ".DB_TABLEPRE."crm_offer WHERE 1 $wheresql ORDER BY id desc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	//表单
	$companylist = array();
	$sql = "SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_offer' and type in('0','3','4','5') and inputtype in('1','2','3','5') ORDER BY inputnumber Asc";
	$query = $db->query($sql);
	while ($row = $db->fetch_array($query)) {
		$companylist[] = $row;
	}
	//表单汇总
	$fromnum = $db->result("SELECT COUNT(*) AS fromnum FROM ".DB_TABLEPRE."crm_form where type1='crm_offer' and type2='1' ORDER BY inputnumber Asc");
	include_once('service/offer.php');

} elseif ($do == 'update') {
	get_key("crm_offer_del");
	$idarr = getGP('id','P','array');
	foreach ($idarr as $id) {
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_offer WHERE id = '$id' ");
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_db WHERE type='crm_offer' and viewid= '$id' ");
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_log WHERE modid='crm_offer' and viewid= '$id' ");
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_prod_view WHERE type='1' and viewid= '$id' ");
	}
	$content=serialize($idarr);
	$title='删除报价单信息';
	get_logadd($id,$content,$title,36,$_USER->id);
    show_msg('报价单信息删除成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&cid='.$_POST['cid'].'');

}elseif ($do == 'excel') {
	get_key("crm_offer_excel");
	$datename="offer_".get_date('YmdHis',PHP_TIME);
	$outputFileName = 'data/excel/'.$datename.'.xls';
			$wheresql = '';
			if ($cid = getGP('cid','P')) {
				$wheresql .= " AND cid='".$cid."'";
			}
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
				$wheresql .= " and uid='".$_USER->id."' ";
			}
			if ($ui!='') {
				$wheresql .= " and uid in(".$ui.")";
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
					$sql = "SELECT * FROM ".DB_TABLEPRE."crm_db WHERE type='crm_offer' and inputname ='".$inputname."' and content LIKE '%".trim($fromkeywordarr[$inputname])."%'  ORDER BY did desc";
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
			$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_offer'  ORDER BY inputnumber Asc");
			$archive[]="<b>公司名称</b>";
			$archive[]="<b>流水号</b>";
			$archive[]="<b>报价名称</b>";
			$num=0;
			while ($row = $db->fetch_array($query)) {
				$num++;
				$archive[]="<b>".$row['formname']."</b>";
				$inputname[]=$row['inputname'];
			}
			$archive[]="<b>总金额</b>";
			$archive[]="<b>发布人</b>";
			$archive[]="<b>发布时间</b>";
			$content = array();
			$content[] = $archive;
			$sql = "SELECT * FROM ".DB_TABLEPRE."crm_offer WHERE 1 $wheresql  ORDER BY id desc";
			$result = $db->query($sql);
			while ($row = $db->fetch_array($result)) {	
				$archive = array();
				$archive[]=public_value('title','crm_company','id='.$row['cid']);;
				$archive[]=$row['number'];
				$archive[]=$row['title'];
				for($i=0;$i<$num;$i++){
					$blog = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_db  WHERE viewid = '".$row['id']."' and inputname='".$inputname[$i]."' and type='crm_offer' ");
					if($blog['type']=='3'){
						$archive[]=str_replace("-",".",$blog['content']);
					}else{
						$archive[]=$blog['content'];
					}
				}
				$archive[]=$row['price'];
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
	get_key("crm_offer_add");
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
		include_once('service/prodlist.php');
	}elseif($_POST['view']!=''){
		//固定选项
		$title = check_str(getGP('title','P'));
		$number = check_str(getGP('number','P'));
		$price = check_str(getGP('price','P'));
		$cname = check_str(getGP('cname','P'));
		$cid = getGP('cid','P');
		$uid = $_USER->id;
		$date=get_date('Y-m-d H:i:s',PHP_TIME);
		$pids = getGP('pid','P','array');
		//写入主表信息
		$crm_offer = array(
			'number' => $number,
			'cid' => $cid,
			'price' => $price,
			'title' => $title,
			'cname' => $cname,
			'uid' => $uid,
			'date' => $date
		);
		insert_db('crm_offer',$crm_offer);
		$vid=$db->insert_id();
		foreach ($pids as $pid) {
			$crm_prod_view = array(
				'pid' => $pid,
				'price' => getGP('price_'.trim($pid),'P'),
				'number' => getGP('number_'.trim($pid),'P'),
				'unit' => getGP('unit_'.trim($pid),'P'),
				'viewid' => $vid,
				'type' => 1
			);
			insert_db('crm_prod_view',$crm_prod_view);
		}
		//写入单项数据
		global $db;
		$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_offer' ORDER BY inputnumber Asc");
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
					'type' => 'crm_offer'
				);
			insert_db('crm_db',$crm_db);
			$crm_log.=serialize($crm_db).'|515158.com|';
		}
		//处理流程
		if($_flow==1){
			crm_flow_save('crm_offer',$vid,getGP('userkey','P'),getGP('userkeyid','P'),getGP('flowid','P'),getGP('appkey','P'),getGP('appkey1','P'),getGP('sms_info_box_work','P'),getGP('sms_phone_box_work','P'),getGP('userkeyphone','P'));
		}
		$content=serialize($crm_offer);
		$title=get_realname($_USER->id).'于'.get_date('Y-m-d H:i:s',PHP_TIME).'新建报价单信息';
		get_logadd($vid,$content,$title,36,$_USER->id);
		crm_log($title,$vid,$content,substr($crm_log, 0, -12),1,'crm_offer');
		show_msg('新建报价单信息成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&type='.$type);
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
		include_once('service/offer_add.php');
	}
}elseif ($do == 'edit'){
	get_key("crm_offer_edit");
	if($_POST['view']!=''){
		//固定选项
		$title = check_str(getGP('title','P'));
		$number = check_str(getGP('number','P'));
		$price = check_str(getGP('price','P'));
		//$cname = check_str(getGP('cname','P'));
		//$cid = getGP('cid','P');
		$pids = getGP('viewid','P','array');
		$vid = getGP('id','P');
		//写入主表信息
		$crm_offer = array(
			'title' => $title,
			'number' => $number,
			'price' => $price
		);
		update_db('crm_offer',$crm_offer, array('id' => $vid));
		foreach ($pids as $pid) {
			$crm_prod_view = array(
				'price' => getGP('price_'.trim($pid),'P'),
				'number' => getGP('number_'.trim($pid),'P'),
				'unit' => getGP('unit_'.trim($pid),'P')
			);
			update_db('crm_prod_view',$crm_prod_view, array('id' => $pid,'viewid' => $vid,'type' => 1));
		}
		//写入单项数据
		global $db;
		$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_offer' ORDER BY inputnumber Asc");
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
			update_db('crm_db',$crm_db, array('viewid' => $vid,'type' => 'crm_offer','inputname' => $row["inputname"],'formid' => $row["fid"]));
			$crm_log.=serialize($crm_db).'|515158.com|';
		}
		$content=serialize($crm_offer);
		$title=get_realname($_USER->id).'于'.get_date('Y-m-d H:i:s',PHP_TIME).'编辑报价单信息';
		get_logadd($vid,$content,$title,36,$_USER->id);
		crm_log($title,$vid,$content,substr($crm_log, 0, -12),1,'crm_offer');
		show_msg('编辑报价单信息成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&type='.getGP('type','P'));
	}else{
		$view = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_offer  WHERE id = '".getGP('id','G','int')."' ");
		$sql = "SELECT * FROM ".DB_TABLEPRE."crm_prod_view WHERE viewid='".$view['id']."' and type=1 ORDER BY id asc LIMIT 0,50";
		$result = $db->fetch_all($sql);
		include_once('service/offer_edit.php');
	}
}elseif ($do == 'view'){
	$view = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_offer  WHERE id = '".getGP('id','G','int')."' ");
	$sql = "SELECT * FROM ".DB_TABLEPRE."crm_prod_view WHERE viewid='".$view['id']."' and type=1 ORDER BY id asc LIMIT 0,50";
	$result = $db->fetch_all($sql);
	include_once('service/offer_view.php');
}
?>