<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: mod_department 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/

(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
get_key("department_");
empty($do) && $do = 'adds';
if( $do == 'adds')
{
	include_once('template/department_adds.php');
}
else if ($do == 'list') {
	include_once('template/department.php');

}elseif ($do == 'save') {
	$idarr = getGP('id','P','array');
	$persno = getGP('persno','P','array');
	$name = getGP('name','P','array');
	$newdepartment_code = getGP('newdepartment_code','P','array');
	$department_code = getGP('department_code','P','array');
	$date = get_date('Y-m-d H:i:s',PHP_TIME);
	foreach ($idarr as $key=>$id) {
		if($name[$id]=='')$name[$id]='新部门名称';
		if($persno[$id]=='')$persno[$id]='负责人为空?';
		$department = array(
			'name' => $name[$id],
			'persno' => $persno[$id],
			'department_code' => $department_code[$key]
		);

		update_db('department',$department, array('id' => $id));
	}
	if(getGP('newid','P','array')!='' || getGP('newids','P','array')!=''){
		$newname = '';
		foreach (getGP('newname','P','array') as $name) {
			$newname.=$name.',';
		}

		$newpersno = '';
		foreach (getGP('newpersno','P','array') as $name) {
			$newpersno.=$name.',';
		}

		$newinherited = '';
		foreach (getGP('newinherited','P','array') as $name) {
			$newinherited.=$name.',';
		}

		$newdepartment_code = '';
		foreach (getGP('newdepartment_code','P','array') as $name) {
			$newdepartment_code.=$name.',';
		}

		$newname=substr($newname, 0, -1);
		$newpersno=substr($newpersno, 0, -1);
		$newinherited=substr($newinherited, 0, -1);
		$newdepartment_code=substr($newdepartment_code, 0, -1);


		$newname=explode(',',$newname);
		$newpersno=explode(',',$newpersno);
		$newinherited=explode(',',$newinherited);
		$newdepartment_code=explode(',',$newdepartment_code);

		if($newname!=''){
			for($i=0;$i<sizeof($newname);$i++){
				if($newname[$i]!=''){
					if($newinherited[$i]!=''){
						$fatherid=trim($newinherited[$i]);
					}else{
						$fatherid='0';
					}
					$department = array(
						'name' => $newname[$i],
						'persno' => $newpersno[$i],
						'father'=>$fatherid,
						'date'=>$date,
						'department_code'=>$newdepartment_code[$i]
					);
					insert_db('department',$department);
				}
			}
		}
		//$str=',新增了<font color=red>'.sizeof($newname).'</font>条信息';
	}
	$content=serialize($idarr).serialize($persno).serialize($name);
	$title='部门信息';
	get_logadd($id,$content,$title,18,$_USER->id);
	oa_mana_recache('department','id','id');
	show_msg('批量部门信息更新成功'.$str.'！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
}elseif ($_GET['do'] == 'update') {
	$db->query("DELETE FROM ".DB_TABLEPRE."department WHERE id = '".$_GET[id]."' ");
	$db->query("UPDATE ".DB_TABLEPRE."department set father='".$_GET['fid']."' WHERE father = '".$_GET[id]."' ");
	oa_mana_recache('department','id','id');
	show_msg('部门信息删除成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
}else if($_GET['do'] == 'add'){

	if($_GET['method'])
	{
		$date = get_date('Y-m-d H:i:s',PHP_TIME);
		$arrayInfo = array(

				'name'=> getGP('name','P'),
				'date'=>$date,
				'father'=>getGP('father','P'),
				'department_code'=>getGP('father','P'),
				'department_persno'=>getGP('positionid','P'),
				'department_company'=>getGP('department_company','P')
			);

		insert_db('department',$arrayInfo);
		show_msg('部门信息添加成功'.$str.'！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
	}
	else
	{
		include_once('template/department_add.php');
		//添加部门
		
	}

}
elseif ($_GET['do'] == 'delete') {
	$db->query("DELETE FROM ".DB_TABLEPRE."department WHERE id = '".$_GET[departemnt]."' ");
	$db->query("DELETE FROM ".DB_TABLEPRE."department  WHERE father = '".$_GET[departemnt]."' ");
	oa_mana_recache('department','id','id');
	show_msg('部门删除成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
}
else if($_GET['do'] == 'user'){

	//列表信息 
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'';

	if ($name = getGP('name','G')) {
		$wheresql .= " AND b.name LIKE '%$name%'";
		$url .= '&name='.rawurlencode($name);
	}
	if ($username = getGP('username','G')) {
		$wheresql .= " AND a.username LIKE '%$username%'";
		$url .= '&username='.rawurlencode($username);
	}
	if ($department = getGP('department','G','int')) {
		$wheresql .= " AND a.departmentid LIKE ',%$department%,'";
		$url .= '&department='.$department;	
	}
	if ($usergroup = getGP('usergroup','G','int')) {
		$wheresql .= " AND a.groupid = $usergroup";
		$url .= '&usergroup='.$usergroup;	
	}
	$ischeck = getGP('ischeck','G');
	if ($ischeck!='') {
		$wheresql .= " AND a.ischeck = '".$ischeck."'";
		$url .= '&ischeck='.$ischeck;	
	}
	
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."user a,".DB_TABLEPRE."user_view b WHERE a.id=b.uid $wheresql");
     $sql = "SELECT * FROM ".DB_TABLEPRE."user a,".DB_TABLEPRE."user_view b WHERE a.id=b.uid $wheresql ORDER BY a.numbers ASC LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);

		include_once('template/user_department.php');
	
}else if($do == 'edit'){

	if($_GET['method'])
	{
		//根据参数取出数据
		$department_id = $_POST['deparid'];
		$date = get_date('Y-m-d H:i:s',PHP_TIME);
		$arrayInfo = array(

				'name'=> getGP('name','P'),
				'date'=>$date,
				// 'father'=>getGP('father','P'),
				'department_code'=>getGP('department_code','P'),
				'department_persno'=>getGP('positionid','P'),
				'department_company'=>getGP('department_company','P')
			);
		
		$dau = update_db('department',$arrayInfo,array('id'=>$department_id));
		show_msg('部门信息更新成功'.$str.'！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
	}
	else
	{
		//根据参数取出数据
		$department_id = $_GET['department'];
		$sql = "SELECT * FROM ".DB_TABLEPRE."department  WHERE id=".$department_id;
		$result = $db->fetch_one_array($sql);

		// dump($result);die;
		include_once('template/department_save.php');
		//添加部门
		
	}

}






//读取部门
function public_list($fatherid=0,$selid=0,$layer=0,$ac,$fileurl){
    global $db;
	$sql="SELECT * FROM ".DB_TABLEPRE."department where father='$fatherid' ORDER BY id Asc";
	$query = $db->query($sql);
	echo '<tbody id="group_'.trim($fatherid).'">';
	if(count($query)>0){
		while ($row = $db->fetch_array($query)) {
			$rsfno = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."department where father='".$row[id]."' ORDER BY id asc limit 0,1");
			echo '<tr class="hover">';
			echo '<td width="20"></td>';
			echo '<td width="500"><div class="board"><input type="checkbox" name="id[]" value="'.$row['id'].'" class="checkbox" /><a href="javascript:void(0)" onclick="edits('.trim($row['id']).')">(编辑)</a>&nbsp<a href="javascript:void(0)" onclick="clickds('.trim($row['id']).')">'.trim($row[name]).'</a>&nbsp<a href="/admin.php?ac=department&fileurl=mana&do=add&departemntids='.trim($row['id']).'">+</a>&nbsp<a href="javascript:void(0)"  onClick="dels('.trim($row['id']).')">-</a></span></td>';
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
	$sql="SELECT * FROM ".DB_TABLEPRE."department where father='$fatherid' ORDER BY id Asc";
	$query = $db->query($sql);
	if(count($query)>0){
		for($i=0;$i<$layer;$i++){
		   $str.="&nbsp;&nbsp;&nbsp;&nbsp;";
		   }
		while ($row = $db->fetch_array($query)) {
			$rsfno = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."department where father='".$row[id]."' ORDER BY id asc limit 0,1");
			echo'<tr class="hover"><td width="20"></td>';
			echo'<td width="520"><div id="cb_'.trim($row[id]).'" class="childboard">'.$str.'<input type="checkbox" name="id[]" value="'.$row['id'].'" class="checkbox" /> <a href="javascript:void(0)" onclick="edits('.trim($row['id']).')">(编辑)</a>&nbsp';
			echo'<a href="javascript:void(0)" onclick="clickds('.trim($row['id']).')">'.trim($row[name]).'</a>&nbsp<a href="/admin.php?ac=department&fileurl=mana&do=add&departemntids='.trim($row['id']).'">+</a>&nbsp<a href="javascript:void(0)" onclick="dels('.trim($row['id']).')">-</a></div></td>';
			echo'</tr>';
			if($rsfno[id]!=''){
				public_view($row['id'],$selid,$layer+1,$ac,$fileurl);
			}
			
		}
	}
   return ;

}



?>