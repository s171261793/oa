<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');

get_key("office_type_r");
empty($do) && $do = 'list';
if ($do == 'list') {
	include_once('template/human_form_add.php');

} elseif ($do == 'save') {
	$savetype = getGP('savetype','P');
	$formname = getGP('formname','P');
	$inputname = "toa_".getGP('type1','P')."_".getGP('inputname','P');
	$inputvalue = getGP('inputvalue','P');
	$type = getGP('type','P');
	$inputtype = getGP('inputtype','P');
	$inputvaluenum = getGP('inputvaluenum','P');
	$confirmation = getGP('confirmation','P');
	$type1 = getGP('type1','P');
	$uid = $_USER->id;
	$date=get_date('Y-m-d H:i:s',PHP_TIME);
	//主表信息
	$human_form = array(
		'formname' => $formname,
		'inputname' => $inputname,
		'inputvalue' => $inputvalue,
		'type' => $type,
		'inputtype' => $inputtype,
		'inputvaluenum' => $inputvaluenum,
		'confirmation' => $confirmation,
		'type1' => $type1
	);
	//写入主表信息
	insert_db('human_form',$human_form);
	$id=$db->insert_id();
	$content=serialize($human_form);
	$title='添加人事表单';
	get_logadd($id,$content,$title,37,$_USER->id);
	show_msg('添加人事表单成功！', 'admin.php?ac=human_form&fileurl=human&type1='.$type1.'');

}

?>