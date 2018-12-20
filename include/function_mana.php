<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: function_mana.php 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/
!defined('IN_TOA') && exit('Access Denied!');

function get_keytable_view($fatherid=0,$seleid=0)
{
    global $db;
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."keytable where fatherid='$fatherid' ORDER BY number Asc  ");
	
	while ($row = $db->fetch_array($query)) {
	if($row["type"]=='1'){
	echo '<input type="radio" name="purview['.$row["inputname"].']" value="'.$row["inputvalue"].'" class="radio" ';
	if($seleid!='0'){
	echo checked(''.$row["inputname"].'',$row["inputvalue"]);
	}else{
	if($row["inputchecked"]=='1'){
	echo ' checked="checked" ';
	}	
	}	
	echo '/>'.$row["name"].'';
	}else{
    echo '<input type="checkbox" name="purview['.$row["inputname"].']" value="'.$row["inputvalue"].'"';
	if($seleid!=0){
	echo checked(''.$row["inputname"].'',$row["inputvalue"]);
	}else{
	if($row["inputchecked"]=='1'){
	echo 'checked="checked" ';
	}	
	}	
	echo '>'.$row["name"].'';
	}

	}
	
   return ;

}
function get_keytable_list($fatherid=0,$seleid=0)
{
    global $db;
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."keytable where fatherid='$fatherid' ORDER BY number Asc  ");
	echo '<table class="TableBlock" border="0" width="90%" align="center">';
	while ($row = $db->fetch_array($query)) {
	echo '<tr>';
    echo ' <td nowrap class="TableContent" width="90"> '.$row["name"].'';
	if($row["inputname"]!='0'){
		echo '<input type="checkbox" name="purview['.$row["inputname"].']" value="'.$row["inputvalue"].'"';
		if($seleid!=0){
			echo checked(''.$row["inputname"].'',$row["inputvalue"]);
		}else{
			if($row["inputchecked"]=='1'){
				echo 'checked="checked" ';
			}
		}
		echo '>';
	}
	echo '</td>';
    echo '  <td class="TableData">';
	get_keytable_view($row["id"],$seleid);
	echo '</td> </tr>';

	}
   echo '</table>';
   return ;

}
function get_oalog_type($type){
	switch ($type)
	{
		case 1:
		  echo "系统设置";
		  break;
		case 2:
		  echo "权限组设置";
		  break;
		case 3:
		  echo "用户帐号";
		  break;
		case 4:
		  echo "短消息";
		  break;
		case 5:
		  echo "电子邮件";
		  break;
		case 6:
		  echo "手机短信";
		  break;
		case 7:
		  echo "个人考勤";
		  break;
		case 8:
		  echo "个人假条";
		  break;
		case 9:
		  echo "通讯录";
		  break;
		case 10:
		  echo "工作日程";
		  break;
		case 11:
		  echo "工作日记";
		  break;
		case 12:
		  echo "工作计划";
		  break;
		case 13:
		  echo "新闻";
		  break;
		case 14:
		  echo "发文";
		  break;
		case 15:
		  echo "收文";
		  break;
		case 16:
		  echo "传真";
		  break;
		case 17:
		  echo "知识";
		  break;
		case 18:
		  echo "部门";
		  break;
		case 19:
		  echo "会议";
		  break;
		case 20:
		  echo "档案";
		  break;
		case 21:
		  echo "收藏";
		  break;
		case 22:
		  echo "图书";
		  break;
		case 23:
		  echo "办公用品";
		  break;
		case 24:
		  echo "固定资产";
		  break;
		case 25:
		  echo "岗位";
		  break;
		case 26:
		  echo "人事合同";
		  break;
		case 27:
		  echo "招聘管理";
		  break;
		case 28:
		  echo "培训计划";
		  break;
		case 29:
		  echo "奖惩记录";
		  break;
		case 30:
		  echo "论坛";
		  break;
		case 31:
		  echo "投票";
		  break;
		case 32:
		  echo "项目管理";
		  break;
		case 33:
		  echo "任务管理";
		  break;
		case 34:
		  echo "文档管理";
		  break;
		case 35:
		  echo "工作流";
		  break;
		default:
		  echo "错误类型";
	}
	return ;
}
//menu
function get_menu_list($fatherid=0,$selid=0,$layer=0,$ac,$fileurl){
    global $db;
	$sql="SELECT * FROM ".DB_TABLEPRE."menu where fatherid='$fatherid' ORDER BY menunum Asc";
	$query = $db->query($sql);
	echo '<tbody id="group_'.trim($fatherid).'">';
	if(count($query)>0){
		while ($row = $db->fetch_array($query)) {
			$rsfno = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."menu where fatherid='".$row[menuid]."' ORDER BY menunum asc limit 0,1");
			echo '<tr class="hover">';
			echo '<td class="td25"></td>';
			echo '<td class="td25"><input type="hidden" name="id[]" value="'.trim($row[menuid]).'" /><input type="text" class="txt" name="';
			echo 'menunum['.trim($row[menuid]).']" value="'.trim($row[menunum]).'" /></td>';
			echo '<td><div class="board"><input type="text" name="menuname['.trim($row[menuid]).']"';
			echo ' value="'.trim($row[menuname]).'" class="txt" /><input type="text" name="menuurl['.trim($row[menuid]).']" value="'.trim($row[menuurl]).'" class="txt" style="width:260px;" ';
			if(COOKSHOW==1){
				 echo ' readonly';
			}
			echo '/><input type="text" name="keytable['.trim($row[menuid]).']" value="'.trim($row[keytable]).'" class="txt" style="width:80px;" ';
			if(COOKSHOW==1){
				 echo ' readonly';
			}
			echo '/>';
			echo '<a href="###" onclick="addrowdirect = 1;addrow(this, 2, 2)" ';
			echo 'class="addchildboard">添加子菜单</a></div></td>';
			echo '<td class="td25 lightfont">('.trim($row[menuid]).')</td>';
			echo '<td class="td23"><select name="menutype['.trim($row[menuid]).']">';
			echo '<option value="0" ';
				if($row[menutype]=='0'){
					echo ' selected="selected"';
				 }
			echo '>正常</option>';
			echo '<option value="2" ';
				if($row[menutype]=='2'){
					echo ' selected="selected"';
				}
			echo '>桌面</option>';
			echo '<option value="1" ';
				if($row[menutype]=='1'){
					echo ' selected="selected"';
				}
			echo '>隐藏</option>';
			echo '</select></td>';
			echo '<td width="160">';
			if(COOKSHOW==1){
				 echo ' 不可删除';
			}else{
				echo '<a href="admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=update&id='.trim($row[menuid]).'" class="act">删除</a>';
			}
			echo '</td></tr>';
	
			if($rsfno[menuid]!=''){
				get_menu_list_view($row['menuid'],$selid,$layer+1,$ac,$fileurl);
			}
		}
	}
   echo '</tbody>';
   return ;

}

