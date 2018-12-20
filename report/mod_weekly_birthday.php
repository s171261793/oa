<?php 
	
	//设置默认时区
	date_default_timezone_set('PRC');
	//ÊÇ·ñµÇÂ½Ò³Ãæ
	(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
	empty($do) && $do = 'list';
	if($do == 'list')
	{
		$c = $_GET['c'];
		
		if( $c == 'advance' )
		{
			//本月要过生日的小伙伴
			$sql = "SELECT a.birthday,b.name,a.departmentid FROM ".DB_TABLEPRE."user a,".DB_TABLEPRE."user_view b WHERE  a.id=b.uid  AND Month(a.birthday)=Month(now())";

			//三天之后生日小伙伴
			// $sql = "SELECT a.birthday,b.name,a.departmentid FROM ".DB_TABLEPRE."user a,".DB_TABLEPRE."user_view b WHERE  a.id=b.uid AND Day(a.birthday)<(Day(now())+3) AND Day(a.birthday) >=(Day(now())) AND Month(a.birthday)=Month(now()) ";
		}
		else
		{
			//今天提醒生日
			$sql = "SELECT a.birthday,b.name,a.departmentid FROM ".DB_TABLEPRE."user a,".DB_TABLEPRE."user_view b WHERE a.id = b.uid AND Day(a.birthday)=Day(now()) AND Month(a.birthday)=Month(now())";
		}

		$data_second = $db->fetch_all($sql);


		foreach($data_second  as $key=>$value)
		{								
			preg_match('/\d+/',$value['departmentid'],$departmentid);
			$data_second[$key]['departmentid'] = $departmentid[0];
				
		}

		include_once('template/week_list _birthday.php');

	}
	
		

	

?>