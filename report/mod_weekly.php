<?php 
	
	//设置默认时区
	date_default_timezone_set('PRC');
	//ÊÇ·ñµÇÂ½Ò³Ãæ
	(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
	empty($do) && $do = 'add';
	if($do == 'list')
	{
		/************************  取出自己保存的周报数据 ***************************/
		$page = max(1, getGP('page','G','int'));
		// $pagesize = 2;	
		$pagesize = $_CONFIG->config_data('pagenum');
		$offset = ($page - 1) * $pagesize;
		$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list';

		$data = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."weely_score  WHERE user_id = $_USER->id  order by id DESC LIMIT ".$offset.",".$pagesize);

		$nums = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."weely_score  WHERE user_id = $_USER->id  GROUP BY weekly_number");
		$num = count($nums);

		include_once('template/week_list.php');

	}
	else if($do == 'add') //Ìí¼ÓÒ³Ãæ
	{

		//寻找当前用户部门
		if ($result = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."user a,".DB_TABLEPRE."user_view b WHERE a.id=b.uid and a.id = '$_USER->id' "))
		{
			//接收部门信息
			$depid = $_GET['depid'];
			
			//部门名称
			if($depid)
			$depName = $db->fetch_one_array("select * from ".DB_TABLEPRE."department   where id=".$depid);
			//显示部门信息
			$user_id = $_USER->id;
			$departmentid_on = $db->fetch_all("select a.*,b.name from ".DB_TABLEPRE."weekly_depart a ,".DB_TABLEPRE."department b where a.department_id = b.id and a.uid=".$user_id);
			$depids = !empty($depid)?$depid:$departmentid_on[0]['department_id'];

			//判断是否有部门 
			if( empty($depids) )
			{
				show_msg('此用户未分配部门,请联系管理员分配周报部门!', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list');die;
			}

			//查询表显示未通过审核的总结
			$infoWeek_fall = $db->fetch_all(" SELECT * FROM toa_weekly_info WHERE  FIND_IN_SET(id, (select  GROUP_CONCAT(ids_weekly) from toa_weely_score where user_id=$_USER->id and is_submit ='1' and verify_status=4 and department_id= $depids)) and (weekly_type=2 or (is_show_to_plan=1) ) and weekly_lock='0'");

			// dump( " SELECT * FROM toa_weekly_info WHERE  FIND_IN_SET(id, (select  GROUP_CONCAT(ids_weekly) from toa_weely_score where user_id=$_USER->id and is_submit ='1' and verify_status=4 and department_id= $depids)) and (weekly_type=2 or (is_show_to_plan=1) ) and (weekly_lock='0' or weekly_lock='1')" );die;

			//查询表显示未通过审核的计划
			$infoWeek_plan_fall = $db->fetch_all(" SELECT * FROM toa_weekly_info WHERE  FIND_IN_SET(id, (select  GROUP_CONCAT(ids_weekly) from toa_weely_score where user_id=$_USER->id and is_submit ='1' and department_id= $depids)) and (weekly_type=2 and weekly_status=3)");
			
			//现在星期几
			$nowTimeWeeknumber = date('w',PHP_TIME);   	//0（表示星期天）到 6（表示星期六）
			
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
			//周五时间
			$time = date('Y-m-d',$stamp);

			//每周的星期一的时间
			$monday = date('Y-m-d',strtotime("- 4days",strtotime($time)));


			//默认下周计划时间
			$monday_next = date('Y-m-d',strtotime("+ 7days",strtotime($monday)));
			$friday_next = date('Y-m-d',strtotime("+ 7days",strtotime($time)));

			//后台显示数据
			$resultWeekInfo = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."week_parameter");

			//输入上限
			$resultCeil = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_ceil");
			
			include_once('template/week_add.php');
		} else {
			prompt('没有周报信息');
		}

	}
	else if( $do == 'confirm') //确认周报的时候要保存已经填写的信息（包括计划和总结）
	{
		$uid = $_USER->id;
		$week_number = $_POST['week_number'];
		$week_number_plan = $_POST['week_number_plan'];

		$orderis_ff = $_POST['orderid'];


		//判断数据库是否有这样的数据(根据部门查询)
		$sqls = "SELECT * FROM ".DB_TABLEPRE."weely_score WHERE  user_id=".$_USER->id." AND weekly_number=$week_number AND  department_id=$_POST[departmentida]  AND  weekly_number_plan = $week_number_plan AND create_time_start like '".date('Y')."%'";

		$infoWeek_fall = $db->fetch_all($sqls);

		$operationType = $_POST['operationType'];
		if($operationType=='weeklyadd' && count($infoWeek_fall ) > 0)
		{
			show_msg('你本周提交的周报已经存在,请勿重复确认!', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');die;
		}


		//后台设置完成百分比
		$complateNumber = $db-> fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_complate WHERE id=1");
		//获取手动填写的时间
		$weekly_first_start = $_POST['weekly_first_start']; //提交总结选择时间
		$weekly_first_end = $_POST['weekly_first_end'];     //提交总结结束时间

		$weekly_second_start = $_POST['weekly_second_start']; //计划汇报选择时间
		$weekly_second_end = $_POST['weekly_second_end'];     //计划汇报结束时间


		$week_first_A = $_POST['week_first_A'];
		$week_first_B = $_POST['week_first_B'];
		$week_first_C = $_POST['week_first_C'];
		$week_first_D = $_POST['week_first_D'];
		$week_first_E = $_POST['week_first_E'];
		$week_first_F = $_POST['week_first_F'];
		$week_first_G = $_POST['week_first_G'];

		$week_first_H = $_POST['week_first_H'];
		$week_first_I = $_POST['week_first_I'];

		$week_second_A = $_POST['week_second_A'];
		$week_second_B = $_POST['week_second_B'];
		$week_second_C = $_POST['week_second_C'];
		$week_second_D = $_POST['week_second_D'];
		$week_second_E = $_POST['week_second_E'];
		$week_second_F = $_POST['week_second_F'];
		$week_second_G = $_POST['week_second_G'];
		$week_second_G_is = $_POST['week_second_G_is'];
		$week_second_H = $_POST['week_second_H'];
		

		$ids =array();
		$ids_summary =array();
		$ids_plan = array();

		/*************     总结汇报   *************/
		foreach($week_first_A as $key=>$value)
		{

			$infoArray =array(

					'week_number'=>$week_number,
					'week_number_plan'=>$week_number_plan,
					'week_first_F'=>$week_first_F[$key],
					'week_first_G'=>$week_first_G[$key],
					'week_first_H'=>$week_first_H[$key],
					'week_first_I'=>$week_first_I[$key],

					'week_second_A'=>$value,
					'week_second_B'=>$week_first_B[$key],
					'week_second_C'=>$week_first_C[$key],
					'week_second_D'=>$week_first_D[$key],
					'week_second_E'=>$week_first_E[$key],	

					'create_start_time'=>date("Y-m-d H:i:s"),
					'weekly_first_start'=>$weekly_first_start,
					'weekly_first_end'=>$weekly_first_end,
					'weekly_status'=>'1',
					'weekly_lock'=>'1',
					'weekly_type'=>'1'

			);


			//判断数据库是否之前有数据有的话更新没有插入数据
			if(!$_POST['idFirstAr'][$key]){ $_POST['idFirstAr'][$key] = 0; }
			$is_operation = isExcistData('weekly_info','id',$_POST['idFirstAr'][$key]);
			//判断是否是总结未完成变成计划
			if($_POST['week_first_G'][$key] < $complateNumber['line_complate'])
			{   
				$infoArray['is_show_to_plan'] = '1'; 
				$infoArray['weekly_is_new'] = $is_operation['weekly_is_new'] + 1; 
			}
			else
			{
				$infoArray['is_show_to_plan'] = '2'; 
				$infoArray['weekly_status'] = '4'; //改变此总结状态 （通过总结时直接改变在下次添加周报时不能被发现）
			}
			
			if($is_operation){

				array_push($ids,$_POST['idFirstAr'][$key]);
				array_push($ids_summary,$_POST['idFirstAr'][$key]);
				unset($infoArray['create_start_time']);

				//如果不是本周的周报任务不能修改成本周的信息
				$infoArray['weekly_type'] = !empty($is_operation['weekly_type'])?$is_operation['weekly_type']:'1';
				$infoArray['week_number'] = !empty($is_operation['week_number'])?$is_operation['week_number']:$week_number;
				$infoArray['week_number_plan'] = !empty($is_operation['week_number_plan'])?$is_operation['week_number_plan']:$week_number_plan;
				$infoArray['create_start_time'] = !empty($is_operation['create_start_time'])?$is_operation['create_start_time']:date("Y-m-d H:i:s",PHP_TIME);
				$infoArray['weekly_first_start'] = !empty($is_operation['weekly_first_start'])?$is_operation['weekly_first_start']:$weekly_first_start;
				$infoArray['weekly_first_end'] = !empty($is_operation['weekly_first_end'])?$is_operation['weekly_first_end']:$weekly_first_end;

				update_db('weekly_info',$infoArray, array('id' => $_POST['idFirstAr'][$key]));
			}else{

				$id_only = insert_db('weekly_info',$infoArray);
				array_push($ids,$id_only);
				array_push($ids_summary,$id_only);
			}

			//如果是旧任务的话加入计划中
			if( $_POST['week_first_G'][$key] < $complateNumber['line_complate'])
			{
				$id_list_only =  $_POST['idFirstAr'][$key]?$_POST['idFirstAr'][$key]:$id_only;
				array_push($ids_plan,$id_list_only);
			}

	
		}


		/***     计划汇总   ***/
		foreach($week_second_A as $key=>$value)
		{
			$infoArrays =array(

					'week_number'=>$week_number,
					'week_number_plan'=>$week_number_plan,
			
					'week_second_A'=>$week_second_A[$key],
					'week_second_B'=>$week_second_B[$key],
					'week_second_C'=>$week_second_C[$key],
					'week_second_D'=>$week_second_D[$key],
					'week_second_E'=>$week_second_E[$key],
					'week_second_F'=>$week_second_F[$key],
					'week_second_G'=>$week_second_G[$key],
					'week_second_G_is'=>empty($week_second_G[$key])?'0':'1',
					
					'week_second_H'=>$week_second_H[$key],

					'create_start_time'=>date("Y-m-d H:i:s"),
					
					'weekly_second_start'=>$weekly_second_start,
					'weekly_second_end'=>$weekly_second_end,
					'weekly_type'=>'2',  //2´ú±í¼Æ»®»ã±¨
					'weekly_lock'=>'1',
					'weekly_status'=>'1' //确认之后的信息代表是提交状态（为了在添加周报的时候不显示信息）
				);

			//查询数据库中是否有本数据
			if(!$_POST['idSecondAr'][$key]){ $_POST['idSecondAr'][$key] = 0; }
			$is_operations = isExcistData('weekly_info','id',$_POST['idSecondAr'][$key]);

			if($is_operations){
				array_push($ids,$_POST['idSecondAr'][$key]);
				array_push($ids_plan,$_POST['idSecondAr'][$key]);
				unset($infoArrays['create_start_time']);

				//如果不是本周的周报任务不能修改成本周的信息
				$infoArrays['weekly_type'] = !empty($is_operations['weekly_type'])?$is_operations['weekly_type']:'2';
				$infoArrays['week_number'] = !empty($is_operations['week_number'])?$is_operations['week_number']:$week_number;
				$infoArrays['week_number_plan'] = !empty($is_operations['week_number_plan'])?$is_operations['week_number_plan']:$week_number_plan;
				$infoArrays['create_start_time'] = !empty($is_operations['create_start_time'])?$is_operations['create_start_time']:date("Y-m-d H:i:s",PHP_TIME);
				$infoArrays['weekly_second_start'] = !empty($is_operations['weekly_second_start'])?$is_operations['weekly_second_start']:$weekly_second_start;
				$infoArrays['weekly_second_end'] = !empty($is_operations['weekly_second_end'])?$is_operations['weekly_second_end']:$weekly_second_end;
				update_db('weekly_info',$infoArrays, array('id' => $_POST['idSecondAr'][$key]));

			}else{

				$id_only_s = insert_db('weekly_info',$infoArrays);
				array_push($ids,$id_only_s);
				array_push($ids_plan,$id_only_s);
		
			}



		}


		//周报主表中是否有数据
		$total_description = $db-> fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weely_score WHERE  weekly_number_plan = ".$week_number_plan." AND weekly_number=".$week_number." AND user_id=".$uid);
		$data_total = array(

					'weekly_number'=>$week_number,
					'weekly_number_plan'=>$week_number_plan,

					'create_time_start'=>$weekly_first_start,
					'create_time_end'=>$weekly_first_end,

					'create_time_start_plan'=>$weekly_second_start,
					'create_time_end_plan'=>$weekly_second_end,

					'description'=>$_POST['description'],
					'desciption_new'=>$_POST['desciption_new'],
					'description_plan'=>$_POST['description_plan'],
					'is_poor_planing'=>$_POST['is_poor_planing'],
					'user_id'=>$uid,  //1´ú±í×Ü½á
					'is_confirm'=>'1',  //1代表确认	
					'create_time_early'=>date('Y-m-d H:i:s'),
					'ids_weekly'=>implode(",",$ids),  //0´ú±íÎ´Ìá½»
					'department_id'=>$_POST['departmentida']  //0´ú±íÎ´Ìá½»

				);

			$idsd = '';
			if($total_description)
			{
				unset($data_total['create_time_early']);
				update_db('weely_score',$data_total, array('id' => $total_description['id']));
			}
			else
			{
				$idsd = insert_db('weely_score',$data_total);
			}

			$orderid = $total_description['id']?$total_description['id']:$idsd;

			//加入周报显示分类表
			$is_list = isExcistData('weekly_listtable_type','weekly_id',$orderid);

			if($is_list)
			{
				$iid = update_db('weekly_listtable_type',array('summary_id'=>implode(',', $ids_summary),'plan_id'=>implode(',', $ids_plan)), array('weekly_id' => $orderid));

			}
			else
			{
				insert_db('weekly_listtable_type',array('summary_id'=>implode(',', $ids_summary),'plan_id'=>implode(',', $ids_plan),'weekly_id'=>$orderid));
			}



			show_msg('总结确认成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=view&orderid='.$orderid,1000);  //周报确认后在本页面不嫩跳转到菜单页面

	}
	else if( $do == 'save' )
	{
		$uid = getGP('uid','P');
		$week_number = $_POST['week_number'];
		$week_number_plan = $_POST['week_number_plan'];

		//判断数据库是否有这样的数据(根据部门查询)
		// $sqls = "SELECT * FROM ".DB_TABLEPRE."weely_score WHERE  user_id=".$_USER->id." AND weekly_number=$week_number AND  department_id=$_POST[departmentida]  AND  weekly_number_plan = $week_number_plan AND create_time_start like '".date('Y')."%'";
		$sqls = "SELECT * FROM ".DB_TABLEPRE."weely_score WHERE  user_id=".$_USER->id." AND weekly_number=$week_number AND  department_id=$_POST[departmentida]  AND  create_time_start like '".date('Y')."%'";

		$infoWeek_fall = $db->fetch_all($sqls);

		$operationType = $_POST['operationType'];
		if($operationType=='weeklyadd' && count($infoWeek_fall ) > 0)
		{
			show_msg('你本周提交的周报已经存在,请勿重复保存!', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');die;
			
		}


		//获取手动填写的时间
		$weekly_first_start = $_POST['weekly_first_start']; //提交总结选择时间
		$weekly_first_end = $_POST['weekly_first_end'];     //提交总结结束时间

		$weekly_second_start = $_POST['weekly_second_start']; //计划汇报选择时间
		$weekly_second_end = $_POST['weekly_second_end'];     //计划汇报结束时间


		$week_first_A = $_POST['week_first_A'];
		$week_first_B = $_POST['week_first_B'];
		$week_first_C = $_POST['week_first_C'];
		$week_first_D = $_POST['week_first_D'];
		$week_first_E = $_POST['week_first_E'];
		$week_first_F = $_POST['week_first_F'];
		$week_first_G = $_POST['week_first_G'];

		$week_first_H = $_POST['week_first_H'];
		$week_first_I = $_POST['week_first_I'];

		$week_second_A = $_POST['week_second_A'];
		$week_second_B = $_POST['week_second_B'];
		$week_second_C = $_POST['week_second_C'];
		$week_second_D = $_POST['week_second_D'];
		$week_second_E = $_POST['week_second_E'];
		$week_second_F = $_POST['week_second_F'];
		$week_second_G = $_POST['week_second_G'];
		$week_second_G_is = $_POST['week_second_G_is'];
		$week_second_H = $_POST['week_second_H'];


		$ids =array();
		$ids_summary =array();
		/*************     总结汇报   *************/
		foreach($week_first_A as $key=>$value)
		{
			

			$infoArray =array(

					'week_number'=>$week_number,
					'week_number_plan'=>$week_number_plan,
					'week_first_F'=>$week_first_F[$key],
					'week_first_G'=>$week_first_G[$key],
					'week_first_H'=>$week_first_H[$key],
					'week_first_I'=>$week_first_I[$key],

					'week_second_A'=>$value,
					'week_second_B'=>$week_first_B[$key],
					'week_second_C'=>$week_first_C[$key],
					'week_second_D'=>$week_first_D[$key],
					'week_second_E'=>$week_first_E[$key],
					
					'create_start_time'=>date("Y-m-d H:i:s",PHP_TIME),
					'weekly_first_start'=>$weekly_first_start,
					'weekly_first_end'=>$weekly_first_end,
					'weekly_status'=>'1',
					'weekly_lock'=>'1',
					'weekly_type'=>'1' //如果是旧任务有数据请把旧任务类型放上去

				);


			//判断数据库是否之前有数据有的话更新没有插入数据
			if(!$_POST['idFirstAr'][$key]){ $_POST['idFirstAr'][$key] = 0; }
			$is_operation = isExcistData('weekly_info','id',$_POST['idFirstAr'][$key]);
			
			if($is_operation){

				array_push($ids,$_POST['idFirstAr'][$key]);
				array_push($ids_summary,$_POST['idFirstAr'][$key]);
				unset($infoArray['create_start_time']);

				//如果不是本周的周报任务不能修改成本周的信息
				// $infoArray['weekly_type'] = !empty($is_operation['weekly_type'])?$is_operation['weekly_type']:'1';
				$infoArray['week_number'] = !empty($is_operation['week_number'])?$is_operation['week_number']:$week_number;
				$infoArray['week_number_plan'] = !empty($is_operation['week_number_plan'])?$is_operation['week_number_plan']:$week_number_plan;
				$infoArray['create_start_time'] = !empty($is_operation['create_start_time'])?$is_operation['create_start_time']:date("Y-m-d H:i:s",PHP_TIME);
				$infoArray['weekly_first_start'] = !empty($is_operation['weekly_first_start'])?$is_operation['weekly_first_start']:$weekly_first_start;
				$infoArray['weekly_first_end'] = !empty($is_operation['weekly_first_end'])?$is_operation['weekly_first_end']:$weekly_first_end;

				update_db('weekly_info',$infoArray, array('id' => $_POST['idFirstAr'][$key]));
			}else{

				$id_only = insert_db('weekly_info',$infoArray);
				array_push($ids,$id_only);
				array_push($ids_summary,$id_only);
			}

		}




		$ids_plan =array();
		/***     计划汇总   ***/
		foreach($week_second_A as $key=>$value)
		{
			$infoArrays =array(

					'week_number'=>$week_number,
					'week_number_plan'=>$week_number_plan,
			
					'week_second_A'=>$week_second_A[$key],
					'week_second_B'=>$week_second_B[$key],
					'week_second_C'=>$week_second_C[$key],
					'week_second_D'=>$week_second_D[$key],
					'week_second_E'=>$week_second_E[$key],
					'week_second_F'=>$week_second_F[$key],
					'week_second_G'=>$week_second_G[$key],
					'week_second_G_is'=>empty($week_second_G[$key])?'0':'1',
					'week_second_H'=>$week_second_H[$key],

					'create_start_time'=>date("Y-m-d H:i:s",PHP_TIME),
					
					'weekly_second_start'=>$weekly_second_start,
					'weekly_second_end'=>$weekly_second_end,
					'weekly_status'=>'1',
					'weekly_lock'=>'1',
					'weekly_type'=>'2'  //2´ú±í¼Æ»®»ã±¨

				);


			//查询数据库中是否有本数据
			if(!$_POST['idSecondAr'][$key]){ $_POST['idSecondAr'][$key] = 0; }
			$is_operations = isExcistData('weekly_info','id',$_POST['idSecondAr'][$key]);

			if($is_operations){
				array_push($ids,$_POST['idSecondAr'][$key]);
				array_push($ids_plan,$_POST['idSecondAr'][$key]);
				unset($infoArrays['create_start_time']); 
				//如果不是本周的周报任务不能修改成本周的信息
				// $infoArrays['weekly_type'] = !empty($is_operations['weekly_type'])?$is_operations['weekly_type']:'2';
				$infoArrays['week_number'] = !empty($is_operations['week_number'])?$is_operations['week_number']:$week_number;
				$infoArrays['week_number_plan'] = !empty($is_operations['week_number_plan'])?$is_operations['week_number_plan']:$week_number_plan;
				$infoArrays['create_start_time'] = !empty($is_operations['create_start_time'])?$is_operations['create_start_time']:date("Y-m-d H:i:s",PHP_TIME);
				$infoArrays['weekly_second_start'] = !empty($is_operations['weekly_second_start'])?$is_operations['weekly_second_start']:$weekly_second_start;
				$infoArrays['weekly_second_end'] = !empty($is_operations['weekly_second_end'])?$is_operations['weekly_second_end']:$weekly_second_end;

				update_db('weekly_info',$infoArrays, array('id' => $_POST['idSecondAr'][$key]));

			}else{

				$id_only_s = insert_db('weekly_info',$infoArrays);
				array_push($ids,$id_only_s);
				array_push($ids_plan,$id_only_s);
		
			}



		}


		//周报主表中是否有数据
		$total_description = $db-> fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weely_score WHERE  weekly_number_plan = ".$week_number_plan." AND weekly_number=".$week_number." AND user_id=".$uid);

		$data_total = array(

					'weekly_number'=>$week_number,
					'weekly_number_plan'=>$week_number_plan,

					'create_time_start'=>$weekly_first_start,
					'create_time_end'=>$weekly_first_end,

					'create_time_start_plan'=>$weekly_second_start,
					'create_time_end_plan'=>$weekly_second_end,

					'description'=>$_POST['description'],
					'desciption_new'=>$_POST['desciption_new'],
					'description_plan'=>$_POST['description_plan'],
					'is_poor_planing'=>$_POST['is_poor_planing'],
					'user_id'=>$uid, 
					'create_time_early'=>date('Y-m-d H:i:s'),
					'ids_weekly'=>implode(",",$ids),  

					'department_id'=>$_POST['departmentida'] 

			);

			if($total_description)
			{
				unset($data_total['create_time_early']);
				update_db('weely_score',$data_total, array('id' => $total_description['id']));
			}
			else
			{
				$id_only_list = insert_db('weely_score',$data_total);
			}

			//加入周报显示分类表
			$order_id_list = $total_description['id']?$total_description['id']:$id_only_list;
			$is_list = isExcistData('weekly_listtable_type','weekly_id',$order_id_list);

			if($is_list)
			{
				update_db('weekly_listtable_type',array('summary_id'=>implode(',', $ids_summary),'plan_id'=>implode(',', $ids_plan)), array('weekly_id' => $order_id_list));
			}
			else
			{
				insert_db('weekly_listtable_type',array('summary_id'=>implode(',', $ids_summary),'plan_id'=>implode(',', $ids_plan),'weekly_id'=>$order_id_list));
			}


		//判断是从哪里跳过来的
		if($_POST['weeknum'])
		{
			show_msg('保存成功', 'admin.php?ac=weekly&fileurl=report&do=list&weeknum='.$_POST['weeknum'],200);die;
		}
		else
		{
			show_msg('保存成功', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list',200);die;
		}
		
	}
	else if( $do == 'sub')
	{
		$uid = getGP('uid','P');
		$week_number = $_POST['week_number'];
		$week_number_plan = $_POST['week_number_plan'];

		//查询审核流程中是否有这个个人或是部门的指定审核人，没有则查找最近上级审核
		$username_id = $_USER->id;

		//个人配置了审核指定人个人先审核、没有指定审核人直接找到上级审核人
		$flow_infos = $db-> fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_access   WHERE    user_id=".$username_id);

		if( empty($flow_infos))
		{
			$flow_infos = $db-> fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_access WHERE    deparment_id=".$_POST['departmentida'] );
		}

		//没有配置审核流程就提示没有配置审核流程
		if( empty($flow_infos) ){  show_msg('此用户未配置审核流程!请联系管理员配置审核流程...', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list');die;}


		/********   查询部门数据是否已经存在   **********/ 
		// $sqls = "SELECT * FROM ".DB_TABLEPRE."weely_score WHERE   is_submit='1' AND user_id=".$_USER->id." AND weekly_number=$week_number AND  department_id=$_POST[departmentida] AND  weekly_number_plan = $week_number_plan AND create_time_start like '".date('Y')."%'";
		$sqls = "SELECT * FROM ".DB_TABLEPRE."weely_score WHERE  user_id=".$_USER->id." AND weekly_number=$week_number AND  department_id=$_POST[departmentida] AND create_time_start like '".date('Y')."%'";

		$infoWeek_fall = $db->fetch_all($sqls);
		$operationType = $_POST['operationType'];
		if($operationType=='weeklyadd' && count($infoWeek_fall ) > 0)
		{
			show_msg('你本周提交的周报已经存在,请勿重复提交!', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');die;
		}


			if(date("W") != $week_number  )
			{
				$message ='请注意,本周为第'.date("W").'自然周与您提交的周数'.$week_number.'不相同!';
			}
			else
			{
				$message = '';
			}

				$uid = $_USER->id;
				$week_number = $_POST['week_number'];
				$week_number_plan = $_POST['week_number_plan'];


				//获取手动填写的时间
				$weekly_first_start = $_POST['weekly_first_start']; //提交总结选择时间
				$weekly_first_end = $_POST['weekly_first_end'];     //提交总结结束时间

				$weekly_second_start = $_POST['weekly_second_start']; //计划汇报选择时间
				$weekly_second_end = $_POST['weekly_second_end'];     //计划汇报结束时间


				$week_first_A = $_POST['week_first_A'];
				$week_first_B = $_POST['week_first_B'];
				$week_first_C = $_POST['week_first_C'];
				$week_first_D = $_POST['week_first_D'];
				$week_first_E = $_POST['week_first_E'];
				$week_first_F = $_POST['week_first_F'];
				$week_first_G = $_POST['week_first_G'];
				$week_first_H = $_POST['week_first_H'];
				$week_first_I = $_POST['week_first_I'];
	
				$week_second_A = $_POST['week_second_A'];
				$week_second_B = $_POST['week_second_B'];
				$week_second_C = $_POST['week_second_C'];
				$week_second_D = $_POST['week_second_D'];
				$week_second_E = $_POST['week_second_E'];
				$week_second_F = $_POST['week_second_F'];
				$week_second_G = $_POST['week_second_G'];
				$week_second_G_is = $_POST['week_second_G_is'];
				$week_second_H = $_POST['week_second_H'];

				$ids =array();
				$ids_summary =array();
				/*************     总结汇报   *************/
				foreach($week_first_A as $key=>$value)
				{
					$infoArray =array(

							'week_number'=>$week_number,
							'week_number_plan'=>$week_number_plan,
							'week_first_F'=>$week_first_F[$key],
							'week_first_G'=>$week_first_G[$key],
							'week_first_H'=>$week_first_H[$key],
							'week_first_I'=>empty($week_first_I[$key])?0:$week_first_I[$key],

							'week_second_A'=>$value,
							'week_second_B'=>$week_first_B[$key],
							'week_second_C'=>$week_first_C[$key],
							'week_second_D'=>$week_first_D[$key],
							'week_second_E'=>$week_first_E[$key],

							'create_end_time'=>date("Y-m-d H:i:s"),
							'weekly_first_start'=>$weekly_first_start,
							'weekly_first_end'=>$weekly_first_end,
							'weekly_status'=>'1',
							'weekly_lock'=>'1',
							'weekly_type'=>'1'

						);


					//判断数据库是否之前有数据有的话更新没有插入数据
					if(!$_POST['idFirstAr'][$key]){ $_POST['idFirstAr'][$key] = 0; }
					$is_operation = isExcistData('weekly_info','id',$_POST['idFirstAr'][$key]);
					
					if($is_operation){

						array_push($ids,$_POST['idFirstAr'][$key]);
						array_push($ids_summary,$_POST['idFirstAr'][$key]);
						unset($infoArray['create_start_time']);
						//如果不是本周的周报任务不能修改成本周的信息
						$infoArray['weekly_type'] = !empty($is_operation['weekly_type'])?$is_operation['weekly_type']:'1';
						$infoArray['week_number'] = !empty($is_operation['week_number'])?$is_operation['week_number']:$week_number;
						$infoArray['week_number_plan'] = !empty($is_operation['week_number_plan'])?$is_operation['week_number_plan']:$week_number_plan;
						$infoArray['create_start_time'] = !empty($is_operation['create_start_time'])?$is_operation['create_start_time']:date("Y-m-d H:i:s",PHP_TIME);
						$infoArray['weekly_first_start'] = !empty($is_operation['weekly_first_start'])?$is_operation['weekly_first_start']:$weekly_first_start;
						$infoArray['weekly_first_end'] = !empty($is_operation['weekly_first_end'])?$is_operation['weekly_first_end']:$weekly_first_end;
						update_db('weekly_info',$infoArray, array('id' => $_POST['idFirstAr'][$key]));
					}else{

						$id_only = insert_db('weekly_info',$infoArray);
						array_push($ids,$id_only);
						array_push($ids_summary,$id_only);
					}

			
				

				}

				$ids_plan = array();
				/***     计划汇总   ***/
				foreach($week_second_A as $key=>$value)
				{
					$infoArrays =array(

							'week_number'=>$week_number,
							'week_number_plan'=>$week_number_plan,
					
							'week_second_A'=>$week_second_A[$key],
							'week_second_B'=>$week_second_B[$key],
							'week_second_C'=>$week_second_C[$key],
							'week_second_D'=>$week_second_D[$key],
							'week_second_E'=>$week_second_E[$key],
							'week_second_F'=>$week_second_F[$key],
							'week_second_G'=>$week_second_G[$key],
							'week_second_G_is'=>empty($week_second_G[$key])?'0':'1',
							'week_second_H'=>$week_second_H[$key],

							'create_end_time'=>date("Y-m-d H:i:s"),
							
							'weekly_second_start'=>$weekly_second_start,
							'weekly_second_end'=>$weekly_second_end,
							'weekly_type'=>'2',  //2´ú±í¼Æ»®»ã±¨
							'weekly_lock'=>'1',
							'weekly_status'=>'1'

						);


					//查询数据库中是否有本数据
					if(!$_POST['idSecondAr'][$key]){ $_POST['idSecondAr'][$key] = 0; }
					$is_operations = isExcistData('weekly_info','id',$_POST['idSecondAr'][$key]);

					if($is_operations){
						array_push($ids,$_POST['idSecondAr'][$key]);
						array_push($ids_plan,$_POST['idSecondAr'][$key]);
						unset($infoArrays['create_start_time']);
						//如果不是本周的周报任务不能修改成本周的信息
						$infoArrays['weekly_type'] = !empty($is_operations['weekly_type'])?$is_operations['weekly_type']:'2';
						$infoArrays['week_number'] = !empty($is_operations['week_number'])?$is_operations['week_number']:$week_number;
						$infoArrays['week_number_plan'] = !empty($is_operations['week_number_plan'])?$is_operations['week_number_plan']:$week_number_plan;
						$infoArrays['create_start_time'] = !empty($is_operations['create_start_time'])?$is_operations['create_start_time']:date("Y-m-d H:i:s",PHP_TIME);
						$infoArrays['weekly_second_start'] = !empty($is_operations['weekly_second_start'])?$is_operations['weekly_second_start']:$weekly_second_start;
						$infoArrays['weekly_second_end'] = !empty($is_operations['weekly_second_end'])?$is_operations['weekly_second_end']:$weekly_second_end;
						update_db('weekly_info',$infoArrays, array('id' => $_POST['idSecondAr'][$key]));

					}else{

						$id_only_s = insert_db('weekly_info',$infoArrays);
						array_push($ids,$id_only_s);
						array_push($ids_plan,$id_only_s);
				
					}


				}


				//周报主表中是否有数据
				$total_description = $db-> fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weely_score WHERE  weekly_number_plan = ".$week_number_plan." AND weekly_number=".$week_number." AND user_id=".$uid);

				$data_total = array(


							'weekly_number'=>$week_number,
							'weekly_number_plan'=>$week_number_plan,

							'create_time_start'=>$weekly_first_start,
							'create_time_end'=>$weekly_first_end,

							'create_time_start_plan'=>$weekly_second_start,
							'create_time_end_plan'=>$weekly_second_end,

							'description'=>$_POST['description'],
							'desciption_new'=>$_POST['desciption_new'],
							'description_plan'=>$_POST['description_plan'],

							'user_id'=>$uid,  
							'is_confirm'=>'1',
							'is_submit'=>'1',  //0´ú±íÎ´Ìá½»
							'create_time_early'=>date('Y-m-d H:i:s'),
							'create_time_sub'=>date('Y-m-d H:i:s'),
							'ids_weekly'=>implode(",",$ids),  //0´ú±íÎ´Ìá½»
							'department_id'=>$_POST['departmentida'], //0´ú±íÎ´Ìá½»
							'opinion_two'=>'', //二级审核人为空
							'verify_status'=>'1'//更新周报主表的信息
						);


				if($total_description)
				{
					unset($data_total['create_time_early']);
					update_db('weely_score',$data_total, array('id' => $total_description['id']));
				}
				else
				{
					$ids_wek = insert_db('weely_score',$data_total);
				}

				$ids_weks = $total_description['id']?$total_description['id']:$ids_wek;


				//加入周报显示分类表
				$is_list = isExcistData('weekly_listtable_type','weekly_id',$ids_weks);

				if($is_list)
				{
					update_db('weekly_listtable_type',array('summary_id'=>implode(',', $ids_summary),'plan_id'=>implode(',', $ids_plan)), array('weekly_id' => $ids_weks));
				}
				else
				{
					insert_db('weekly_listtable_type',array('summary_id'=>implode(',', $ids_summary),'plan_id'=>implode(',', $ids_plan),'weekly_id'=>$ids_weks));
				}



				//插入数据库审核表中(先判断数据库中是否存在这个信息存在就修改,不存在就添加)
				$ins_score_ff = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_flow_course WHERE weekly_id=".$ids_weks." AND user_id=".$flow_infos['one_person']);
				if( $ins_score_ff )
				{
					$flow_data = array(

									'status'=>'0'
								);

					update_db('weekly_flow_course',$flow_data,array('id'=>$ins_score_ff['id']));
				}
				else
				{
					$flow_data = array(
								'flow_code'=>$flow_infos['access_code'],
								'weekly_id'=>$total_description['id']?$total_description['id']:$ids_wek,
								'user_id'=>$flow_infos['one_person'] //一级审核人
					);

					insert_db('weekly_flow_course',$flow_data);
				}

				//如果是第二次修改就把二级审核人意见去掉(相当于重新审核)
				
			
				//成功提交
				show_msg('提交周报成功'.$message, 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list');

		// }

		
		

	}else if(  $do == 'view' ){

		$orderid = $_GET['orderid'];
		//根据传递进来的参数来找出对应的周报
		$result = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."user a,".DB_TABLEPRE."user_view b WHERE a.id=b.uid and a.id = '$_USER->id' ");

		if ($result)
		{


			//新版周报数据总结
			$infoWeek_fall = $db->fetch_all(" SELECT * FROM toa_weekly_info WHERE FIND_IN_SET(id, (select  CONCAT(',',summary_id,',') from toa_weekly_listtable_type where weekly_id = $orderid)   ) ");



			//新版周报数据计划
			$infoWeek_plan_fall = $db->fetch_all(" SELECT * FROM toa_weekly_info WHERE FIND_IN_SET(id, (select  CONCAT(',',plan_id,',') from toa_weekly_listtable_type where weekly_id = $orderid)   ) ");


			//新版数据没有的话显示旧版数据
			if( empty($infoWeek_fall) && empty($infoWeek_plan_fall) )
			{

				// 周报总结
				$infoWeek_fall = $db->fetch_all(" SELECT * FROM toa_weekly_info WHERE FIND_IN_SET(id, (select  CONCAT(',',ids_weekly,',') from toa_weely_score where id = $orderid)) and (weekly_type=1 or is_show_to_plan='1') ");


				//周报计划
				$infoWeek_plan_fall = $db->fetch_all(" SELECT * FROM toa_weekly_info WHERE FIND_IN_SET(id, (select  CONCAT(',',ids_weekly,',') from toa_weely_score where id = $orderid)) and (weekly_type=2  or   is_show_to_plan='1')");

			}


			// //新版周报数据总结
			// $infoWeek_fall = $db->fetch_all(" SELECT * FROM toa_weekly_info WHERE FIND_IN_SET(id, (select  CONCAT(',',summary_id,',') from toa_weekly_listtable_type where weekly_id = $orderid)   ) ");



			// //新版周报数据计划
			// $infoWeek_plan_fall = $db->fetch_all(" SELECT * FROM toa_weekly_info WHERE FIND_IN_SET(id, (select  CONCAT(',',plan_id,',') from toa_weekly_listtable_type where weekly_id = $orderid)   ) ");



			//现在星期几
			$nowTimeWeeknumber = date('w',PHP_TIME);   	//0（表示星期天）到 6（表示星期六）
			// $nowTimeWeeknumber = 0;   	//0（表示星期天）到 6（表示星期六）
			
			if($nowTimeWeeknumber == 0 || $nowTimeWeeknumber == 6)
			{
					$day = $nowTimeWeeknumber == 0 ?2:1;

					// var_dump($day);die;
					$stamp = strtotime("-".$day."days",time());
			}
			else
			{
					$day = 5-$nowTimeWeeknumber;
					$stamp = strtotime("+ ".$day."days",time());
			}
			$time = date('Y-m-d',$stamp);

			//后台显示数据
			$resultWeekInfo = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."week_parameter");

			$user_id = $_USER->id;

			//取出这次周报的主要信息（判断这次的信息是否确认，确认后不能修改）
			$infoWeek_order = $db->fetch_one_array("select * from toa_weely_score where id=$orderid");

			//汇报人姓名 
			$name = $db->fetch_one_array("select b.name from toa_user a left join toa_user_view b on a.id=b.uid  where a.id=".$infoWeek_order['user_id'])['name'];


			//显示部门信息
			$user_id = $_USER->id;
			$departmentid_on = $db->fetch_all("select a.*,b.name from ".DB_TABLEPRE."weekly_depart a ,".DB_TABLEPRE."department b where a.department_id = b.id and a.uid=".$user_id);

			//显示本周报的所属的部门
			$department_name_specil = $db->fetch_one_array("select id,name from ".DB_TABLEPRE."department  where id=".$infoWeek_order['department_id']);

			//是否已经确认周报
			$status_is_confirm = $infoWeek_order['is_confirm'];

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

			$status_is_confirm == '1';
			$infoWeek_order['verify_status'] != '5';

			
			//输入上限
			$resultCeil = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_ceil");
			//本周是第几周
			$weekly_nm  = date("W");
			include_once('template/week_view.php');
		} else {
			prompt('当前用户信息不存在');
		}

	}
	else if(   $do == 'del'  )
	{
		$numk = explode('-',$_GET['orderid']);
		if ($result = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."user a,".DB_TABLEPRE."user_view b WHERE a.id=b.uid and a.id = '$_USER->id' "))
		{
			//删除总结和计划数据
			$data_total =  $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."weekly_info  WHERE   FIND_IN_SET(id, (SELECT
				GROUP_CONCAT(ids_weekly)
			FROM
				toa_weely_score
			WHERE
				id = $numk[0]) ) and week_number=$numk[1]");


			foreach( $data_total as $value)
			{
				//删除本周的周报不能删除不同周期的周报
				$db->query("DELETE FROM toa_weekly_info WHERE  id=".$value['id']);
				
			}

			//删除score表数据
			$db->query("DELETE FROM toa_weely_score WHERE  id=".$numk[0]);
			//删除状态表 
			$db->query("DELETE FROM toa_weekly_listtable_type WHERE  weekly_id=".$numk[0]);

			//数据删除
			show_msg('周报删除成功', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list',500);

		}

	}
	else if( $do == 'edit' )
	{
		$uid = getGP('uid','P');
		
		$week_number = $_POST['week_number'];
		$week_number_plan = $_POST['week_number_plan'];


		//获取手动填写的时间
		$weekly_first_start = $_POST['weekly_first_start']; //提交总结选择时间
		$weekly_first_end = $_POST['weekly_first_end'];     //提交总结结束时间

		$weekly_second_start = $_POST['weekly_second_start']; //计划汇报选择时间
		$weekly_second_end = $_POST['weekly_second_end'];     //计划汇报结束时间


		$week_first_A = $_POST['week_first_A'];
		$week_first_B = $_POST['week_first_B'];
		$week_first_C = $_POST['week_first_C'];
		$week_first_D = $_POST['week_first_D'];
		$week_first_E = $_POST['week_first_E'];
		$week_first_F = $_POST['week_first_F'];
		$week_first_G = $_POST['week_first_G'];

		$week_first_H = $_POST['week_first_H'];
		$week_first_I = $_POST['week_first_I'];

		$week_second_A = $_POST['week_second_A'];
		$week_second_B = $_POST['week_second_B'];
		$week_second_C = $_POST['week_second_C'];
		$week_second_D = $_POST['week_second_D'];
		$week_second_E = $_POST['week_second_E'];
		$week_second_F = $_POST['week_second_F'];
		$week_second_G = $_POST['week_second_G'];
		$week_second_G_is = $_POST['week_second_G_is'];
		$week_second_H = $_POST['week_second_H'];


		$ids =array();
		$ids_summary =array();
		/*************     总结汇报   *************/
		foreach($week_first_A as $key=>$value)
		{
			

			$infoArray =array(

					'week_number'=>$week_number,
					'week_number_plan'=>$week_number_plan,
					'week_first_F'=>$week_first_F[$key],
					'week_first_G'=>$week_first_G[$key],
					'week_first_H'=>$week_first_H[$key],
					'week_first_I'=>$week_first_I[$key],

					'week_second_A'=>$value,
					'week_second_B'=>$week_first_B[$key],
					'week_second_C'=>$week_first_C[$key],
					'week_second_D'=>$week_first_D[$key],
					'week_second_E'=>$week_first_E[$key],
					'create_start_time'=>date("Y-m-d H:i:s"),
					'weekly_first_start'=>$weekly_first_start,
					'weekly_first_end'=>$weekly_first_end,
					'weekly_status'=>'1',
					'weekly_lock'=>'1',
					'weekly_type'=>'1'

				);


			//判断数据库是否之前有数据有的话更新没有插入数据
			if(!$_POST['idFirstAr'][$key]){ $_POST['idFirstAr'][$key] = 0; }
			$is_operation = isExcistData('weekly_info','id',$_POST['idFirstAr'][$key]);
			
			if($is_operation){

				array_push($ids,$_POST['idFirstAr'][$key]);
				array_push($ids_summary,$_POST['idFirstAr'][$key]);
				unset($infoArray['create_start_time']);


				//如果不是本周的周报任务不能修改成本周的信息
				$infoArray['weekly_type'] = !empty($is_operation['weekly_type'])?$is_operation['weekly_type']:'1';
				$infoArray['week_number'] = !empty($is_operation['week_number'])?$is_operation['week_number']:$week_number;
				$infoArray['week_number_plan'] = !empty($is_operation['week_number_plan'])?$is_operation['week_number_plan']:$week_number_plan;
				$infoArray['create_start_time'] = !empty($is_operation['create_start_time'])?$is_operation['create_start_time']:date("Y-m-d H:i:s",PHP_TIME);
				$infoArray['weekly_first_start'] = !empty($is_operation['weekly_first_start'])?$is_operation['weekly_first_start']:$weekly_first_start;
				$infoArray['weekly_first_end'] = !empty($is_operation['weekly_first_end'])?$is_operation['weekly_first_end']:$weekly_first_end;

				update_db('weekly_info',$infoArray, array('id' => $_POST['idFirstAr'][$key]));
			}else{

				$id_only = insert_db('weekly_info',$infoArray);
				array_push($ids,$id_only);
				array_push($ids_summary,$id_only);
			}

		}


		$ids_plan = array();

		/***     计划汇总   ***/
		foreach($week_second_A as $key=>$value)
		{
			$infoArrays =array(

					'week_number'=>$week_number,
					'week_number_plan'=>$week_number_plan,
			
					'week_second_A'=>$week_second_A[$key],
					'week_second_B'=>$week_second_B[$key],
					'week_second_C'=>$week_second_C[$key],
					'week_second_D'=>$week_second_D[$key],
					'week_second_E'=>$week_second_E[$key],
					'week_second_F'=>$week_second_F[$key],
					'week_second_G'=>$week_second_G[$key],
					'week_second_G_is'=>empty($week_second_G[$key])?'0':'1',
					'week_second_H'=>$week_second_H[$key],

					'create_start_time'=>date("Y-m-d H:i:s"),
					
					'weekly_second_start'=>$weekly_second_start,
					'weekly_second_end'=>$weekly_second_end,
					'weekly_status'=>'1',
					'weekly_lock'=>'1',
					'weekly_type'=>'2'  //2´ú±í¼Æ»®»ã±¨

				);


			//查询数据库中是否有本数据
			if(!$_POST['idSecondAr'][$key]){ $_POST['idSecondAr'][$key] = 0; }
			$is_operations = isExcistData('weekly_info','id',$_POST['idSecondAr'][$key]);

			if($is_operations){
				array_push($ids,$_POST['idSecondAr'][$key]);
				array_push($ids_plan,$_POST['idSecondAr'][$key]);
				unset($infoArrays['create_start_time']);


				//如果不是本周的周报任务不能修改成本周的信息
				$infoArrays['weekly_type'] = !empty($is_operations['weekly_type'])?$is_operations['weekly_type']:'2';
				$infoArrays['week_number'] = !empty($is_operations['week_number'])?$is_operations['week_number']:$week_number;
				$infoArrays['week_number_plan'] = !empty($is_operations['week_number_plan'])?$is_operations['week_number_plan']:$week_number_plan;
				$infoArrays['create_start_time'] = !empty($is_operations['create_start_time'])?$is_operations['create_start_time']:date("Y-m-d H:i:s",PHP_TIME);
				$infoArrays['weekly_second_start'] = !empty($is_operations['weekly_second_start'])?$is_operations['weekly_second_start']:$weekly_second_start;
				$infoArrays['weekly_second_end'] = !empty($is_operations['weekly_second_end'])?$is_operations['weekly_second_end']:$weekly_second_end;


				update_db('weekly_info',$infoArrays, array('id' => $_POST['idSecondAr'][$key]));

			}else{

				$id_only_s = insert_db('weekly_info',$infoArrays);
				array_push($ids,$id_only_s);
				array_push($ids_plan,$id_only_s);
		
			}



		}


		//周报主表中是否有数据
		$total_description = $db-> fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weely_score WHERE  weekly_number_plan = ".$week_number_plan." AND weekly_number=".$week_number." AND user_id=".$uid);

		$data_total = array(

					'weekly_number'=>$week_number,
					'weekly_number_plan'=>$week_number_plan,

					'create_time_start'=>$weekly_first_start,
					'create_time_end'=>$weekly_first_end,

					'create_time_start_plan'=>$weekly_second_start,
					'create_time_end_plan'=>$weekly_second_end,

					'description'=>$_POST['description'],
					'desciption_new'=>$_POST['desciption_new'],
					'description_plan'=>$_POST['description_plan'],
					'is_poor_planing'=>$_POST['is_poor_planing'],
					'user_id'=>$uid, 
					'create_time_early'=>date('Y-m-d H:i:s'),
					'ids_weekly'=>implode(",",$ids),  //0´ú±íÎ´Ìá½»

					'department_id'=>$_POST['departmentida']  //0´ú±íÎ´Ìá½»

			);


			if($total_description)
			{
				unset($data_total['create_time_early']);
				update_db('weely_score',$data_total, array('id' => $total_description['id']));
			}
			else
			{
				$id_only_list = insert_db('weely_score',$data_total);
			}

			//加入周报显示分类表
			$order_id_list = $total_description['id']?$total_description['id']:$id_only_list;
			$is_list = isExcistData('weekly_listtable_type','weekly_id',$order_id_list);
			if($is_list)
			{
				$id = update_db('weekly_listtable_type',array('summary_id'=>implode(',', $ids_summary),'plan_id'=>implode(',', $ids_plan)), array('weekly_id' => $order_id_list));

			}
			else
			{
				insert_db('weekly_listtable_type',array('summary_id'=>implode(',', $ids_summary),'plan_id'=>implode(',', $ids_plan),'weekly_id'=>$order_id_list));
			}



		
		//判断是从哪里跳过来的
		if($_POST['weeknum'])
		{
			show_msg('保存成功', 'admin.php?ac=weekly&fileurl=report&do=list&weeknum='.$_POST['weeknum'],200);die;
		}
		else
		{
			
			show_msg('保存成功', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=view&orderid='.$_POST['orderid'],200);die;
			
		}
		
	}
	else if( $do == 'delOne' )
	{
		$orderid = $_GET['orderid'];
		$infoid = $_GET['infoid'];

		$DATA = $db->fetch_one_array("select *  FROM toa_weekly_info WHERE  id=$infoid");
		$db->query("DELETE FROM toa_weekly_info WHERE  id=$infoid");
		show_msg('数据删除成功', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=view&orderid='.$orderid,500);
	}


?>