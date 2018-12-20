<?php 
	
	//查看是否有权限
	(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');

	empty($do) && $do = 'list';
	if($do == 'list')
	{
		 // error_reporting(E_ALL);
		/*
		*  取出当前的登录用户是否为部门负责人
		**/

		//查询部门中的人
		$result = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."user WHERE  id=".$_USER->id);


		//判断是否是管理组还是超级管理组  1超级管理组 2用户组 4系统管理员组 5管理员组
		$info_person_group = $db->fetch_one_array("SELECT groupid FROM ".DB_TABLEPRE."user  WHERE id=".$_USER->id);

		//周报日志的权限是每个人都要有的部门经理可以查看下面所有员工的日志 
		$userid = $_USER->id;
		//查询部门和部门负责人
		$data = $db->fetch_one_array('SELECT keytype,departmentid FROM '.DB_TABLEPRE.'user WHERE id='.$userid);
		preg_match('/\d+/',$data['departmentid'],$departmentid);

		//按照权限查看数据
		if($_USER->id == '1') //超级管理员
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


		//查询是否提交过数据
		$info_is_exist = $db->fetch_one_array('SELECT * FROM '.DB_TABLEPRE.'weekly_commit_history ORDER BY week_num ASC limit 1');


		if( count($info_is_exist) > 0)
		{
			$addition = '  AND   a.weekly_number >= '.($info_is_exist['week_num']+1).'  AND create_time like "%'.date('Y-m',PHP_TIME).'%"';
		}
		else
		{
			$addition = '';
		}


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
					$accessInfo  $addition";

		$info = $db->fetch_all($sqls);

		//修改数据
		$info_weekly = array();
		foreach($info as $key=>$value)
		{
			$number = $value['weekly_number'];

			//查询同一个人的多条记录	
			$array_info =$db->fetch_all('SELECT * FROM '.DB_TABLEPRE.'weely_score WHERE	 user_id='.$value['user_id'].' AND verify_status = 4  ORDER BY weekly_number ASC');


			$array_infos = array();
			//按月分类
			foreach($array_info as $k=>$v)
			{
				//月份的查询
				$ins = get_weekinfo( date('Y',strtotime( $v['create_time_start']) ),$v['weekly_number']);

				//月份、第几周
				$array_infos[$ins[0].'-'.$v['department_id']]['base']= $v;
				$array_infos[$ins[0].'-'.$v['department_id']]['data'][$ins[2]]= $v;
			}



		}
		// dump($array_infos);die;
		//查看数据是否存在
		// $info = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."weekly_statistics");
		// $array_infos = !empty($info)?$info:$array_infos;
		include_once('template/score_statistics.php');

	}
	else if($do == 'sub')
	{
		// dump($_POST);die;

		$stringid= '';
		foreach($_POST['firstWeekWeight'] as $key=>$value)
		{

			$array = array(

				'uid'=>$_POST['uid'][$key],
				'departmentName'=>$_POST['departmentName'][$key],
				'month'=>$_POST['month'][$key],
				'examineCycle'=>$_POST['examineCycle'][$key],
				'month'=>$_POST['month'][$key],
				
				'firstWeekWeight'=>$value,
				'firstWeekScore'=>$_POST['firstWeekScore'][$key],

				'secondWeekWeight'=>$_POST['secondWeekWeight'][$key],
				'secondWeekScore'=>$_POST['secondWeekScore'][$key],

				'thirdWeekWeight'=>$_POST['thirdWeekWeight'][$key],
				'thirdWeekScore'=>$_POST['thirdWeekScore'][$key],

				'fourthWeekWeight'=>$_POST['fourthWeekWeight'][$key],
				'fourthWeekScore'=>$_POST['fourthWeekScore'][$key],

				'fifthWeekWeight'=>$_POST['fifthWeekWeight'][$key],
				'fifthWeekScore'=>$_POST['fifthWeekScore'][$key],

				'managerContent'=>$_POST['managerContent'][$key],
				'managerContent'=>$_POST['managerContent'][$key],
				'monthScore'=>$_POST['monthScore'][$key],
				'monthpreg'=>$_POST['monthpreg'][$key],
				'seasonScore'=>$_POST['seasonScore'][$key],
				'create_time'=>time(),
				'is_complate'=>'0'

			);
			// dump($array);die;
			$insetid =insert_db('weekly_statistics',$array);
			$stringid .= ','.$insetid;
		}

		//添加提交的额经验
		$min_month = min(array_filter($_POST['wekid']));
		$max_month = max(array_filter($_POST['wekid']));

		//添加提交月份记录
		$array_info_commit = array(
			'min_week_num'=>$min_month,
			'week_num'=>$max_month,
			'ids_week'=>ltrim($stringid,','),
			'max_month'=>max(array_filter($_POST['month'])),
			'min_month'=>min(array_filter($_POST['month'])),
			'weekly_ids_total'=>implode(',',array_filter($_POST['wekid'])),
			'create_time'=>date('Y-m-d H:i:s',PHP_TIME),
			'is_complate'=>'0'
		);

		// dump($array_info_commit);die;

		insert_db('weekly_commit_history',$array_info_commit);

		show_msg('添加成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=detailList'); 
	}
	else if($do == 'month')
	{
		// dump( $_SERVER);
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			//保存数据并计算
		}
		else
		{
			
			//根据月份ID展示数据
			$id = (int)$_GET['idsOrder'];

			//查询是否提交过数据
			$infos = $db->fetch_all('SELECT * FROM '.DB_TABLEPRE.'weekly_statistics WHERE  FIND_IN_SET(id, (SELECT ids_week FROM toa_weekly_commit_history WHERE id='.$id.'))');

			//显示提交过的数据
			include_once('template/month_statistics.php');
		}
	}
	else if($do == 'monthSub')
	{
		//处理提交过来的数据
		$id = $_POST['oid'];

		foreach($id as $key=>$value)
		{
			$array_data = array(

					'firstWeekWeight'=>'',
					'firstWeekScore'=>'',
					'secondWeekWeight'=>'',
					'secondWeekScore'=>'',
					'thirdWeekWeight'=>'',
					'thirdWeekScore'=>'',
					'fourthWeekWeight'=>'',
					'fourthWeekScore'=>'',
					'fifthWeekWeight'=>'',
					'fifthWeekScore'=>'',
					'managerContent'=>'',
					'monthpreg'=>'',
					'seasonScore'=>''
				);

			update_db('weekly_statistics',$array_data, array('id' =>$value));
		}

		//计算绩效月和季度
		
		
		
	}
	else if($do == 'detailList')
	{
		$page = max(1, getGP('page','G','int'));
		// $pagesize = 1;	
		$pagesize = $_CONFIG->config_data('pagenum');
		$offset = ($page - 1) * $pagesize;
		$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=detailList';

		$infos = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."weekly_commit_history LIMIT ".$offset.",".$pagesize);

		$nums = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."weekly_commit_history");
		$num = count($nums);

		include_once('template/month_statistics_list.php');

	}




	//计算每个月有多少周 #开始时间结束时间
	function get_weekinfo($years,$weekly)
	{
		$arraysTotal = array();
		for($is=1;$is<=12;$is++)
		{
			$month = $years.'-'.$is;
		    $weekinfo = array();
		    $end_date = date('d',strtotime($month.' +1 month -1 day'));
		    for ($i=1; $i <$end_date ; $i=$i+7)
		    { 
		        $w = date('N',strtotime($month.'-'.$i));
		        $number = date('W',strtotime($month.'-'.$i.' -'.($w-1).' days'));
		        $weekinfo[$number] = array(date('Y-m-d',strtotime($month.'-'.$i.' -'.($w-1).' days')),date('Y-m-d',strtotime($month.'-'.$i.' +'.(7-$w).' days')));
		        $weekinfo['month'] = $is;
		        
		    }
		    $arraysTotal[$is] = $weekinfo;
		}


		// dump($arraysTotal);die;
		foreach($arraysTotal as $ke=>$val)
		{
			$j = 0;
			foreach($val as $kl=>$vl)
			{
				if( $kl == $weekly )
				{
					return $val['month'].'-'.$j;
				}

				$j++;
			}
			
		}
	    return false;
	}
	




?>