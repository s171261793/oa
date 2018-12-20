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
	$filenumber=random(6,'0123456789').get_date('ymdHis',PHP_TIME);
	$_title='新增';
	include_once('template/humanadd'.$type.'.php');
}elseif ($do == 'edit') {
	$filenumber=random(6,'0123456789').get_date('ymdHis',PHP_TIME);
	$id = getGP('id','G','int');
	$_title='编辑';
	$blog = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."human_info  WHERE id = '$id' ");
	include_once('template/humanadd'.$type.'.php');
}elseif ($do == 'addsave') {
	$savetype = getGP('savetype','P');
	$id = getGP('id','P');
	if($id!=''){
		//更新附件
		$fileoffice = array(
			'officeid' => $id
		);
		update_db('fileoffice',$fileoffice, array('number' =>$_POST['filenumber']));
		global $db;
		$query = $db->query("SELECT * FROM ".DB_TABLEPRE."human_form where type1='".$type."'  ORDER BY id Asc");
		while ($row = $db->fetch_array($query)) {
				$human_db = array(
					'inputvalue' => getGP(''.$row["inputname"].'','P')
				);
				update_db('human_db',$human_db, array('typeid' => $id,'type1' =>$type,'inputname' =>$row["inputname"]));
		}
		$content=serialize($row);
		$title='编辑'.$human_type_name.'信息';
		get_logadd($id,$content,$title,37,$_USER->id);
		show_msg('编辑'.$human_type_name.'信息成功！', 'admin.php?ac=humanlist&fileurl=human&type='.$type);
	}else{
		$userid = getGP('userid','P');
		$username = getGP('user','P');
		$number = getGP('number','P');
		$uid = $_USER->id;
		$date=get_date('Y-m-d H:i:s',PHP_TIME);
		//主表信息
		$human_info = array(
			'number' => $number,
			'userid' => $userid,
			'username' => $username,
			'uid' => $uid,
			'date' => $date,
			'type' => $type
		);
		//写入主表信息
		insert_db('human_info',$human_info);
		$id=$db->insert_id();
		//更新附件
		$fileoffice = array(
			'officeid' => $id
		);
		update_db('fileoffice',$fileoffice, array('number' =>$_POST['filenumber']));
		global $db;
		$query = $db->query("SELECT * FROM ".DB_TABLEPRE."human_form where type1='".$type."'  ORDER BY id Asc");
		while ($row = $db->fetch_array($query)) {
				$human_db = array(
				'formname' => $row["formname"],
				'inputname' => $row["inputname"],
				'inputvalue' => getGP(''.$row["inputname"].'','P'),
				'type' => $row["type"],
				'inputtype' => $row["inputtype"],
				'inputvaluenum' => $row["inputvaluenum"],
				'confirmation' => $row["confirmation"],
				'type1' => $type,
				'typeid' => $id
			);
			insert_db('human_db',$human_db);
		}
	
		$content=serialize($human_info);
		$title='新建'.$human_type_name.'信息';
		get_logadd($id,$content,$title,37,$_USER->id);
		show_msg('新建'.$human_type_name.'信息成功！', 'admin.php?ac=humanlist&fileurl=human&type='.$type);
	}

}

?>