<?php 
	
	//设置默认时区
	date_default_timezone_set('PRC');
	//是否有权限
	(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
	empty($do) && $do = 'add';

	if($do == 'list')
	{

		// $page = max(1, getGP('page','G','int'));
		// // $pagesize = 2;	
		// $pagesize = $_CONFIG->config_data('pagenum');
		// $offset = ($page - 1) * $pagesize;
		// $url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list';

		// $data = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."week_parameter  order by create_time DESC LIMIT ".$offset.",".$pagesize);

		// $nums = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."week_parameter");
		// $num = count($nums);

		// include_once('template/weekly_parameter.php');

	}
	else if($do == 'add')
	{


		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			
			$array_info = &$_POST;
			update_db('week_parameter',$array_info,array('id'=>1));
			show_msg('参数修改成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=add',1000);
		}
		else 
		{
			//取出所有的人
			$info = $db->fetch_one_array("SELECT *  FROM ".DB_TABLEPRE."week_parameter");
			// dump($info);die;
			include_once('template/weekly_parameter.php');
		}
	}
	
















?>