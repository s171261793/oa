<?php


	/*
	*
	*    自动提示生日
	* 
	 */
	//今天过生日的 select * from toa_user where Day(birthday) = Day(now()) AND Month(birthday) = Month(now())
	global $db;
	$sql1 = "SELECT * FROM ".DB_TABLEPRE."user WHERE Day(birthday)=Day(now()) AND Month(birthday)=Month(now()) AND is_hint='0'";

	//提前3天提醒生日
	$sql2 = "SELECT * FROM ".DB_TABLEPRE."user WHERE (Day(birthday)+5)=(Day(now())+3) AND Month(birthday)=Month(now()) ";

	$rowsFirst  = $db->fetch_all($sql1);
	$rowsSecond = $db->fetch_all($sql2);
	dump($rowsFirst);
	dump($rowsSecond);die;
	
	while (  )
	{
		# code...
		# 发消息操作
		$savetype = 'add';  //添加类型
		$receiveperson = getGP('receiveperson','P'); //发送人员ID
		$content = '今天是您的生日';   //内容
		
		//发送消息表
		$sms_send = array(
			'receiveperson' => $receiveperson,
			'content' => $content,
			'uid' => $_USER->id,
			'date' => get_date('y-m-d H:i:s',PHP_TIME)
		);
		insert_db('sms_send',$sms_send);
		$id=$db->insert_id();
		//获取字符串
		$receivepersonarr=explode(',',$receiveperson); 
		//发送消息表
		
		for($i=0;$i<sizeof($receivepersonarr);$i++)
		{
		//接收消息表
		$sms_receive = array(
			'sendperson' => $_USER->id,
			'date' => get_date('y-m-d H:i:s',PHP_TIME),
			'content' => $content,
			'receiveperson' => get_userid($receivepersonarr[$i]),
			'type' => '2',
			'smskey' => '1',
			'sendid'=>$id
		);
		//接收消息表
		insert_db('sms_receive',$sms_receive);
		}

		// weixinsms($receiveperson,getGP('content','P'));

		//加入日志
		if($id!='')
		{
		   $oalog = array(
				'uid' => 1, //最高权限显示发布的生日信息
				'content' => $content.get_log(1).$receiveperson,
				'title' => '发布短消息',
				'startdate' => get_date('Y-m-d H:i:s',PHP_TIME),
				'contentid' => $id,
				'type' => '4'
		);
		insert_db('oalog',$oalog);
		
		}
		echo 'send success uid=';



	}



	

?>