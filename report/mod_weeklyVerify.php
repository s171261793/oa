<?php 
	
	//ÊÇ·ñµÇÂ½Ò³Ãæ
	(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');

	empty($do) && $do = 'add';
	if($do == 'list')
	{
		/*
		*  取出当前的登录用户有没有审核的权限
		**/

		//查询部门中的人
		$result = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."weekly_flow_course WHERE  user_id=".$_USER->id);

		$result_id = array_column($result,'weekly_id');


		//循环判定在这个数组中有没有相同的用户
		$ids = implode(",",$result_id);
		if(empty( $ids ))$ids=0;
		/************************  取出自己保存的周报数据 ***************************/
		$page = max(1, getGP('page','G','int'));
		// $pagesize = 2;
		$pagesize = $_CONFIG->config_data('pagenum');
		$offset = ($page - 1) * $pagesize;
		$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list';

		$data = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."weely_score  WHERE id IN($ids) and   verify_status <= 5  ORDER BY create_time_sub DESC  LIMIT ".$offset.",".$pagesize);


		//循环是否有审核过的周报
		foreach($data as $key=>$val)
		{

				//根据个人审核优先
			$is_same_info_source_first = $db->fetch_one_array("select * from toa_weekly_access where user_id=".$val['user_id']);
				//根据部门审核的落后
			$is_same_info_source_second = $db->fetch_one_array("select * from toa_weekly_access where deparment_id=".$val['department_id']);


			if($is_same_info_source_first)
			{

				//二级审核人和一级审核人是否一样 
				if($is_same_info_source_first['one_person'] == $is_same_info_source_first['two_person'])
				{
					$final_info_same_source_data = true;  //true 一样   false  不一样
				}
				else
				{
					$final_info_same_source_data = false;  //true 一样   false  不一样
				}

			}else if($is_same_info_source_second)
			{

				//二级审核人和一级审核人是否一样 
				if($is_same_info_source_second['one_person'] == $is_same_info_source_second['two_person'])
				{
					$final_info_same_source_data = true;  //true 一样   false  不一样
				}
				else
				{
					$final_info_same_source_data = false;  //true 一样   false  不一样
				}


			}
			else{
				exlt('没有查询个人或部门审核数据，请联系管理员');
			}



			
			if( $final_info_same_source_data  )
			{
				//二级审核人一样的情况
				$info_arrays_source = $db->fetch_all("select status from toa_weekly_flow_course where weekly_id=".$val['id']." and user_id=".$_USER->id);

			
				if($info_arrays_source[0]['status'] == '1' && $info_arrays_source[1]['status'] == '1'){
					$data[$key]['is_access'] = 'show';
				}
				else
				{
					$data[$key]['is_access'] = '';
				}
				

			}
			else
			{
				//二级审核人不一样的情况
				$info_arrays_source = $db->fetch_one_array("select status from toa_weekly_flow_course where weekly_id=".$val['id']." and user_id=".$_USER->id);
				if($info_arrays_source['status'] == '1'){
					$data[$key]['is_access'] = 'show';
				}
			}
		}

		$nums = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."weely_score  WHERE id IN($ids) and   verify_status <= 5");
		$num = count($nums);

		$daya = newshowpage($num,$pagesize,$page,$url);
		include_once('template/week_verify.php');

	}
	else if( $do == 'sub')
	{
		/************************** 提交审核周报 *************************************/
		$uid = getGP('uid','P');
		//周报总结和计划的ID数组
		$idFirstAr  = $_POST['idFirstAr']; //总结信息
		$idSecondAr = $_POST['idSecondAr']; //计划信息
		$order_id_score = $_POST['scoreid'];//周报ID

		/**
		* 审核信息保存
		*/
		//之前的周报主表信息
		$total_description = $db-> fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weely_score WHERE  id=".$order_id_score);

		//总结数据更新状态（审核人填写的信息更新）
		foreach($idFirstAr as $key=>$value)
		{
			//取出本条数据原有的信息
			$info_weekly_tail = $db-> fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_info WHERE  id=".$value);

			//更新审核人总结的信息
			$info = array(
						'week_first_J'=>$_POST['week_first_J'][$key]?$_POST['week_first_J'][$key]:$info_weekly_tail['week_first_J'],
						'week_first_K'=>$_POST['week_first_K'][$key]?$_POST['week_first_K'][$key]:$info_weekly_tail['week_first_K'],
						'week_first_L'=>$_POST['week_first_L'][$key]?$_POST['week_first_L'][$key]:$info_weekly_tail['week_first_L'],
						'week_first_M'=>$_POST['week_first_M'][$key]?$_POST['week_first_M'][$key]:$info_weekly_tail['week_first_M'],
						'week_first_N'=>$_POST['week_first_N'][$key]?$_POST['week_first_N'][$key]:$info_weekly_tail['week_first_N']
						// 'weekly_status'=>'4' //更新状态4代表在下次添加周报信息的时候不显示
					);

			//更新审核人数据
			update_db('weekly_info',$info, array('id' => $idFirstAr[$key]));

		}

		//保存计划审核
		foreach($idSecondAr as $key=>$value)
		{
			//取出原来的数据
			$data = $db-> fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_info WHERE  id=".$value);

			$infoas = array(

					'week_second_I'=>!empty($_POST['week_second_I'][$key])?$_POST['week_second_I'][$key]:$data['week_second_I'],
					'week_second_J'=>!empty($_POST['week_second_J'][$key])?$_POST['week_second_J'][$key]:$data['week_second_J'],
					'week_second_K'=>!empty($_POST['week_second_K'][$key])?$_POST['week_second_K'][$key]:$data['week_second_K'],
					'week_second_L'=>!empty($_POST['week_second_L'][$key])?$_POST['week_second_L'][$key]:$data['week_second_L']
					);
				
				//更新数据
				update_db('weekly_info',$infoas, array('id' => $value));
			}

			//审核人填写周报信息
			$info_weekly_score = array(

									'opinion_one'=>!empty($_POST['opinion_one'])?$_POST['opinion_one']:$total_description['opinion_one'],
									'opinion_two'=>!empty($_POST['opinion_two'])?$_POST['opinion_two']:$total_description['opinion_two']
								);
			//更新数据
			update_db('weely_score',$info_weekly_score, array('id' => $order_id_score));
		

		//取出更新信息
		$total_description_access = $db-> fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weely_score WHERE  id=".$order_id_score);


		/*******   计算周报绩效分数（判断是否是二级审核人。是则进行绩效计算） START *********/
		/** 查询现在未审核和已经审核的多少人*/
		$info_is_level_equl = $db->fetch_all("select flow_code,user_id from toa_weekly_flow_course where weekly_id=".$order_id_score);
		$idns_person_number = count(array_column($info_is_level_equl,'user_id'));

		$info_is_level_equl = $db->fetch_one_array("select one_person,two_person from toa_weekly_access where access_code='".$info_is_level_equl[0]['flow_code']."'"); //查询规定审核是几级人
		$start_number  = 2;

		/***********  审核已经达到二级 SRAT *********/
		if(  $idns_person_number >= $start_number )
		{
			//二级审核人辅助状态（如果是二级审核人为空的话状态为1,，否则是null）
			$option_two_thumb = $total_description_access['option_two_thumb'];
			//判断每个审核人的意见来确定接下来审核的人
			$first_opinion = $total_description['opinion_one'] == '2'? $total_description['opinion_one']:$total_description_access['opinion_one'];
			$second_opinion = $total_description_access['opinion_two'];
			if($total_description['opinion_one'] == '2' && $second_opinion == '2')
			{
				$first_opinion = $total_description_access['opinion_one'];
			}

			$flow_num = $first_opinion.','.$second_opinion;

			#添加已将审核一轮
			update_db('weely_score',array('access_weekly'=>1), array('id' => $order_id_score));
			//判断当前是那个审核人操作
			if($_POST['operation'] == 'one_level')
			{
				#判断周报时通过还是修改
				if($first_opinion == '3' && $second_opinion == '1') #通过 计算绩效
				{
					#更新二级人审核模式
					$info_course = $db->fetch_all("select * from toa_weekly_flow_course where weekly_id=".$order_id_score);
					update_db('weekly_flow_course',array('status'=>'1','update_time'=>date('Y-m-d H:i:s',PHP_TIME)), array('id' => $info_course[0]['id']));
					update_db('weekly_flow_course',array('status'=>'1','update_time'=>date('Y-m-d H:i:s',PHP_TIME)), array('id' => $info_course[1]['id']));

					#更新周报主表信息显示一级审核人审核
					$data_total = array(
									'verify_status'=>'4' //1默认是一级审核人评价开关打开 2是二级审核人 4审核完毕
								  );
					update_db('weely_score',$data_total, array('id' => $order_id_score));

					#计算绩效 更新每个数据设置状态为通过设置旧的周报为计划
					countFen($order_id_score);					
					
				}
				else if( $first_opinion == '3' && $second_opinion == '2' ) #修改周报
				{
					#更新二级人审核模式
					$info_course = $db->fetch_all("select * from toa_weekly_flow_course where weekly_id=".$order_id_score);
					update_db('weekly_flow_course',array('status'=>'1','update_time'=>date('Y-m-d H:i:s',PHP_TIME)), array('id' => $info_course[0]['id']));
					update_db('weekly_flow_course',array('status'=>'1','update_time'=>date('Y-m-d H:i:s',PHP_TIME)), array('id' => $info_course[1]['id']));

					#更新周报主表信息显示一级审核人审核修改次数加1
					$data_total = array(
									'verify_status'=>'5', //1默认是一级审核人评价开关打开 2是二级审核人 4审核完毕
									// 'opinion_two'=>'', //二级审核意见为空
									// 'option_two_thumb'=>'1', //二级审核意见为空时辅助为1
								  );
					update_db('weely_score',$data_total, array('id' => $order_id_score));

					$db->query("update  toa_weely_score set edit_number=edit_number+1 where id=".$order_id_score);
				}
				else if(($first_opinion == '4') || ($first_opinion == '2' && $second_opinion == '1' ) ) #直接修改周报不用第二级人审核
				{
					#更新二级人审核模式
					$info_course = $db->fetch_all("select * from toa_weekly_flow_course where weekly_id=".$order_id_score);
					update_db('weekly_flow_course',array('status'=>'1','update_time'=>date('Y-m-d H:i:s',PHP_TIME)), array('id' => $info_course[0]['id']));
					update_db('weekly_flow_course',array('status'=>'1','update_time'=>date('Y-m-d H:i:s',PHP_TIME)), array('id' => $info_course[1]['id']));

					#更新周报主表信息显示一级审核人审核
					$data_total = array(
									'verify_status'=>'5', //1默认是一级审核人评价开关打开 2是二级审核人 4审核完毕
								  	// 'opinion_two'=>''
								  	// 'option_two_thumb'=>'1',//二级审核意见为空时辅助为1
								  );
					update_db('weely_score',$data_total, array('id' => $order_id_score));
					$db->query("update  toa_weely_score set edit_number=edit_number+1 where id=".$order_id_score);
				}
				else
				{
					#更新二级人审核模式
					$info_course = $db->fetch_all("select * from toa_weekly_flow_course where weekly_id=".$order_id_score);
					update_db('weekly_flow_course',array('status'=>'1','update_time'=>date('Y-m-d H:i:s',PHP_TIME)), array('id' => $info_course[0]['id']));
					update_db('weekly_flow_course',array('status'=>'0','update_time'=>date('Y-m-d H:i:s',PHP_TIME)), array('id' => $info_course[1]['id']));

					#更新周报主表信息显示一级审核人审核
					$data_total = array(
									'verify_status'=>'2' //1默认是一级审核人评价开关打开 2是二级审核人
								  );
					update_db('weely_score',$data_total, array('id' => $order_id_score));
				}
					
			}
			else if( $_POST['operation'] == 'two_level' )
			{
				#更新一级人审核模式
				$info_course = $db->fetch_all("select * from toa_weekly_flow_course where weekly_id=".$order_id_score);
				update_db('weekly_flow_course',array('status'=>'0','update_time'=>date('Y-m-d H:i:s',PHP_TIME)), array('id' => $info_course[0]['id']));
				update_db('weekly_flow_course',array('status'=>'1','update_time'=>date('Y-m-d H:i:s',PHP_TIME)), array('id' => $info_course[1]['id']));

				#更新周报主表信息显示一级审核人审核
				$data_total = array(
								'verify_status'=>'1' //1默认是一级审核人评价开关打开 2是二级审核人

							  );
				update_db('weely_score',$data_total, array('id' => $order_id_score));
			}

			
		/***********  审核已经达到二级 END *********/
		}
		else
		{
			/***********  审核没有达到二级则继续添加审核节点 SRAT *********/
					
			//准备下一级审核
			$data_total = array(
						'verify_status'=>$total_description['verify_status']+1, //增加1是准备下一级人审核
					);
			update_db('weely_score',$data_total, array('id' => $order_id_score));

			//当前审核表更新
			$infog = $db->fetch_one_array("select * from toa_weekly_flow_course where weekly_id=".$order_id_score." and user_id=".$_USER->id);
		
			$array_info_only_score = array(
										'status'=>'1', //1代表审核后完毕
										'update_time'=>date('Y-m-d H:i:s',PHP_TIME)
									);
			update_db('weekly_flow_course',$array_info_only_score,array('weekly_id'=>$order_id_score,'user_id'=>$_USER->id));

			$access_person_now_number = $total_description['verify_status']+1;
			// 判定下一个环节的审核人是谁
			switch ($access_person_now_number) {
				case '1':
					$user_ids = empty($info_is_level_equl['one_person'])?'0':$info_is_level_equl['one_person'];
					break;
				case '2':
					$user_ids = empty($info_is_level_equl['two_person'])?'0':$info_is_level_equl['two_person'];
					break;
							
				default:
					$user_ids = '0';
					break;
			}
		
			//审核表添加下级审核人 当审核人数没有达到自定义的审核人数，继续添加审核节点
			$array_info_only_score = array(

					'status'=>'0',
					'flow_code'=>$infog['flow_code'],
					'weekly_id'=>$order_id_score,
					'user_id'=>$user_ids,
					'create_time'=>date('Y-m-d H:i:s',PHP_TIME)

			);
			insert_db('weekly_flow_course',$array_info_only_score );
			
			/***********  审核没有达到二级则继续添加审核节点 END *********/
		}

		show_msg('审核成功', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list',200);


	}
	else if(  $do == 'view' )
	{
		if($_GET['access'] == 'yes'){ $is_hidden = 'string';}

		$numk = $_GET['weeknum'];
		$orderid = $_GET['id'];
			//根据传递进来的参数来找出对应的周报

			//新版周报总结
			$infoWeek_fall = $db->fetch_all(" SELECT * FROM toa_weekly_info WHERE FIND_IN_SET(id, (select  CONCAT(',',summary_id,',') from toa_weekly_listtable_type where weekly_id = $orderid)   ) ");

			//新版周报计划
			$infoWeek_plan_fall = $db->fetch_all(" SELECT * FROM toa_weekly_info WHERE FIND_IN_SET(id, (select  CONCAT(',',plan_id,',') from toa_weekly_listtable_type where weekly_id = $orderid)   ) ");


			//如果没有新版数据默认显示旧版数据
			if( empty($infoWeek_fall) && empty($infoWeek_plan_fall) )
			{
				// 周报总结(不显示周报的)
				$infoWeek_fall = $db->fetch_all(" SELECT * FROM toa_weekly_info WHERE FIND_IN_SET(id, (select  GROUP_CONCAT(ids_weekly) from toa_weely_score where id = $orderid)) and (weekly_type=1 or is_show_to_plan='1') ");

				//周报计划
				$infoWeek_plan_fall = $db->fetch_all(" SELECT * FROM toa_weekly_info WHERE FIND_IN_SET(id, (select  GROUP_CONCAT(ids_weekly) from toa_weely_score where id = $orderid)) and (weekly_type=2  or   is_show_to_plan='1')");
			}




			//设置参数
			$resultWeekInfo = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."week_parameter");

			//取出这次周报的主要信息（判断这次的信息是否确认，确认后不能修改）
			$infoWeek_order = $db->fetch_one_array("select * from toa_weely_score where id=$orderid");

			//汇报人姓名 
			$name = $db->fetch_one_array("select b.name from toa_user a left join toa_user_view b on a.id=b.uid where a.id=".$infoWeek_order['user_id'])['name'];

			//取出当前周报第几级审核人
			$key_level = $infoWeek_order['verify_status'];

			//是否已经确认周报
			$status_is_confirm = $infoWeek_order['is_confirm'];
		
			//0代表第一审核人 1第二审核人  2第三审核人

			//显示部门信息
			$user_id = $infoWeek_order['user_id'];
			$departmentid_on = $db->fetch_all("select a.*,b.name from ".DB_TABLEPRE."weekly_depart a ,".DB_TABLEPRE."department b where a.department_id = b.id and a.uid=".$user_id);

			//显示本周报的所属的部门
			$department_name_specil = $db->fetch_one_array("select id,name from ".DB_TABLEPRE."department  where id=".$infoWeek_order['department_id']);

			//当前取出的周报所属人
			$personForWeeklyUserid = $resultComment[0]['user_id'];
			//周报所属人的部门
			//显示本周周末时间
			$nowTimeWeeknumber = date('w',PHP_TIME);   	//0（表示星期天）到 6（表示星期六）
			// $nowTimeWeeknumber = 0;   	//0（表示星期天）到 6（表示星期六）
			
			if($nowTimeWeeknumber == 0 || $nowTimeWeeknumber == 6)
			{
					$day = $nowTimeWeeknumber == 0 ?2:1;

					$stamp = strtotime("-".$day."days",time());
			}
			else
			{
					$day = 5-$nowTimeWeeknumber;
					$stamp = strtotime("+ ".$day."days",time());
			}
			$time = date('Y-m-d',$stamp);


			$access_person = 0;
			//当前人是第几级审核人
			$info_first_access_operation =  $db->fetch_one_array("select *from ".DB_TABLEPRE."weekly_access  where one_person=".$_USER->id." and user_id=".$infoWeek_order['user_id']);
			$info_second_access_operation =  $db->fetch_one_array("select *from ".DB_TABLEPRE."weekly_access  where two_person=".$_USER->id." and user_id=".$infoWeek_order['user_id']);

			//如果不是设置的单人审核的话取出组中设置、

			if(!$info_first_access_operation && !$info_second_access_operation)
			{

				$info_first_access_operation =  $db->fetch_one_array("select *from ".DB_TABLEPRE."weekly_access  where one_person=".$_USER->id." and deparment_id=".$infoWeek_order['department_id']);
				$info_second_access_operation =  $db->fetch_one_array("select *from ".DB_TABLEPRE."weekly_access  where two_person=".$_USER->id." and deparment_id=".$infoWeek_order['department_id']);
			}

			if($info_first_access_operation)
			{     
				$access_person  = 1;
			}
			else if( $info_second_access_operation )
			{

			 	$access_person = 2;
			}

			//如果是一个人占用两个审核位置，则进行如下操作
			//二级审核人一样的情况
			$info_arrays_source = $db->fetch_all("select * from toa_weekly_flow_course where weekly_id=".$infoWeek_order['id']." and user_id=".$_USER->id.' order by id ASC');
			if(count($info_arrays_source) >1)
			{

				if($info_arrays_source[0]['user_id'] ==  $info_arrays_source[1]['user_id'])
				{

						if( $info_arrays_source[0] && $info_arrays_source[0]['status'] == '0')
						{
							$access_person  = 1;
						}
						else if( $info_arrays_source[1] && $info_arrays_source[1]['status'] == '0')
						{
							$access_person  = 2;
						}

					
				}
			}


			//输入上限
			$resultCeil = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_ceil");
	
			include_once('template/week_view_verify.php');

	}



	
	function countFen($idorder)
	{
		global $db;
		//取出更新信息
		$total_weekly_info = $db-> fetch_one_array("SELECT ids_weekly,id FROM ".DB_TABLEPRE."weely_score WHERE  id=".$idorder);

		//更新旧的周报为单方显示
		// $info_edit = $db-> fetch_all("SELECT * FROM ".DB_TABLEPRE."weekly_info WHERE  id IN(".$total_weekly_info['ids_weekly'].")  AND is_show_to_plan = '1'");
		
		$info_edit = $db-> fetch_one_array("SELECT plan_id FROM ".DB_TABLEPRE."weekly_listtable_type WHERE  weekly_id = ".$total_weekly_info['id']);
		
		// foreach($info_edit as $key=>$value)
		// {
		// 	update_db('weekly_info',array('weekly_type'=>'1','is_show_to_plan'=>'2'), array('id' => $value['id']));
		// }

		$info_edit_fain  =  explode(',',$info_edit['plan_id']);
		//解锁可以显示到下周的周报中、、问题是新添加的数据没有更新状态
		if(!empty($info_edit_fain))
		{
			foreach($info_edit_fain as $value)
			{
				update_db('weekly_info',array('weekly_lock'=>'0'), array('id' => $value));
			}
			
		}
		

		$info = $db-> fetch_all("SELECT * FROM ".DB_TABLEPRE."weekly_info WHERE  id IN(".$total_weekly_info['ids_weekly'].")  AND (weekly_is_new = '0' or  weekly_is_new = '1')");

		//取出周总结占比weekly_float
		$float_total_array = $db-> fetch_all("SELECT * FROM ".DB_TABLEPRE."weekly_float");

		//取出周计划占比
		$icem = 0;
		foreach($info as $key=>$val)
		{

			//根据条件算出那些条件可以计入绩效(计算的是周总结的数据)
			if($val['week_second_L'] && $val['weekly_is_new'] <= 1)
			{
				//计划占比CTO
				$float_plan_count = $val['week_second_L'] * $float_total_array[1]['section_c'];

				//每条任务的绩效   O1=(a* J1+b* L1+c* N1)*s1
				$array_count = ( $val['week_first_I'] * $float_total_array[0]['section_a'] + $val['week_first_K'] * $float_total_array[0]['section_b'] + $val['week_first_M'] * $float_total_array[0]['section_c']) * $float_plan_count;
				
				#得分更新到每条数据
				update_db('weekly_info',array('week_first_N'=>$array_count), array('id' => $val['id']));
				$icem += $array_count;
			}
		}	

		#得分更新主表数据
		update_db('weely_score',array('score'=>$icem), array('id' => $idorder));

	}
	   
	

?>