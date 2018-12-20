<?php 
	
	//权限编码
	(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
	empty($do) && $do = 'add';

	if( $do == 'list')
	{
		$page = max(1, getGP('page','G','int'));
		// $pagesize = 2;
		$pagesize = $_CONFIG->config_data('pagenum');
		$offset = ($page - 1) * $pagesize;
		$url = 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list';

		$data = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."weekly_access  ORDER BY create_time DESC LIMIT ".$offset.",".$pagesize);

		$nums = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."weekly_access");
		$num = count($nums);

		include_once('template/access_list.php');
	}
	else if($do == 'add')
	{
		$user_id = $_POST['user_id'];
		//数据接收分为用户和部门
		$departmentId = array_filter($_POST['departmentId']);
		$ids_depart = implode(',',$departmentId);

		//流程代码
		$code_access = date('YmdHis').uniqid('',mt_rand(1000000,999999));

		//查询人员是否配备指定流程
		if($user_id)
		{ 
			$idns = isExcistData('weekly_access','user_id',$user_id);

			if($idns)
			{ 
				//数据删除
				show_msg('审核流程添加失败！当前添加人已经有了所属的审核流程', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list');die;
			}
			else
			{
				$dataAccess = array(
								'deparment_id'=>empty($value)?0:$value,
								'user_id'=>$_POST['user_id'] == '0'?0:$_POST['user_id'],
								'one_person'=>$_POST['one_person'] == '0'?'0':$_POST['one_person'],
								'two_person'=>$_POST['two_person'] == '0'?'0':$_POST['two_person'],
								'create_time'=>date('Y-m-d H:i:s'),
								'access_code'=>$code_access
						);
					insert_db('weekly_access',$dataAccess);

				//数据删除
				show_msg('审核流程添加成功', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list',200);
			}
		}

		$ids_depart = implode(',',$departmentId);
		//查询数据有没有信息
		$nums = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_access WHERE deparment_id IN(".$ids_depart.")");
		if($nums)
		{ 
			//数据删除
			show_msg('审核流程添加失败！所选的部门中在流程中已经存在！！！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list');die;
		}

		//查看数据
		if( count($departmentId ) > 0)
		{
			//判断部门的信息存在不存在
			$nums = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_access WHERE deparment_id IN(".$ids_depart.")");
			if($nums)
			{ 
				//数据删除
				show_msg('审核流程添加失败！所选的部门中在流程中已经存在！！！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list',200);die;
			}


			foreach($departmentId as $key=>$value)
			{
				//查询数据有没有信息
				$nums = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_access WHERE deparment_id=".$value);

				if(!$nums)
				{

					$dataAccess = array(
								'deparment_id'=>$value,
								'user_id'=>$_POST['user_id'] == '0'?0:$_POST['user_id'],
								'one_person'=>$_POST['one_person'],
								'two_person'=>$_POST['two_person'],
								'create_time'=>date('Y-m-d H:i:s'),
								'access_code'=>$code_access
						);
					insert_db('weekly_access',$dataAccess);
				}
			}

			//数据删除
			show_msg('审核流程添加成功', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list',200);

		}
		else
		{

				$dataAccess = array(
								'deparment_id'=>empty($value)?0:$value,
								'user_id'=>$_POST['user_id'] == '0'?0:$_POST['user_id'],
								'one_person'=>$_POST['one_person'],
								'two_person'=>$_POST['two_person'],
								'create_time'=>date('Y-m-d H:i:s'),
								'access_code'=>$code_access
						);
					insert_db('weekly_access',$dataAccess);
		
			//数据删除
			show_msg('审核流程添加成功', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list',200);
		}
		



	}
	else if($do == 'del')
	{

		$orderid = $_GET['orderid'];
		//删除总结和计划数据
		$db->query("DELETE  FROM ".DB_TABLEPRE."weekly_access  WHERE   id=".$orderid);
		//数据删除
		show_msg('审核流程删除成功', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list',200);


	}
	else if($do == 'save')
	{

		//POST提交执行
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			/********* 判断数据中是否有流程数据 ********/
			$user_id = $_POST['user_id'];
			$idns = isExcistData('weekly_access','user_id',$user_id);

			if($idns)
			{ 
				//数据删除
				show_msg('审核流程添加失败！当前添加人已经有了所属的审核流程', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list');die;
			}


			$departmentId = array_filter($_POST['departmentId']);
			$ids_depart = implode(',',$departmentId);
			//部门的时候查询数据库当前数据有没有存在
			if(cout($departmentId) > 0 )
			{

				$nums = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_access WHERE deparment_id IN(".$ids_depart.")");
				if($nums)
				{ 
					//数据删除
					show_msg('审核流程添加失败！所选的部门中在流程中已经存在！！！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list');die;
				}
			}

			/********* 判断数据中是否有流程数据 END********/

				//数据接收
				$departmentId = array_filter($_POST['departmentId']);
				// dump($departmentId);die;

				if( count($departmentId ) > 0 && empty($_POST['user_id']))
				{
					foreach($departmentId as $key=>$value)
					{
						//查询数据有没有信息
						$nums = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_access WHERE deparment_id=".$value);
					

						if(count($nums) > 0)
						{

							$dataAccess = array(
										'deparment_id'=>$value,
										'user_id'=>$_POST['user_id'] == '0'?0:$_POST['user_id'],
										'one_person'=>$_POST['one_person'],
										'two_person'=>$_POST['two_person'],
										'three_person'=>$_POST['three_person'],
								);
							update_db('weekly_access',$dataAccess, array('id' => $_POST['idns']));
						}
					}

					show_msg('审核流程已经修改', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list');die;

				}
				else
				{

					$numsm = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_access WHERE id=".$_POST['idns']);
					if( count($numsm) > 0 )
					{

						$dataAccess = array(
										'deparment_id'=>0,
										'user_id'=>$_POST['user_id'] == '0'?0:$_POST['user_id'],
										'one_person'=>$_POST['one_person'],
										'two_person'=>$_POST['two_person'],
										'three_person'=>$_POST['three_person'],
								);
							update_db('weekly_access',$dataAccess, array('id' => $_POST['idns']));
					}
					
				}
				


				//数据删除
				show_msg('审核流程添加成功', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=list',200);

			/********** 更改流程结束 ************/
		}
		else
		{
			$orderid = $_GET['orderid'];
			//根据ID取出数据库的数据
			$infos =  $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."weekly_access  WHERE id=".$orderid);

			if($infos['deparment_id'])   //toa_department
				{ $infos['deparmentName'] = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."department  WHERE id=".$infos['deparment_id'])['name'];}
			if($infos['user_id'])   //toa_department
				{ $infos['name'] = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."user  WHERE id=".$infos['user_id'])['name'];}
			



			//查询部门信息
			$department = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."department WHERE father=0");

			//循环判断是否有下级
			$html;
			foreach($department as $key=>$value)	
			{
				$status  = getDepartmentTree($value['id']);

				$html .= " <li><a href='#' ids=".$value['id'].">".$value['name']."</a>  <input type='checkbox' class='choice'>";
				if($status)
				{
					$html .= $status;
				}
				$html .= "</li>";
			}

			//用户信息
			$userInfo = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."user WHERE ischeck='1'");
		}
		//包含添加流程页面
		include_once('template/access_save.php');
	}
	else if($do == 'view')
	{
		//查询部门信息
		$department = $db->fetch_all("SELECT * FROM ".DB_TABLEPRE."department WHERE father=0");

		//循环判断是否有下级
		$html;
		foreach($department as $key=>$value)	
		{
			$status  = getDepartmentTree($value['id']);

			$html .= " <li><a href='#' ids=".$value['id'].">".$value['name']."</a>  <input type='checkbox' class='choice'>";
			if($status)
			{
				$html .= $status;
			}
			$html .= "</li>";
		}

		//用户信息
		$userInfo = $db->fetch_all("SELECT a.*,b.* FROM ".DB_TABLEPRE."user a left join ".DB_TABLEPRE."user_view b on a.id=b.uid where a.id != 1 and ischeck='1'");

		//包含添加流程页面
		include_once('template/access_add.php');
	}





	?>