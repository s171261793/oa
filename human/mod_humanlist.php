<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
get_key("human_list");
$type_G=trim($_GET['type']);
$type_P=trim($_POST['type']);
if($type_G!=''){
	$type=$type_G;
}else{
	$type=$type_P;
}
if($type=='1'){
	$human_type_name='员工档案';
}elseif($type=='2'){
	$human_type_name='证照';
}elseif($type=='3'){
	$human_type_name='学习经历';
}elseif($type=='4'){
	$human_type_name='工作经历';
}elseif($type=='5'){
	$human_type_name='劳动技能';
}elseif($type=='6'){
	$human_type_name='社会关系';
}elseif($type=='7'){
	$human_type_name='人事调动';
}elseif($type=='8'){
	$human_type_name='复职管理';
}elseif($type=='9'){
	$human_type_name='职称评定';
}elseif($type=='10'){
	$human_type_name='员工关怀';
}
empty($do) && $do = 'list';
if ($do == 'list') {
	//列表信息 
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&type='.$type;
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
	if ($number = getGP('number','G')) {
		$wheresql .= " AND number='".trim($number)."'";
		$url .= '&number='.rawurlencode($number);
	}
	$vstartdate = getGP('vstartdate','G');
	$venddate = getGP('venddate','G');
	if ($vstartdate!='' && $venddate!='') {
		$wheresql .= " AND (date>='".trim($vstartdate)."' and date<='".trim($venddate)."')";
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
			$sql = "SELECT * FROM ".DB_TABLEPRE."human_db WHERE type1='".$type."' and inputname ='".$inputname."' and inputvalue LIKE '%".trim($fromkeywordarr[$inputname])."%'  ORDER BY id desc";
			$query = $db->query($sql);
			while ($row = $db->fetch_array($query)) {
				$arrcid[]= $row['typeid'];
			}
		}
		
	}
	if($nums>0){
		$arrcid1=array_unique($arrcid);//去掉重复
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
		if($idnum<=0 && $number=='' && $vstartdate==''){
			$wheresql .=" and id=0";
		}else{
			if($idnum>0){
				$sqlstrname=str_replace('ssss or','',$whsql);
				$wheresql .=" and (".str_replace('ssss','',$sqlstrname).")";
			}
		}
	}
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."human_info WHERE 1 $wheresql and type='".$type."' ORDER BY id desc");
    $sql = "SELECT * FROM ".DB_TABLEPRE."human_info WHERE 1 $wheresql and type='".$type."' ORDER BY id desc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	//表单
	$companylist = array();
	$sql = "SELECT * FROM ".DB_TABLEPRE."human_form where type1='".$type."' and type in('0','3','4','5')  ORDER BY id Asc";
	$query = $db->query($sql);
	while ($row = $db->fetch_array($query)) {
		$companylist[] = $row;
	}
	include_once('template/humanlist'.$type.'.php');

}elseif ($do == 'view') {
	$id = getGP('id','G','int');
	$_title='编辑';
	$blog = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."human_info  WHERE id = '$id' ");
	include_once('template/humanview'.$type.'.php');
}elseif ($do == 'update') {
	
	$idarr = getGP('id','P','array');
	foreach ($idarr as $id) {
		$db->query("DELETE FROM ".DB_TABLEPRE."human_info WHERE id = '$id' ");
		$db->query("DELETE FROM ".DB_TABLEPRE."human_db WHERE type1='".$type."' and typeid= '$id' ");	
	}
	$content=serialize($idarr);
	$title='删除客户信息';
	get_logadd($id,$content,$title,37,$_USER->id);
    show_msg('客户信息删除成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&type='.$type);

}elseif ($do == 'excel') {
	$datename="human_".$type."_".get_date('YmdHis',PHP_TIME);
	$outputFileName = 'data/excel/'.$datename.'.xls';
			$wheresql = '';
			//权限判断
			$un = getGP('un','P');
			$ui = getGP('ui','P');
			if(!is_superadmin() && $ui==''){
				$wheresql .= " and uid='".$_USER->id."'";
			}
			if ($ui!='') {
				$wheresql .= " and uid in(".$ui.")";
			}
			if ($number = getGP('number','P')) {
				$wheresql .= " AND number='".trim($number)."'";
			}
			$vstartdate = getGP('vstartdate','P');
			$venddate = getGP('venddate','P');
			if ($vstartdate!='' && $venddate!='') {
				$wheresql .= " AND (date>='".trim($vstartdate)."' and date<='".trim($venddate)."')";
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
					$sql = "SELECT * FROM ".DB_TABLEPRE."human_db WHERE type1='".$type."' and inputname ='".$inputname."' and inputvalue LIKE '%".trim($fromkeywordarr[$inputname])."%'  ORDER BY id desc";
					$query = $db->query($sql);
					while ($row = $db->fetch_array($query)) {
						$arrcid[]= $row['typeid'];
					}
				}
				
			}
			if($nums>0){
				$arrcid1=array_unique($arrcid);//去掉重复
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
				if($idnum<=0 && $number=='' && $vstartdate==''){
					$wheresql .=" and id=0";
				}else{
					if($idnum>0){
						$sqlstrname=str_replace('ssss or','',$whsql);
						$wheresql .=" and (".str_replace('ssss','',$sqlstrname).")";
					}
				}
			}
			//获取表单
			$archive = array();
			$inputname = array();
			$query = $db->query("SELECT * FROM ".DB_TABLEPRE."human_form where type1='".$type."'  ORDER BY id Asc");
			$archive[]="<b>流水号</b>";
			$archive[]="<b>单位员工</b>";
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
			$sql = "SELECT * FROM ".DB_TABLEPRE."human_info WHERE 1 $wheresql  and type='".$type."' ORDER BY id desc";
			$result = $db->query($sql);
			while ($row = $db->fetch_array($result)) {	
				$archive = array();
				$archive[]=$row['number'];
				$archive[]=$row['username'];
				for($i=0;$i<$num;$i++){
					$blog = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."human_db  WHERE typeid = '".$row['id']."' and inputname='".$inputname[$i]."' ");
					if($blog['type']=='3'){
						$archive[]=str_replace("-",".",$blog['inputvalue']);
					}else{
						$archive[]=$blog['inputvalue'];
					}
				}
				
				$archive[]=$row['username'];
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
}
?>