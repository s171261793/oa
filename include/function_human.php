<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: function_human.php 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/
!defined('IN_TOA') && exit('Access Denied!');
function GET_INC_TRAINING_RECOR_NAME($fid=0)
{
    global $db;
	$html='';
	$query = $db->query("SELECT name FROM ".DB_TABLEPRE."training where id='".$fid."'  ORDER BY id desc limit 0,1");
	while ($rowuser = $db->fetch_array($query)) {
		$html .= $rowuser[name];
	}
	return $html;
}
//人事管理
/****************************************************************
************人事管理**********************************************
****************************************************************/
//获取人事数据
function get_human_db($id=0,$name=''){
	global $db;
	$row = $db->fetch_one_array("SELECT inputvalue FROM ".DB_TABLEPRE."human_db where typeid='".$id."' and inputname='".$name."'  ORDER BY id Asc");
	return $row['inputvalue'];	
}
//获取表单值
function get_human_form_value($inputname='',$type1='',$name='inputvalue'){
	global $db;
	$row = $db->fetch_one_array("SELECT ".$name." FROM ".DB_TABLEPRE."human_form where type1='".$type1."' and inputname='".$inputname."'  ORDER BY id Asc");
	return $row[$name];	
}
//单选
function get_human_radio($name='',$radiovalue='',$value=''){
		$inputvaluenum=explode('|',$radiovalue); 
		for($i=0;$i<sizeof($inputvaluenum);$i++){
			$html.= '<input name="'.$name.'" type="radio" value="'.$inputvaluenum[$i].'" ';
			if($value==''){
				if($i=='0'){
					$html.= 'checked="checked"';
				}
			}else{
				if($value==$inputvaluenum[$i]){
					$html.= 'checked="checked"';
				}
			}
			$html.= '/>'.$inputvaluenum[$i].'';
		}
	return $html;
}
//多选
function get_human_checkbox($name='',$radiovalue='',$value=''){
		$inputvaluenum=explode('|',$radiovalue); 
		for($i=0;$i<sizeof($inputvaluenum);$i++){
			$html.= '<input name="'.$name.'" type="checkbox" value="'.$inputvaluenum[$i].'" ';
			if($value==''){
				if($i=='0'){
					$html.= 'checked="checked"';
				}
			}else{
				if($value==$inputvaluenum[$i]){
					$html.= 'checked="checked"';
				}
			}
			$html.= '/>'.$inputvaluenum[$i].'';
		}
	return $html;
}
//日期
function get_human_date($name='',$value=''){
	return '<input size="10" class="inputdate" style="width:150px;" type="text" value="'.$value.'" name="'.$name.'" onClick="WdatePicker();" />';
}

//文本域
function get_human_input($name='',$w=300,$h=20,$value=''){
	return '<input type="text" name="'.$name.'" class="BigInput" style="width:'.$w.'px;height:'.$h.'px;" value="'.$value.'" />';
}
//下拉框
function get_human_select($name='',$radiovalue='',$value=''){
	$inputvaluenum=explode('|',$radiovalue); 
	$html.='<select name="'.$name.'" id="'.$name.'">';
	$html.='<option value="" selected="selected">选择内容</option>';
	for($i=0;$i<sizeof($inputvaluenum);$i++){
		$html.='<option value="'.$inputvaluenum[$i].'"';
		if($value==$inputvaluenum[$i]){
			$html.= ' selected="selected"';
		}
		$html.='>'.$inputvaluenum[$i].'</option>';	
	}
	$html.='</select> ';
	return $html;
}
?>