<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');

get_key("office_type_r");
empty($do) && $do = 'list';
if ($do == 'list') {
	$id = getGP('id','G','int');
	$blog = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."human_form  WHERE id = '$id' ");
	include_once('template/human_form_edit.php');

} elseif ($do == 'save') {
	$savetype = getGP('savetype','P');
	$id = getGP('id','P','int');
	$formname = getGP('formname','P');
	$inputname = getGP('inputname','P');
	$inputvalue = getGP('inputvalue','P');
	$type = getGP('type','P');
	$inputtype = getGP('inputtype','P');
	$inputvaluenum = getGP('inputvaluenum','P');
	$confirmation = getGP('confirmation','P');
	$type1 = getGP('type1','P');
	
	
	//主表信息
	$human_form = array(
		'formname' => $formname,
		'inputvalue' => $inputvalue,
		'type' => $type,
		'inputtype' => $inputtype,
		'inputvaluenum' => $inputvaluenum,
		'confirmation' => $confirmation
	);
	//写入主表信息
	//insert_db('human_form',$human_form);
	update_db('human_form',$human_form, array('id' => $id));
	$id=$db->insert_id();
	$content=serialize($human_form);
	$title='编辑人事表单';
	get_logadd($id,$content,$title,37,$_USER->id);
	show_msg('编辑人事表单成功！', 'admin.php?ac=human_form&fileurl=human&type1='.$type1.'');

}

?>