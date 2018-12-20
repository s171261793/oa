<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: mod_document 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
empty($do) && $do = 'list';
$type = getGP('type','G','int');
$father = getGP('father','G','int');
if($father=='') $father=0;
$document_type = getGP('document_type','G','int');
if($document_type=='') $document_type='';
if ($type=='1'){
	$_title['title']='个人文件柜';
}elseif($type=='2'){
	$_title['title']='公共文件柜';
}elseif($type=='3'){
	$_title['title']='网络硬盘';
}elseif($type=='4'){
	$_title['title']='下载';
}elseif($type=='5'){
	$_title['title']='规章制度';
}elseif($type=='6'){
	$_title['title']='报表中心';
}
get_key("office_document_".$type."");
$_check['ischeck']='  ui-tab-trigger-item-current';
if ($do == 'list') {
	if ($type=='1'){
		$documentsql = "SELECT * FROM ".DB_TABLEPRE."document_type where father='".$father."' and uid=".$_USER->id." and type='".$type."' order by id asc";
	}else{
		$documentsql = "SELECT * FROM ".DB_TABLEPRE."document_type where father='".$father."' and type='".$type."' order by id asc";
	}
	$documenttype = $db->fetch_all($documentsql);
	//列表信息 
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&type='.$type.'&father='.$father.'';
	if ($title = getGP('title','G')) {
		$wheresql .= " AND title like '%".$title."%'";
		$url .= '&title='.rawurlencode($title);
	}else{
		$wheresql .= " AND documentid ='".$father."'";
	}
	if(!is_superadmin()){
		$wheresql .= "  and (readuser LIKE'%".get_realname($_USER->id)."%' or uid='".$_USER->id."' or readuser='全体人员')";
	}
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."document WHERE 1 $wheresql and type = '".$type."' ORDER BY id desc");
    $sql = "SELECT * FROM ".DB_TABLEPRE."document WHERE 1 $wheresql and type = '".$type."' ORDER BY id desc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	include_once('template/documentlist.php');

}elseif ($do == 'updateFile') {
	$id = getGP('fileid','G');
	$id=explode(',',$id);
	$typeid = getGP('typeid','G');
	for($i=0;$i<sizeof($id);$i++){ 
		$db->query("UPDATE ".DB_TABLEPRE."document set documentid='".$typeid."' WHERE id = '".$id[$i]."'  ");
	}
	echo 'true';
	exit;

}elseif ($do == 'add') {
	$view = getGP('view','G');
	$id = getGP('id','G','int');
	if($view=='save'){
		$document=array();
		if($id!='0' && $id!=''){
			if(!is_superadmin() && !check_purview('office_document_edit_'.trim($type))){
				echo 'purview';
				exit;
			}
			$document['title'] = unescape(getGP('title','G')).'.'.getGP('filetype','G');
			$row = $db->fetch_one_array("SELECT id FROM ".DB_TABLEPRE."document  WHERE title = '".getGP('title','G')."' and id!='".$id."' and type='".$type."'");
			if($row['id']!=''){
				echo 'false';
				exit;
			}
			update_db('document',$document, array('id' => $id));
		}else{
			if(!is_superadmin() && !check_purview('office_document_Increase_'.trim($type))){
				echo 'purview';
				exit;
			}
			$row = $db->fetch_one_array("SELECT id FROM ".DB_TABLEPRE."document  WHERE title = '".getGP('title','G')."' and type='".$type."'");
			if($row['id']!=''){
				echo 'false';
				exit;
			}
			$document['title'] = unescape(getGP('title','G'));
			$document['date'] = get_date('Y-m-d H:i:s',PHP_TIME);
			$document['content'] = trim(getGP('content','G'));
			$document['annex'] = trim(getGP('annex','G'));
			$document['documentid'] = trim(getGP('documentid','G'));
			if($type==1){
				$document['key'] = 1;
				$document['readuser'] = '自己';
			}else{
				$document['key'] = 0;
				$document['readuser'] = '全体人员';
			}
			$document['uid'] = $_USER->id;
			$document['type'] = $type;
			insert_db('document',$document);
		}
		echo 'true';
		exit;
	}else{
		if(!is_superadmin() && !check_purview('office_document_delete_'.trim($type))){
			echo 'purview';
			exit;
		}
		$id = getGP('fileid','G');
		$id=explode(',',$id);
		for($i=0;$i<sizeof($id);$i++){ 
			$db->query("DELETE FROM ".DB_TABLEPRE."document WHERE id = '".$id[$i]."'  ");
		}
		echo 'true';
		exit;
	}

}elseif ($do == 'moveFile') {
	$id = getGP('fileid','G');
	$id=explode(',',$id);
	$publicuser = unescape(getGP('publicuser','G'));
	$document=array();
	$document['readuser']=$publicuser;
	if($type==1){
		$document['documentid']=0;
	}
	$document['key']='0';
	for($i=0;$i<sizeof($id);$i++){ 
		if($id[$i]!=''){
			update_db('document',$document, array('id' => $id[$i]));
		}
	}
	echo 'true';
	exit;
}elseif($do == 'documenttype') {
	//get_key("office_document_type_".$type."");
	if(!is_superadmin() && !check_purview('office_document_type_'.trim($type))){
		echo 'purview';
		exit;
	}
	$view = getGP('view','G');
	$did = getGP('did','G','int');
	if($view=='save'){
		$types=array();
		$types['title'] = unescape(getGP('title','G'));
		if($did!='0' && $did!=''){
			$row = $db->fetch_one_array("SELECT id FROM ".DB_TABLEPRE."document_type  WHERE title = '".getGP('title','G')."' and id!='".$did."'  and type='".$type."'");
			if($row['id']!=''){
				echo 'false';
				exit;
			}
			update_db('document_type',$types, array('id' => $did));
		}else{
			$row = $db->fetch_one_array("SELECT id FROM ".DB_TABLEPRE."document_type  WHERE title = '".getGP('title','G')."'  and type='".$type."'");
			if($row['id']!=''){
				echo 'false';
				exit;
			}
			$types['date'] = get_date('Y-m-d H:i:s',PHP_TIME);
			$types['father'] = $father;
			$types['uid'] = $_USER->id;
			$types['type'] = $type;
			insert_db('document_type',$types);
		}
		echo 'true';
		exit;
	}else{
		$db->query("DELETE FROM ".DB_TABLEPRE."document_type WHERE id = '".$did."'  ");
		$db->query("DELETE FROM ".DB_TABLEPRE."document WHERE documentid = '".$did."'  ");
		echo 'true';
		exit;
	}
}
function get_documenttype($fatherid=0,$selid=0,$layer=0,$type){
    $str=""; 
    global $db;
	global $_USER;
	if($type==1){
		$query = $db->query("SELECT * FROM ".DB_TABLEPRE."document_type where father='$fatherid' and type='".$type."' and uid='".$_USER->id."'  ORDER BY id Asc");
	}else{
		$query = $db->query("SELECT * FROM ".DB_TABLEPRE."document_type where father='$fatherid' and type='".$type."'  ORDER BY id Asc");
	}
	if(count($query)>0){
	   for($i=0;$i<$layer;$i++){
		   $str.="├";
	   }
		while ($row = $db->fetch_array($query)) {
			$selstr = $row['id'] == $selid ? 'selected="selected"' : '';
			$htmlstr= '<option value="'.$row['id'].'"  '.$selstr.'>'.$str.$row['title'].'</option>';
			echo $htmlstr;
			get_documenttype($row['id'],$selid,$layer+1,$type);
		}
	}
    return ;

}
//DELETE FROM toa_menu WHERE menuid in(200,201,199,203,202,204,205,206,207,208,209,210,211,212,213)'  
?>