<?php 
	
	//设置默认时区
	date_default_timezone_set('PRC');
	//ÊÇ·ñµÇÂ½Ò³Ãæ
	(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
	empty($do) && $do = 'excel';
	if($do == 'list')
	{
		//判断是否是管理组还是超级管理组  1超级管理组 2用户组 4系统管理员组 5管理员组
		$info_person_group = $db->fetch_one_array("SELECT groupid FROM ".DB_TABLEPRE."user  WHERE id=".$_USER->id);

		//周报日志的权限是每个人都要有的部门经理可以查看下面所有员工的日志 
		$userid = $_USER->id;
		//查询部门和部门负责人
		$data = $db->fetch_one_array('SELECT keytype,departmentid FROM '.DB_TABLEPRE.'user WHERE id='.$userid);
		preg_match('/\d+/',$data['departmentid'],$departmentid);

		//多字段查询
		$wheresql = '';
		$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list';

		//姓名
		if ($name = getGP('name','G')) {
			$wheresql .= " AND c.name LIKE '%$name%'";
			$url .= '&name='.rawurlencode($name);
		}
		//用户名search
		if ($username = getGP('username','G')) {
			$wheresql .= " AND b.username LIKE '%$username%'";
			$url .= '&username='.rawurlencode($username);
		}
		//部门search
		if ($department = getGP('department','G','int')) {
			$wheresql .= " AND b.departmentid LIKE '%$department%'";
			$url .= '&department='.$department;	
		}

		//开始时间
		if ($starttime = getGP('starttime','G')) {
			$wheresql .= " AND a.create_time_early >= '$starttime' ";
			$url .= '&starttime='.$starttime;	
		}

		//结束时间
		if ($endtime = getGP('endtime','G')) {
			$wheresql .= " AND a.create_time_sub <= '$endtime' ";
			$url .= '&endtime='.$endtime;	
		}

		//查询一下这个是不是本部门的数据不是则提示无权查看数据
		if($_USER->id == '1')
		{
			$accessInfo = '';
		}
		else if( $data['keytype'] == '1') //当前用户是本部门负责人
		{
			//取出当前部门的数据
			$accessInfo = ' AND department_id='.$departmentid[0];
		}
		else
		{
			//取出当前用户
			$accessInfo = ' AND user_id='.$userid;
		}

		//查询条件有限展示
		$where = empty($wheresql)?$accessInfo:$wheresql;	
		
		
		/************************  取出自己保存的周报数据 ***************************/
		$page = max(1, getGP('page','G','int'));
		$pagesize = $_CONFIG->config_data('pagenum');
		// $pagesize = 2;	
		$offset = ($page - 1) * $pagesize;
		
		$sqls = "SELECT
					a.*
				FROM
					toa_weely_score a
				LEFT JOIN 
					toa_user b ON  a.user_id =b.id
				LEFT JOIN	
					toa_user_view c ON b.id = c.uid  
				WHERE 
					a.verify_status = '4'
					$where
				LIMIT  ".$offset.",".$pagesize;


		$data = $db->fetch_all($sqls);

		//检测是不是应该查询的结果

		//判断周报是不是应该显示
		$sqlNumber = "SELECT
					a.*
				FROM
					toa_weely_score a
				LEFT JOIN 
					toa_user b ON  a.user_id =b.id
				LEFT JOIN	
					toa_user_view c ON b.id = c.uid  
				WHERE 
					a.verify_status = '4'
					$where ";

		$nums = $db->fetch_all($sqlNumber);
		$num = count($nums);

		if($_USER->id != '1')
		{
			if(!empty($department) && $department != $departmentid[0] )
			{
				$data = array();
				$num = 0;
			}
		}
		

		include_once('template/week_list_log.php');
	
	}else if(  $do == 'view' ){

		$orderid = $_GET['orderid'];
		//根据传递进来的参数来找出对应的周报
		$result = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."user a,".DB_TABLEPRE."user_view b WHERE a.id=b.uid and a.id = '$_USER->id' ");

		if ($result)
		{
			// 周报总结
			$infoWeek_fall = $db->fetch_all(" SELECT * FROM toa_weekly_info WHERE FIND_IN_SET(id, (select  GROUP_CONCAT(ids_weekly) from toa_weely_score where id = $orderid)) and (weekly_type=1 or is_show_to_plan='1') ");

			//周报计划
			$infoWeek_plan_fall = $db->fetch_all(" SELECT * FROM toa_weekly_info WHERE FIND_IN_SET(id, (select  GROUP_CONCAT(ids_weekly) from toa_weely_score where id = $orderid)) and (weekly_type=2  or   is_show_to_plan='1')");

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
			$name = $db->fetch_one_array("select * from toa_user where id=".$infoWeek_order['user_id'])['name'];


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
			include_once('template/week_view_log.php');
		} else {
			prompt('当前用户信息不存在');
		}

	}
	else if($do == 'count') //添加系数计算得绩效分 
	{

		$orderid = $_GET['orderid'];

		$info = $db->fetch_one_array("SELECT weekly_number,weekly_number_plan,score,user_id FROM ".DB_TABLEPRE."weely_score WHERE id=".$orderid);

		include_once('template/weekly_log_count.php');
	}
	else if($do == 'countsub') //修改绩效得分 
	{
		$orderid = $_POST['orderid'];

		$info = $db->fetch_one_array("SELECT score FROM ".DB_TABLEPRE."weely_score WHERE id=".$orderid);

		$score = round($info['score'] * $_POST['coefficient'],2);
		$array = array(
			'score'=>$score
		);
		update_db('weely_score',$array,array('id'=>$orderid));
		show_msg('绩效分数修改成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list');
	}
	else if($do == 'excel') 
	{

		$datename="weekly_".get_date('YmdHis',PHP_TIME);
		$outputFileName = 'data/excel/'.$datename.'.xls';
		$content = array();
		$archive=array("周报名称","姓名","部门","岗位","岗位代码","一级审核人","审核时间","二级审核人","审核时间","上传时间","所花时间","修改次数","本周绩效得分");
		$content[] = $archive;
		
		$wheresql = '';

		//姓名
		if ($name = getGP('name','P')) {
			$wheresql .= " AND c.name LIKE '%$name%'";
		}
		//用户名search
		if ($username = getGP('username','P')) {
			$wheresql .= " AND b.username LIKE '%$username%'";
		}
		//部门search
		if ($department = getGP('department','P','int')) {
			$wheresql .= " AND b.departmentid LIKE ',%$department%,'";
		}

		//开始时间
		if ($starttime = getGP('starttime','P')) {
			$wheresql .= " AND a.create_time_early >= '$starttime' ";
		}

		//结束时间
		if ($endtime = getGP('endtime','P')) {
			$wheresql .= " AND a.create_time_sub <= '$endtime' ";
		}
		
	
		$sql = "SELECT
					a.*
				FROM
					toa_weely_score a
				LEFT JOIN 
					toa_user b ON  a.user_id =b.id
				LEFT JOIN	
					toa_user_view c ON b.id = c.uid  
				WHERE 
					a.verify_status = '4'
					$wheresql";

		$result = $db->query($sql);


		while ($row = $db->fetch_array($result))
		{	

			$user_id = get_realname($row['user_id']);

			$departmentname = get_realdepaname($row['department_id']);
			$positionname = get_postcode($row['user_id'])['name'];
			$positioncode = get_postcode($row['user_id'])['code'];

			$access_name_first = get_realname( get_realname_access($row['id'])[0]['user_id'] );

			$access_time_first = get_realname_access($row['id'])[0]['update_time'];

			$access_name_second = get_realname(get_realname_access($row['id'])[1]['user_id']);
			$access_time_second = get_realname_access($row['id'])[1]['update_time'];


			$edit_number = $row['edit_number'];
			$count_minute = count_minute($row['create_time_early'],$row['create_time_sub']);

			$archive = array(
				'第'.$row['weekly_number'].'周总结汇报表与第'.$row['weekly_number_plan'].'周计划汇报表',
				"".$user_id."",
				"".$departmentname."",  //部门
				"".$positionname."",    //职位名称
				"".$positioncode."",	//职位代码

				"".$access_name_first."", //第一审核人
				"".$access_time_first."", //审核和时间

				"".$access_name_second."", //第二审核人
				"".$access_time_second."", //审核时间

				"".$row['create_time_sub']."", //提交时间
				"".$count_minute."",       //花费时间
				"".$edit_number."",       //修改次数
				"".$row['score'].""        //绩效分数
			);


			$content[] = $archive;

			
		}
			$excel = new ExcelWriter($outputFileName);
			if($excel==false) 
				echo $excel->error; 
			foreach($content as $v){
				$excel->writeLine($v);
			}
			$excel->sendfile($outputFileName);
		

}
	

?>