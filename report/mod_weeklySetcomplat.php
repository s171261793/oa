<?php 
	
	//权限编码
	(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
	empty($do) && $do = 'save';

	if($do == 'save')
	{

		//POST提交执行
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$line_complate = $_POST['line_complate'];
			if( $line_complate < 0 || $line_complate > 100 ){ show_msg('设置周报完成率合格线范围是0到100', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=save'); }
			$dataAccess = array(
							'line_complate'=>$line_complate,
							'create_time'=>date('Y-m-d H:i:s'),
								);
			update_db('weekly_complate',$dataAccess, array('id' => '1'));
				
			show_msg('设置周报完成率合格线成功', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=save',100);
		}
		else
		{
			$info =  $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_complate  WHERE id=1");
			include_once('template/access_setcomplate.php');
		}
	}
	





	?>