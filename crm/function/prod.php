<?php
!defined('IN_TOA') && exit('Access Denied!');
function prod_class_save($fatherid=0,$selid=0,$layer=0,$ac,$fileurl,$type){
    global $db;
	$sql="SELECT * FROM ".DB_TABLEPRE."crm_pord_type where father='$fatherid' ORDER BY id Asc";
	$query = $db->query($sql);
	echo '<tbody id="group_'.trim($fatherid).'">';
	if(count($query)>0){
		while ($row = $db->fetch_array($query)) {
			$rsfno = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_pord_type where father='".$row[id]."'  ORDER BY id asc limit 0,1");
			echo '<tr class="hover">';
			echo '<td class="td25"></td>';
			echo '<td class="td25"><input type="hidden" name="id[]" value="'.trim($row[id]).'" />'.trim($row[id]).'</td>';
			echo '<td><div class="board"><input type="text" name="name['.trim($row[id]).']" ';
			echo 'value="'.trim($row[title]).'" style="width:160px;" class="txt" />';
			echo '  <a href="###" onclick="addrowdirect = 1;addrow(this, 2, 2)" ';
			echo 'class="addchildboard">添加下级类别</a></div></td>';
			echo '<td class="td25 lightfont"></td>';
			echo '<td class="td23"></td>';
			echo '<td width="160"><a href="admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=class&view=typeupdate&id='.trim($row[id]).'&fid='.trim($row[father]).'" class="act">删除</a></td></tr>';
	
			if($rsfno[id]!=''){
				prod_class_view($row['id'],$selid,$layer+1,$ac,$fileurl,$type);
			}
		}
	}
   echo '</tbody>';
   return ;

}
function prod_class_view($fatherid=0,$selid=0,$layer=0,$ac,$fileurl,$type){
    global $db;
	$sql="SELECT * FROM ".DB_TABLEPRE."crm_pord_type where father='$fatherid'  ORDER BY id Asc";
	$query = $db->query($sql);
	if(count($query)>0){
		for($i=0;$i<$layer;$i++){
		   $str.="&nbsp;&nbsp;&nbsp;&nbsp;";
		   }
		while ($row = $db->fetch_array($query)) {
			$rsfno = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_pord_type where father='".$row[id]."'  ORDER BY id asc limit 0,1");
			echo'<tr class="hover"><td class="td25"></td>';
			echo'<td class="td25"><input type="hidden" name="id[]" value="'.trim($row[id]).'" />'.trim($row[id]).'</td>';
			echo'<td><div id="cb_'.trim($row[id]).'" class="childboard">';
			echo''.$str.'<input type="text" name="name['.trim($row[id]).']" ';
			echo 'value="'.trim($row[title]).'" style="width:160px;" class="txt" />';
			echo '</div></td>';
			echo'<td class="td25 lightfont"></td>';
			echo '<td class="td23"></td>';
			echo'<td width="160">';
			echo'<a href="admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=class&view=typeupdate&id='.trim($row[id]).'&fid='.trim($row[father]).'" class="act">删除</a></td></tr>';
			if($rsfno[id]!=''){
				prod_class_view($row['id'],$selid,$layer+1,$ac,$fileurl,$type);
			}
			
		}
	}
   return ;

}
function prod_type($fatherid=0,$selid=0,$layer=0,$type){
	$str="";
    global $db;
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_pord_type where father='$fatherid' ORDER BY id Asc");
	if(count($query)>0){
	   for($i=0;$i<$layer;$i++){
	   
	   $str.="├";
	   }
		while ($row = $db->fetch_array($query)) {
			$selstr = $row['id'] == $selid ? 'selected="selected"' : '';
			$htmlstr= '<option value="'.$row['id'].'"  '.$selstr.'>'.$str.$row['title'].'</option>';
			echo $htmlstr;
				prod_type($row['id'],$selid,$layer+1,$type);
		}

	}
   return ;

}
?>