<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: mod_user 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
get_key("config_user");


empty($do) && $do = 'list';
if(getGP('ischeck','G')=='1'){
	$_check['ischeck1']='  ui-tab-trigger-item-current';
}
if(getGP('ischeck','G')=='0'){
	$_check['ischeck2']='  ui-tab-trigger-item-current';
}
if(getGP('ischeck','G')==''){
	$_check['ischeck']='  ui-tab-trigger-item-current';
}
if ($do == 'list') {
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

	include_once('template/user.php');

} elseif ($do == '删 除') {
	
	get_key("config_user_delete");
	$idarr = getGP('id','P','array');
	foreach ($idarr as $id) {
		$db->query("DELETE FROM ".DB_TABLEPRE."user WHERE id = '$id' ");
		$db->query("DELETE FROM ".DB_TABLEPRE."user_view WHERE uid = '$id' ");	
	}
	$content=serialize($idarr);
	$title='删除用户信息';
	get_logadd($id,$content,$title,3,$_USER->id);
	show_msg('账户信息删除成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');

}elseif ($do == '排 序') {
	$idarr = getGP('id','P','array');
	$numberarr = getGP('numbers','P','array');
	foreach ($idarr as $id) {
		$db->query("update ".DB_TABLEPRE."user set numbers='".$numberarr[$id]."'  WHERE id = '".$id."' ");
	}
	show_msg('账户信息排序成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');

} elseif ($do == 'excel') {
	$datename="user_".get_date('YmdHis',PHP_TIME);
	$outputFileName = 'data/excel/'.$datename.'.xls';
		$content = array();
		$archive=array("用户名","权限组","员工编号","入职时间","姓名","岗位","所属部门");
		$content[] = $archive;
		$wheresql = '';
		if ($keyword = getGP('keyword','P')) {
			$wheresql .= " AND (b.name LIKE '%$keyword%' OR a.username LIKE '%$keyword%')";
			
		}
		if ($department = getGP('department','P','int')) {
			$wheresql .= " AND a.departmentid = $department";
			
		}
		if ($usergroup = getGP('usergroup','P','int')) {
			$wheresql .= " AND a.groupid = $usergroup";
				
		}
		$sql = "SELECT * FROM ".DB_TABLEPRE."user a,".DB_TABLEPRE."user_view b WHERE a.id=b.uid $wheresql ORDER BY a.id ASC";
		$result = $db->query($sql);

		// dump($row = $db->fetch_all($result));die;
		while ($row = $db->fetch_array($result)) {	
			if($row['ischeck']=='1'){
				$ischeck='正常';
			}else{
				$ischeck='禁用';
			}
			$archive = array(
				"".$row[username]."",
				"".get_groupname($row['groupid'])."",
				"".$row['usercode']."",
				"".str_replace("-",",",$row[create_time])."",
				"".$row[name]."",
				"".get_postname($row['positionid'])."",
				// "".$ischeck."","".$row[loginip]."",
				"".get_realdepaname($row['departmentid']).""
			);

			$content[] = $archive;

			// dump( $content );die;
		}
	$excel = new ExcelWriter($outputFileName);
	if($excel==false) 
		echo $excel->error; 
	foreach($content as $v){
		$excel->writeLine($v);
	}
	$excel->sendfile($outputFileName);
}elseif ($do == 'add') {
	
	if($_POST['view']!='')
	{
		$id = getGP('id','P','int');
		if($id!=''){
			$username = getGP('username','P');
			if (getGP('password','P')!=''){
				$password = md5(getGP('password','P'));
			}else{
				$password = getGP('oldpassword','P');
			}
			$departmentid = ','.getGP('departmentid','P').',';
			$name = getGP('name','P');
			$ischeck = getGP('ischeck','P');
			$positionid = ','.getGP('positionid','P').',';
			$loginip = getGP('loginip','P');
			$groupid = getGP('groupid','P');
			$keytype = getGP('keytype','P');
			$unionflag = getGP('unionflag','P');
			$keytypeuser = getGP('keytypeuser','P');
			$birthday = getGP('birthday','P');
			$create_time = getGP('create_time','P');
			$user = array(
				'password' => $password,
				'groupid' => $groupid,
				'ischeck' => $ischeck,
				'departmentid' => $departmentid,
				'positionid' => $positionid,
				'loginip' => $loginip,
				'keytype' => $keytype,
				'keytypeuser' => $keytypeuser,
				'birthday' => $birthday,
				'usercode' => $_POST['usercode'],
				'create_time' => $create_time
			);

			$user_view = array(
				'name' => $name
			);

			$as = update_db('user',$user, array('id' => $id));
			update_db('user_view',$user_view, array('uid' => $id));
			if($id!=''){
			   $content=serialize($user).serialize($user_view);
			   $title='修改用户信息'.$name;
			   get_logadd($id,$content,$title,3,$_USER->id);
			}

			show_msg($title.'成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list',8);
		}else{
			//获取企业数据
			global $db;
			//获取汇总
			$usersums = $db->fetch_one_array("SELECT COUNT(*) AS usersum FROM ".DB_TABLEPRE."user  ");
			
			if($_CONFIG->config_data('usernum')!='0'){
				$ussum=$_CONFIG->config_data('usernum')-$usersums['usersum'];
			}else{
				$ussum='999999';
			}
			//if($usersums['usersum']>=50){
			//	show_msg('对不起，己经超出用户限定数据，请联系管理员！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
			//}
			$username = getGP('username','P');
			$password = md5(getGP('password','P'));
			$departmentid = ','.getGP('departmentid','P').',';
			$name = getGP('name','P');
			if(getGP('ischeck','P')==''){
				$ischeck = 1;
			}else{
				$ischeck = getGP('ischeck','P');
			}
			$positionid = ','.getGP('positionid','P').',';
			$loginip = getGP('loginip','P');
			$groupid = getGP('groupid','P');
			$usercode = getGP('usercode','P');
			$create_time = getGP('create_time','P');
			$birthday = getGP('birthday','P');
			$udate=get_date('y-m-d H:i:s',PHP_TIME);
			
			$u_username = $db->result("SELECT COUNT(*) AS u_username FROM ".DB_TABLEPRE."user where username='".$username."' ");
			$u_name = $db->result("SELECT COUNT(*) AS u_name FROM ".DB_TABLEPRE."user_view where name='".$name."'");
			if($u_username>0){
				show_msg('对不起，用户名己经存在，请更改用户名！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
			}
			if($u_name>0){
				show_msg('对不起，姓名己经存在，请更改姓名！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
			}
			$keytype = getGP('keytype','P');
			$keytypeuser = getGP('keytypeuser','P');
			$user = array(
				'username' => $username,
				'password' => $password,
				'usercode' => $usercode,    
				'create_time' => $create_time,
				'groupid' => $groupid,
				'ischeck' => $ischeck,
				'departmentid' => $departmentid,
				'positionid' => $positionid,
				'loginip' => $loginip,
				'date' => $udate,
				'keytype' => $keytype,
				'birthday' => $birthday,
				'keytypeuser' => $keytypeuser
			);

			insert_db('user',$user);
			$id=$db->insert_id();
			$user_view = array(
				'name' => $name,
				'uid' => $id
			);
			insert_db('user_view',$user_view);
			if($id!=''){
			   $content=serialize($user).serialize($user_view);
			   $title='添加新用户'.$username;
			   get_logadd($id,$content,$title,3,$_USER->id);
			   show_msg($title.'成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list',8);
			}



		}
		
		
	}else{


		$id = getGP('id','G','int');
		if($id!=''){
			$user = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."user a,".DB_TABLEPRE."user_view b WHERE a.id=b.uid and a.id = '$id' ");
			get_key("config_user_edit");
			$_title['name']='编辑';
		}else{
			get_key("config_user_Increase");
			$user['unionflag']='0';
			$user['keytype']='2';
			$user['ischeck']='1';
			$_title['name']='发布';
		}

		include_once('template/useradd.php');
		
	}
	
}elseif ($do == 'exceladd') {
	
	if($_POST['view']!=''){
		$handle = fopen(getGP('address','P'), 'r');
		$result = input_csv($handle); //解析csv
		$len_result = count($result);
		if($len_result==0){
			echo '没有任何数据！';
			exit;
		}
		for ($i = 1; $i < $len_result; $i++) { //循环获取各字段值
			if(trim($result[$i][0])!=''){    
				$row = $db->fetch_one_array("SELECT username FROM ".DB_TABLEPRE."user WHERE username = '".mb_convert_encoding(trim($result[$i][0]),"UTF-8","GB2312")."'");
				if(trim($row['username'])==''){
					//echo $result[$i][0].'/'.mb_convert_encoding($result[$i][1],"UTF-8","GB2312").'/'.$result[$i][2].'/'.mb_convert_encoding($result[$i][3],"UTF-8","GB2312").'/'.mb_convert_encoding($result[$i][4],"UTF-8","GB2312").'/'.$result[$i][5];
					//exit;
					$user = array();
					$user['username']=mb_convert_encoding($result[$i][0],"UTF-8","GB2312");//$result[$i][0];
					if(trim($result[$i][2])!=''){
						$user['password']=md5($result[$i][2]);
					}else{
						$user['password']=md5('123456');
					}
					if($result[$i][5]!=''){
						$user['groupid']=$result[$i][5];
					}else{
						$user['groupid']=3;
					}
					$user['ischeck']=1;
					if(mb_convert_encoding($result[$i][4],"UTF-8","GB2312")!=''){
						$user['departmentid']=','.public_value('id','department',"name='".mb_convert_encoding($result[$i][4],"UTF-8","GB2312")."'").',';
					}
					if(mb_convert_encoding($result[$i][3],"UTF-8","GB2312")!=''){
						$user['positionid']=','.public_value('id','position',"name='".mb_convert_encoding($result[$i][3],"UTF-8","GB2312")."'").',';
					}
					$user['date']=get_date('Y-m-d H:i:s',PHP_TIME);
					$user['keytype']=2;
					insert_db('user',$user);
					$vid=$db->insert_id();
					$userview = array();
					$rows = $db->fetch_one_array("SELECT name FROM ".DB_TABLEPRE."user_view WHERE name = '".trim(mb_convert_encoding($result[$i][1],"UTF-8","GB2312"))."'");
					if($rows['name']==''){
						if(mb_convert_encoding($result[$i][1],"UTF-8","GB2312")!=''){
							$userview['name']=mb_convert_encoding($result[$i][1],"UTF-8","GB2312");
						}else{
							$userview['name']='无名'.$vid;
						}
					}else{
						$userview['name']='无名'.$vid;
					}
					$userview['sex']=mb_convert_encoding($result[$i][6],"UTF-8","GB2312");
					$userview['tel']=mb_convert_encoding($result[$i][7],"UTF-8","GB2312");
					$userview['phone']=mb_convert_encoding($result[$i][8],"UTF-8","GB2312");
					$userview['email']=mb_convert_encoding($result[$i][9],"UTF-8","GB2312");
					$userview['fax']=mb_convert_encoding($result[$i][10],"UTF-8","GB2312");
					$userview['uid']=$vid;
					insert_db('user_view',$userview);
				}
			}
			//echo $result[$i][0].'<br>';
		}
		fclose($handle); //关闭指针
		//echo    '导入成功';
		sleep(1);
		show_msg('账户信息导入成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
		//echo '<script language="JavaScript">window.close()/script>';
		exit;
	}else{
		include_once('template/userexcel.php');
		
	}
	
}

?>