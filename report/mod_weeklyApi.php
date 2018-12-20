<?php 
	//是否登陆页面
	(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
	empty($do) && $do = 'add';

	//接收数据
	$week_number = $_POST['week_number'];
	// 查询数据库是否有这周的总结信息
	$sqls = "SELECT * FROM ".DB_TABLEPRE."weekly_info WHERE weekly_type = 1 AND is_submit_info='1' AND user_id=".$_USER->id." AND week_number=$week_number AND create_start_time like '".date('Y')."%'";
	$infoWeek_fall = $db->fetch_all($sqls);

	//提交分为两种  1.是已经提交过的周报不能再提交   2.补周报的时候提示时间  3.记录周报提交的时间
	if(count($infoWeek_fall ) > 0)
	{
		//提示补交过的周报不能再提交
		echo json_encode(array('code'=>100,'message'=>'您已经提交过本次的周报，不能重复提交'));

	}
	else
	{
		if(date("W") != $week_number && date("W") != $week_number+1 )
		{
			$message ='本周为第'.date("W").'自然周,与您所提交的第'.$week_number.'周周报不相符';
			//补周报的时候提示周数不一样
			echo json_encode(array('code'=>100,'message'=>$message));

		}
		else
		{
			echo json_encode(array('code'=>200,'message'=>'周报可以提交'));
		}
	}




	

	



?>