function get_menu_list_view($fatherid=0,$selid=0,$layer=0,$ac,$fileurl){
    global $db;
	$sql="SELECT * FROM ".DB_TABLEPRE."menu where fatherid='$fatherid' ORDER BY menunum Asc";
	$query = $db->query($sql);
	if(count($query)>0){
		while ($row = $db->fetch_array($query)) {
			echo'<tr class="hover"><td class="td25"></td>';
			echo'<td class="td25"><input type="hidden" name="id[]" value="'.trim($row[menuid]).'" /><input type="text" class="txt" name="menunum['.trim($row[menuid]).']" value="'.trim($row[menunum]).'" /></td>';
			echo'<td><div id="cb_'.trim($row[menuid]).'" class="childboard">';
			echo'<input type="text" name="menuname['.trim($row[menuid]).']" value="'.trim($row[menuname]).'" class="txt" />';
			echo'<input type="text" name="menuurl['.trim($row[menuid]).']" value="'.trim($row[menuurl]).'" class="txt" style="width:260px;"';
			if(COOKSHOW==1){
				 echo ' readonly';
			}
			echo ' />';
			echo'<input type="text" name="keytable['.trim($row[menuid]).']" value="'.trim($row[keytable]).'" class="txt" style="width:80px;"';
			if(COOKSHOW==1){
				 echo ' readonly';
			}
			echo ' /></div></td>';
			echo'<td class="td25 lightfont">('.trim($row[menuid]).')</td>';
			echo '<td class="td23"><select name="menutype['.trim($row[menuid]).']">';
			echo '<option value="0" ';
				if($row[menutype]=='0'){
					echo ' selected="selected"';
				 }
			echo '>正常</option>';
			echo '<option value="2" ';
				if($row[menutype]=='2'){
					echo ' selected="selected"';
				}
			echo '>桌面</option>';
			echo '<option value="1" ';
				if($row[menutype]=='1'){
					echo ' selected="selected"';
				}
			echo '>隐藏</option>';
			echo '</select></td>';
			echo'<td width="160">';
			if(COOKSHOW==1){
				 echo ' 不可删除';
			}else{
				echo '<a href="admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=update&id='.trim($row[menuid]).'" class="act">删除</a>';
			}
			echo '</td></tr>';
			
		}
	}
   return ;

}
function get_menu_newinherited($fatherid=0,$selid=0,$layer=0){
	$str="";
    global $db;
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."menu where fatherid='$fatherid' ORDER BY menunum Asc");
	if(count($query)>0){
	   for($i=0;$i<$layer;$i++){
	   
	   $str.="├";
	   }
		while ($row = $db->fetch_array($query)) {
			$selstr = $row['menuid'] == $selid ? 'selected="selected"' : '';
			$htmlstr= '<option value="'.$row['menuid'].'"  '.$selstr.'>'.$str.$row['menuname'].'</option>';
			echo $htmlstr;
				get_menu_newinherited($row['menuid'],$selid,$layer+1);
		}

	}
   return ;

}
//keytable
function get_keytable_list_save($fatherid=0,$selid=0,$layer=0,$ac,$fileurl){
    global $db;
	$sql="SELECT * FROM ".DB_TABLEPRE."keytable where fatherid='$fatherid' ORDER BY number Asc";
	$query = $db->query($sql);
	echo '<tbody id="group_'.trim($fatherid).'">';
	if(count($query)>0){
		while ($row = $db->fetch_array($query)) {
			$rsfno = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."keytable where fatherid='".$row[id]."' ORDER BY number asc limit 0,1");
			echo '<tr class="hover">';
			echo '<td class="td25"></td>';
			echo '<td class="td25"><input type="hidden" name="id[]" value="'.trim($row[id]).'" /><input type="text" class="txt" name="';
			echo 'number['.trim($row[id]).']" value="'.trim($row[number]).'" /></td>';
			echo '<td><div class="board"><input type="text" name="name['.trim($row[id]).']" ';
			echo 'value="'.trim($row[name]).'" style="width:160px;" class="txt" />';
			echo '<input type="text" name="inputname['.trim($row[id]).']" ';
			echo 'value="'.trim($row[inputname]).'" class="txt" style="width:80px;" ';
			if(COOKSHOW==1){
				 echo ' readonly';
			}
			echo '/>';
			echo '<input type="text" name="inputvalue['.trim($row[id]).']" ';
			echo 'value="'.trim($row[inputvalue]).'" class="txt" style="width:30px;" />';
			echo '<select name="type['.trim($row[id]).']">';
			echo '<option value="1" ';
				if($row[type]=='1'){
					echo ' selected="selected"';
				}
			echo '>单选</option>';
			echo '<option value="2" ';
			    if($row[type]=='2'){
					echo ' selected="selected"';
				}
			echo '>多选</option></select>  ';
			echo '<a href="###" onclick="addrowdirect = 1;addrow(this, 2, 2)" ';
			echo 'class="addchildboard">添加子栏目</a></div></td>';
			echo '<td class="td25 lightfont">('.trim($row[id]).')</td>';
			echo '<td class="td23"><select name="inputchecked['.trim($row[id]).']">';
			echo '<option value="1" ';
				if($row[inputchecked]=='1'){
					echo ' selected="selected"';
				 }
			echo '>是</option>';
			echo '<option value="2" ';
				if($row[inputchecked]=='2'){
					echo ' selected="selected"';
				}
			echo '>否</option>';
			echo '</select></td>';
			echo '<td width="160">';
			if(COOKSHOW==1){
				 echo ' 不可删除';
			}else{
			echo '<a href="admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=update&id='.trim($row[id]).'" class="act">删除</a>';
			}
			echo '</td></tr>';
	
			if($rsfno[id]!=''){
				get_keytable_list_save_view($row['id'],$selid,$layer+1,$ac,$fileurl);
			}
		}
	}
   echo '</tbody>';
   return ;

}
function get_keytable_list_save_view($fatherid=0,$selid=0,$layer=0,$ac,$fileurl){
    global $db;
	$sql="SELECT * FROM ".DB_TABLEPRE."keytable where fatherid='$fatherid' ORDER BY number Asc";
	$query = $db->query($sql);
	if(count($query)>0){
		while ($row = $db->fetch_array($query)) {
			echo'<tr class="hover"><td class="td25"></td>';
			echo'<td class="td25"><input type="hidden" name="id[]" value="'.trim($row[id]).'" /><input type="text" class="txt" name="';
			echo 'number['.trim($row[id]).']" value="'.trim($row[number]).'" /></td>';
			echo'<td><div id="cb_'.trim($row[id]).'" class="childboard">';
			echo'<input type="text" name="name['.trim($row[id]).']" ';
			echo 'value="'.trim($row[name]).'" style="width:120px;" class="txt" />';
			echo '<input type="text" name="inputname['.trim($row[id]).']" ';
			echo 'value="'.trim($row[inputname]).'" class="txt" style="width:150px;" ';
			if(COOKSHOW==1){
				 echo ' readonly';
			}
			echo '/>';
			echo '<input type="text" name="inputvalue['.trim($row[id]).']" ';
			echo 'value="'.trim($row[inputvalue]).'" class="txt" style="width:30px;" />';
			echo '<select name="type['.trim($row[id]).']">';
			echo '<option value="1" ';
				if($row[type]=='1'){
					echo ' selected="selected"';
				}
			echo '>单选</option>';
			echo '<option value="2" ';
			    if($row[type]=='2'){
					echo ' selected="selected"';
				}
			echo '>多选</option></select></div></td>';
			echo'<td class="td25 lightfont">('.trim($row[id]).')</td>';
			echo '<td class="td23"><select name="inputchecked['.trim($row[id]).']">';
			echo '<option value="1" ';
				if($row[inputchecked]=='1'){
					echo ' selected="selected"';
				 }
			echo '>是</option>';
			echo '<option value="2" ';
				if($row[inputchecked]=='2'){
					echo ' selected="selected"';
				}
			echo '>否</option>';
			echo '</select></td>';
			echo'<td width="160">';
			if(COOKSHOW==1){
				 echo ' 不可删除';
			}else{
			echo'<a href="admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=update&id='.trim($row[id]).'" class="act">删除</a>';
			}
			echo '</td></tr>';
			
			
		}
	}
   return ;

}
function get_keytable_newinherited($fatherid=0,$selid=0,$layer=0){
	$str="";
    global $db;
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."keytable where fatherid='$fatherid' ORDER BY number Asc");
	if(count($query)>0){
	   for($i=0;$i<$layer;$i++){
	   
	   $str.="├";
	   }
		while ($row = $db->fetch_array($query)) {
			$selstr = $row['id'] == $selid ? 'selected="selected"' : '';
			$htmlstr= '<option value="'.$row['id'].'"  '.$selstr.'>'.$str.$row['name'].'</option>';
			echo $htmlstr;
				get_keytable_newinherited($row['id'],$selid,$layer+1);
		}

	}
   return ;

}
//department
function get_department_list_save($fatherid=0,$selid=0,$layer=0,$ac,$fileurl){
    global $db;
	$sql="SELECT * FROM ".DB_TABLEPRE."department where father='$fatherid' ORDER BY id Asc";
	$query = $db->query($sql);
	echo '<tbody id="group_'.trim($fatherid).'">';
	if(count($query)>0){
		while ($row = $db->fetch_array($query)) {
			$rsfno = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."department where father='".$row[id]."' ORDER BY id asc limit 0,1");
			echo '<tr class="hover">';
			echo '<td class="td25"></td>';
			echo '<td class="td25"><input type="hidden" name="id[]" value="'.trim($row[id]).'" />'.trim($row[id]).'</td>';
			echo '<td class="td25"><input type="text" name="department_code[]" value="'.trim($row['department_code']).'" /></td>';
			echo '<td><div class="board"><input type="text" name="name['.trim($row[id]).']" ';
			echo 'value="'.trim($row[name]).'" style="width:160px;" class="txt" />';
			echo '  <a href="###" onclick="addrowdirect = 1;addrow(this, 2, 2)" ';
			echo 'class="addchildboard">添加下级部门</a></div></td>';
			// echo '<td class="td25 lightfont"></td>';
			echo '<td class="td23">'.trim($row['date']).'</td>';
			echo '<td width="160"><a href="admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=update&id='.trim($row[id]).'&fid='.trim($row[father]).'" class="act">删除</a></td></tr>';
	
			if($rsfno[id]!=''){
				get_department_list_save_view($row['id'],$selid,$layer+1,$ac,$fileurl);
			}
		}
	}
   echo '</tbody>';
   return ;

}
function get_department_list_save_view($fatherid=0,$selid=0,$layer=0,$ac,$fileurl){
    global $db;
	$sql="SELECT * FROM ".DB_TABLEPRE."department where father='$fatherid' ORDER BY id Asc";
	$query = $db->query($sql);
	if(count($query)>0){
		for($i=0;$i<$layer;$i++){
		   $str.="&nbsp;&nbsp;&nbsp;&nbsp;";
		   }
		while ($row = $db->fetch_array($query)) {
			$rsfno = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."department where father='".$row[id]."' ORDER BY id asc limit 0,1");
			echo'<tr class="hover"><td class="td25"></td>';
			echo'<td class="td25"><input type="hidden" name="id[]" value="'.trim($row[id]).'" />'.trim($row[id]).'</td>';
			echo'<td class="td25"><input type="text" name="department_code[]" value="'.trim($row[department_code]).'" /></td>';
			echo'<td><div id="cb_'.trim($row[id]).'" class="childboard">';
			echo''.$str.'<input type="text" name="name['.trim($row[id]).']" ';
			echo 'value="'.trim($row[name]).'" style="width:160px;" class="txt" />';
			echo '</div></td>';
			// echo'<td class="td25 lightfont"></td>';
			echo '<td class="td23">'.trim($row['date']).'</td>';
			echo'<td width="160">';
			echo'<a href="admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=update&id='.trim($row[id]).'&fid='.trim($row[father]).'" class="act">删除</a></td></tr>';
			if($rsfno[id]!=''){
				get_department_list_save_view($row['id'],$selid,$layer+1,$ac,$fileurl);
			}
			
		}
	}
   return ;

}
function get_department_newinherited($fatherid=0,$selid=0,$layer=0){
	$str="";
    global $db;
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."department where father='$fatherid' ORDER BY id Asc");
	if(count($query)>0){
	   for($i=0;$i<$layer;$i++){
	   
	   $str.="├";
	   }
		while ($row = $db->fetch_array($query)) {
			$selstr = $row['id'] == $selid ? 'selected="selected"' : '';
			$htmlstr= '<option value="'.$row['id'].'"  '.$selstr.'>'.$str.$row['name'].'</option>';
			echo $htmlstr;
				get_department_newinherited($row['id'],$selid,$layer+1);
		}

	}
   return ;

}
//position
function get_position_list_save($fatherid=0,$selid=0,$layer=0,$ac,$fileurl){
    global $db;
	$sql="SELECT * FROM ".DB_TABLEPRE."position where father='$fatherid'   ORDER BY id ASC";
	$query = $db->query($sql);
	echo '<tbody id="group_'.trim($fatherid).'">';
	if(count($query)>0){
		while ($row = $db->fetch_array($query)) {
			$rsfno = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."position where father='".$row[id]."'  ORDER BY id asc limit 0,1");
			echo '<tr class="hover">';
			echo '<td class="td25"></td>';
			echo '<td class="td25">'.trim($row[id]).'</td>';
			echo '<td class="td25"><input type="hidden" name="id[]" value="'.trim($row[id]).'" /><input type="text" name="code[]" value="'.trim($row[code]).'" /></td>';
			echo '<td><div class="board"><input type="text" name="name['.trim($row[id]).']" ';
			echo 'value="'.trim($row[name]).'" style="width:160px;" class="txt" />';
			echo '  <a href="###" onclick="addrowdirect = 1;addrow(this, 2, 2)" ';
			echo 'class="addchildboard">添加下级岗位</a></div></td>';
			echo '<td class="td25 lightfont"></td>';
			echo '<td class="td23">'.trim($row['date']).'</td>';
			echo '<td width="160"><a href="admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=update&id='.trim($row[id]).'&fid='.trim($row[father]).'" class="act">删除</a></td></tr>';
	
			if($rsfno[id]!=''){
				get_position_list_save_view($row['id'],$selid,$layer+1,$ac,$fileurl);
			}
		}
	}
   echo '</tbody>';
   return ;

}
function get_position_list_save_view($fatherid=0,$selid=0,$layer=0,$ac,$fileurl){
    global $db;
	$sql="SELECT * FROM ".DB_TABLEPRE."position where father='$fatherid' ORDER BY id Asc";
	$query = $db->query($sql);
	if(count($query)>0){
		for($i=0;$i<$layer;$i++){
		   $str.="&nbsp;&nbsp;&nbsp;&nbsp;";
		   }
		while ($row = $db->fetch_array($query)) {
			$rsfno = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."position where father='".$row[id]."' ORDER BY id asc limit 0,1");
			echo'<tr class="hover"><td class="td25"></td>';
			echo'<td class="td25"><input type="hidden" name="id[]" value="'.trim($row[id]).'" />'.trim($row[id]).'</td>';
			echo'<td class="td25"><input type="hidden" name="id[]" value="'.trim($row[id]).'" /><input type="text" name="code[]" value="'.trim($row[code]).'" /></td>';
			echo'<td><div id="cb_'.trim($row[id]).'" class="childboard">';
			echo''.$str.'<input type="text" name="name['.trim($row[id]).']" ';
			echo 'value="'.trim($row[name]).'" style="width:160px;" class="txt" />';
			echo '</div></td>';
			echo'<td class="td25 lightfont"></td>';
			echo '<td class="td23">'.trim($row['date']).'</td>';
			echo'<td width="160">';
			echo'<a href="admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=update&id='.trim($row[id]).'&fid='.trim($row[father]).'" class="act">删除</a></td></tr>';
			if($rsfno[id]!=''){
				get_position_list_save_view($row['id'],$selid,$layer+1,$ac,$fileurl);
			}
			
		}
	}
   return ;

}
function get_position_newinherited($fatherid=0,$selid=0,$layer=0){
	$str="";
    global $db;
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."position where father='$fatherid' ORDER BY id Asc");
	if(count($query)>0){
	   for($i=0;$i<$layer;$i++){
	   
	   $str.="├";
	   }
		while ($row = $db->fetch_array($query)) {
			$selstr = $row['id'] == $selid ? 'selected="selected"' : '';
			$htmlstr= '<option value="'.$row['id'].'"  '.$selstr.'>'.$str.$row['name'].'</option>';
			echo $htmlstr;
				get_position_newinherited($row['id'],$selid,$layer+1);
		}

	}
   return ;

}
//更新数据
function get_config_update($name='',$value=''){
	if($name!=''){
		$config = array(
			'value' => $value
		);
		update_db('config',$config, array('name'=>$name));
	}
	return ;
}
//写入数据
function get_config_insert($name='',$value=''){
	if($name!=''){
		$config = array(
			'name' => $name,
			'value' => $value
		);
		insert_db('config',$config);
	}
	return ;
}


?>