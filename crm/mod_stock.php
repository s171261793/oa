<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
empty($do) && $do = 'list';
require('function/prod.php');
require('function/form.php');
get_key("crm_stock");
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
	if ($type = getGP('type','G')) {
		$wheresql .= " AND type='".$type."'";
		$url .= '&type='.rawurlencode($type);
	}
	if ($price = getGP('price','G')) {
		$wheresql .= " AND price='".$price."'";
		$url .= '&price='.rawurlencode($price);
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
			$sql = "SELECT * FROM ".DB_TABLEPRE."crm_db WHERE type='crm_product' and inputname ='".$inputname."' and content LIKE '%".trim($fromkeywordarr[$inputname])."%'  ORDER BY did desc";
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
		if($idnum<=0 && $number=='' && $vstartdate=='' && $title=='' && $price=='' && $type==''){
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
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."crm_product WHERE 1 $wheresql");
    $sql = "SELECT * FROM ".DB_TABLEPRE."crm_product WHERE 1 $wheresql ORDER BY id desc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	//表单
	$companylist = array();
	$sql = "SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_product' and type in('0','3','4','5') and inputtype in('1','2','3','5') ORDER BY inputnumber Asc";
	$query = $db->query($sql);
	while ($row = $db->fetch_array($query)) {
		$companylist[] = $row;
	}
	//表单汇总
	$fromnum = $db->result("SELECT COUNT(*) AS fromnum FROM ".DB_TABLEPRE."crm_form where type1='crm_product' and type2='1' ORDER BY inputnumber Asc");
	include_once('prod/stock.php');

}elseif ($do == 'stock') {
	//列表信息 
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=stock';
	if ($number = getGP('number','G')) {
		$wheresql .= " AND number='".$number."'";
		$url .= '&number='.rawurlencode($number);
	}
	if ($type = getGP('type','G')) {
		if($type=='1'){
			$wheresql .= " AND (type='".$type."' or type=2)";
		}else{
			$wheresql .= " AND type='".$type."'";
		}
		$url .= '&type='.rawurlencode($type);
	}
	if ($id = getGP('id','G')) {
		$wheresql .= " AND pid='".$id."'";
		$url .= '&id='.rawurlencode($id);
	}
	$vstartdate = getGP('vstartdate','G');
	$venddate = getGP('venddate','G');
	if ($vstartdate!='' && $venddate!='') {
		$wheresql .= " AND (date>='".$vstartdate."' and date<='".$venddate."')";
		$url .= '&vstartdate='.$vstartdate.'&venddate='.$venddate;
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
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."crm_stock WHERE 1 $wheresql");
    $sql = "SELECT * FROM ".DB_TABLEPRE."crm_stock WHERE 1 $wheresql ORDER BY id desc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	if($type==1){
		$t='入库';
	}else{
		$t='出库';
	}
	include_once('prod/stock_log.php');

}elseif ($do == 'update') {
	$idarr = getGP('id','P','array');
	foreach ($idarr as $id) {
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_stock WHERE id = '$id' ");
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_db WHERE type='crm_stock' and viewid= '$id' ");
		$db->query("DELETE FROM ".DB_TABLEPRE."crm_log WHERE modid='crm_stock' and viewid= '$id' ");	
	}
	$content=serialize($idarr);
	$title='删除库存记录';
	get_logadd($id,$content,$title,36,$_USER->id);
    show_msg('库存记录删除成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=stock&id='.$_POST['pid'].'&type='.$_POST['type']);

}elseif ($do == 'excel') {
	$datename="stock_".get_date('YmdHis',PHP_TIME);
	$outputFileName = 'data/excel/'.$datename.'.xls';
			$wheresql = '';
			if ($number = getGP('number','P')) {
				$wheresql .= " AND number='".$number."'";
			}
			if ($title = getGP('title','P')) {
				$wheresql .= " AND title LIKE'%".$title."%'";
			}
			if ($type = getGP('type','P')) {
				$wheresql .= " AND type='".$type."'";
			}
			if ($price = getGP('price','P')) {
				$wheresql .= " AND price='".$price."'";
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
					$sql = "SELECT * FROM ".DB_TABLEPRE."crm_db WHERE type='crm_product' and inputname ='".$inputname."' and content LIKE '%".trim($fromkeywordarr[$inputname])."%'  ORDER BY did desc";
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
				if($idnum<=0 && $number=='' && $vstartdate=='' && $title=='' && $price=='' && $type==''){
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
			$archive[]="<b>产品编号</b>";
			$archive[]="<b>产品名称</b>";
			$archive[]="<b>产品价格</b>";
			$archive[]="<b>剩余库存</b>";
			$archive[]="<b>出库数量</b>";
			$archive[]="<b>入库数量</b>";
			$content = array();
			$content[] = $archive;
			$sql = "SELECT * FROM ".DB_TABLEPRE."crm_product WHERE 1 $wheresql  ORDER BY id desc";
			$result = $db->query($sql);
			while ($row = $db->fetch_array($result)) {
				$type1 = $db->fetch_one_array("SELECT sum(stocknum) as stocknum FROM ".DB_TABLEPRE."crm_stock WHERE pid='".$row["id"]."' and (type=1 or type=2) ");
				$type2 = $db->fetch_one_array("SELECT sum(stocknum) as stocknum FROM ".DB_TABLEPRE."crm_stock WHERE pid='".$row["id"]."' and type=3");
				$number=$type1['stocknum']-$type2['stocknum'];	
				$archive = array();
				$archive[]=$row['number'];
				$archive[]=$row['title'];
				$archive[]=$row['price'];
				$archive[]=$number;
				$archive[]=$type2['stocknum'];
				$archive[]=$type1['stocknum'];
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
		$number = check_str(getGP('number','P'));
		$pid = check_str(getGP('pid','P'));
		$stocknum = getGP('stocknum','P');
		$unit = getGP('unit','P');
		$type = getGP('type','P');
		$uid = $_USER->id;
		$date=get_date('Y-m-d H:i:s',PHP_TIME);
		//写入主表信息
		$crm_stock = array(
			'number' => $number,
			'pid' => $pid,
			'stocknum' => $stocknum,
			'unit' => $unit,
			'type' => $type,
			'uid' => $uid,
			'date' => $date
		);
		insert_db('crm_stock',$crm_stock);
		$vid=$db->insert_id();
		//写入单项数据
		global $db;
		$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_stock' ORDER BY inputnumber Asc");
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
					'type' => 'crm_stock'
				);
			insert_db('crm_db',$crm_db);
			$crm_log.=serialize($crm_db).'|515158.com|';
		}
		$content=serialize($crm_stock);
		$title=get_realname($_USER->id).'于'.get_date('Y-m-d H:i:s',PHP_TIME).'新建库存信息';
		get_logadd($vid,$content,$title,36,$_USER->id);
		crm_log($title,$vid,$content,substr($crm_log, 0, -12),1,'crm_stock');
		show_msg('新建库存信息成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&id='.$pid.'&type='.$type.'&do=stock');
	}else{
		include_once('prod/stock_add.php');
	}
}elseif ($do == 'view'){
	$view = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_stock  WHERE id = '".getGP('id','G','int')."' ");
	include_once('prod/stock_view.php');
}
?>