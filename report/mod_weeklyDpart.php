<?php 
	
	//设置默认时区
	date_default_timezone_set('PRC');
	//是否有权限
	(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
	empty($do) && $do = 'list';

	if($do == 'list')
	{

		$page = max(1, getGP('page','G','int'));
		// $pagesize = 2;	
		$pagesize = $_CONFIG->config_data('pagenum');
		$offset = ($page - 1) * $pagesize;
		$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list';

		$data = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."weekly_depart  order by create_time DESC LIMIT ".$offset.",".$pagesize);

		$nums = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."weekly_depart");
		$num = count($nums);

		include_once('template/week_depart_list.php');

	}
	else if($do == 'add')
	{
		
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			// dump($_POST);die;
			$departmentid = $_POST['departmentid'];
			$user_id      = array_filter($_POST['user_id']);
			$number = 0; 

			foreach($user_id as $key=>$value)
			{	
				//判断是否已经有数据
				$status = $db->fetch_one_array( "SELECT count(1) as num FROM ".DB_TABLEPRE."weekly_depart WHERE department_id=".$departmentid." AND uid=".$value );
				if($status['num'] > 0){ continue; }
				
				$array_info = array(
						'department_id'=>$departmentid,
						'uid'=>$value,
						'create_time'=>date('Y-m-d H:i:s')
					);
				insert_db('weekly_depart',$array_info);
				$number++;
			}

			show_msg('部门添加成功,添加成功数为'.$number.'！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list');
		}
		else 
		{
			//取出所有的人
			$info = $db->fetch_all("SELECT a.id,b.name FROM ".DB_TABLEPRE."user a left join ".DB_TABLEPRE."user_view b on a.id=b.uid where a.id != 1");
			include_once('template/week_depart_add.php');
		}
	}
	else if($do == 'del')
	{
		$departmentid = (int)$_GET['id']; 
		$db->query( "DELETE FROM ".DB_TABLEPRE."weekly_depart WHERE id=".$departmentid);
		show_msg('部门删除成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list',4);
	}
	
















?>