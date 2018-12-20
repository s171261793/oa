<?php 
	
	//权限编码
	(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
	empty($do) && $do = 'save';

	if($do == 'save')
	{

		//POST提交执行
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{

			//权重占比周和计划
			foreach($_POST['section_a'] as $key=>$val)
			{
				$week_data = array(
								'section_a'=>$val,
								'section_b'=>$_POST['section_b'][$key],
								'section_c'=>$_POST['section_c'][$key],
								'type'=>$key == 0?'1':'2',
								'create_time'=>date('Y-m-d H:i:s',PHP_TIME),
							);
				update_db('weekly_float',$week_data, array('id' => $key+1));
			}

			//最大值限制
			$week_ceil = array(
								'max_a'=>$_POST['max_a'],
								'section_e'=>$_POST['section_e'],
								'section_f'=>$_POST['section_f'],
								'create_time'=>date('Y-m-d H:i:s',PHP_TIME),
							);
				update_db('weekly_ceil',$week_ceil, array('id' =>1));
			//完成率设置更新
			$line_complate = $_POST['line_complate'];
			if( $line_complate < 0 || $line_complate > 100 ){ show_msg('设置周报完成率合格线范围是0到100', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=save'); }
			$dataAccess = array(
							'line_complate'=>$line_complate,
							'create_time'=>date('Y-m-d H:i:s'),
								);
			update_db('weekly_complate',$dataAccess, array('id' => '1'));
			
			show_msg('设置周报默认值成功', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=save',1000);
		}
		else
		{
			//周总结打分权重
			$week_data = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_float WHERE type='1' ");

			//周计划打分权重
			$week_data_plan = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_float WHERE type='2' ");
			
			//周总结上限值/月考核重要性占比/季度考核重要性占比
			$weekCeilAndcompare = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_ceil");


			//完成率设置
			$info =  $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_complate  WHERE id=1");

			include_once('template/default_value_set.php');
		}
	}
	





	?>