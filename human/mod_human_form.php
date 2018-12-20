<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
get_key("office_type_r");
if($_GET["type1"]=='1'){
	$human_form_type='档案';
}elseif($_GET["type1"]=='2'){
	$human_form_type='证照';
}elseif($_GET["type1"]=='3'){
	$human_form_type='学习经历';
}elseif($_GET["type1"]=='4'){
	$human_form_type='工作经历';
}elseif($_GET["type1"]=='5'){
	$human_form_type='劳动技能';
}elseif($_GET["type1"]=='6'){
	$human_form_type='社会关系';
}elseif($_GET["type1"]=='7'){
	$human_form_type='人事调动';
}elseif($_GET["type1"]=='8'){
	$human_form_type='复职管理';
}elseif($_GET["type1"]=='9'){
	$human_form_type='职称评定';
}elseif($_GET["type1"]=='10'){
	$human_form_type='员工关怀';
}else{
	$human_form_type='';
}
empty($do) && $do = 'list';
if ($do == 'list') {
	//列表信息 
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac=human_form&fileurl=human&type1='.$_GET["type1"].'';
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."human_form WHERE type1='".trim($_GET["type1"])."'  ");
    $sql = "SELECT * FROM ".DB_TABLEPRE."human_form WHERE type1='".trim($_GET["type1"])."'   ORDER BY id asc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	include_once('template/human_form.php');

} elseif ($do == '删 除') {
	
	$idarr = getGP('id','P','array');
	foreach ($idarr as $id) {
	$db->query("DELETE FROM ".DB_TABLEPRE."human_form WHERE id = '$id' ");	
	}
	$content=serialize($idarr);
	$title='删除CRM表单';
	get_logadd($id,$content,$title,37,$_USER->id);
	show_msg('删除CRM表单成功！', 'admin.php?ac=human_form&fileurl=human&type1='.$_GET["type1"].'');

}
?>