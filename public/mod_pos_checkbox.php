<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: oa 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/

(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');

//if ( !is_superadmin() && !check_purview('manage_link') ) prompt('对不起，你没有权限执行本操作！');

empty($do) && $do = 'list';
if ($do == 'list') {
	include_once('template/pos_checkbox.php');

}elseif($do == 'add'){
	global $db;
	$values=explode(',',$_GET['value']);
	for($i=0;$i<sizeof($values);$i++){
		if($values[$i]!=''){
			$sql="SELECT name FROM ".DB_TABLEPRE."position where id='".$values[$i]."'";
			$blog = $db->fetch_one_array($sql);
			$html.=$blog['name'].',';
		}
	}
	echo substr($html, 0, -1);
}elseif($do='save'){
	$idarr = getGP('id','P','array');
	if(getGP('inputname','P')!=''){
		$participation=getGP('inputname','P');
	}else{
		$participation='participation';
	}
	foreach ($idarr as $id) {
		if($id!=''){
			$ids.=$id.',';
		}
	}
	
	echo "<script>window.opener.document.save.".$participation.".value='".get_postname($ids)."';</script>";
	echo "<script>window.opener.document.save.".$participation."id.value='".substr($ids, 0, -1)."';</script>";
	echo '<script language="JavaScript">window.close()</script>';
}
//读取部门
function public_list($fatherid=0,$selid=0,$layer=0,$ac,$fileurl){
    global $db;
	$sql="SELECT * FROM ".DB_TABLEPRE."position where father='$fatherid' ORDER BY id Asc";
	$query = $db->query($sql);
	echo '<tbody id="group_'.trim($fatherid).'">';
	if(count($query)>0){
		while ($row = $db->fetch_array($query)) {
			$rsfno = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."position where father='".$row[id]."' ORDER BY id asc limit 0,1");
			echo '<tr class="hover">';
			echo '<td width="20"></td>';
			echo '<td width="400"><div class="board"><input type="checkbox" name="id[]" value="'.$row['id'].'" class="checkbox" /> '.trim($row[name]).'</span></td>';
			echo '</tr>';
	
			if($rsfno[id]!=''){
				public_view($row['id'],$selid,$layer+1,$ac,$fileurl);
			}
		}
	}
   echo '</tbody>';
   return ;

}
function public_view($fatherid=0,$selid=0,$layer=0,$ac,$fileurl){
    global $db;
	$sql="SELECT * FROM ".DB_TABLEPRE."position where father='$fatherid' ORDER BY id Asc";
	$query = $db->query($sql);
	if(count($query)>0){
		for($i=0;$i<$layer;$i++){
		   $str.="&nbsp;&nbsp;&nbsp;&nbsp;";
		   }
		while ($row = $db->fetch_array($query)) {
			$rsfno = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."position where father='".$row[id]."' ORDER BY id asc limit 0,1");
			echo'<tr class="hover"><td width="20"></td>';
			echo'<td width="400"><div id="cb_'.trim($row[id]).'" class="childboard">'.$str.'<input type="checkbox" name="id[]" value="'.$row['id'].'" class="checkbox" /> ';
			echo''.trim($row[name]).'</div></td>';
			echo'</tr>';
			if($rsfno[id]!=''){
				public_view($row['id'],$selid,$layer+1,$ac,$fileurl);
			}
			
		}
	}
   return ;

}
?>
