<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: mod_workdate 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
empty($do) && $do = 'list';
get_key("date_workdate");
if ($do == 'list') {
	class Calendar{ 
		var $_table;//table表格 
		var $_currentDate;//当前日期 
		var $_year; //年 
		var $_month; //月 
		var $_days; //给定的月份应有的天数 
		var $_dayofweek;//给定月份的 1号 是星期几 
		/** 
		* 构造函数 
		*/ 
		public function __construct() { 
			$this->_table="";
			$ymc=explode('/',$_GET["ym"]);
			$_GET["y"]=$ymc[0];
			$_GET["m"]=$ymc[1];
			$this->_year = isset($_GET["y"])?$_GET["y"]:date("Y"); 
			if($this->_year==''){
				$this->_year=get_date('Y',PHP_TIME);
			}
			$this->_month = isset($_GET["m"])?$_GET["m"]:date("m"); 
			if ($this->_month>12){//处理出现月份大于12的情况 
				$this->_month=1; 
				$this->_year++; 
			} 
			if ($this->_month<1){//处理出现月份小于1的情况 
				$this->_month=12; 
				$this->_year--; 
			} 
			$this->_currentDate = $this->_year.'年'.$this->_month.'月份';//当前得到的日期信息 
			$this->_days = date("t",mktime(0,0,0,$this->_month,1,$this->_year));//得到给定的月份应有的天数 
			$this->_dayofweek = date("w",mktime(0,0,0,$this->_month,1,$this->_year));//得到给定的月份的 1号 是星期几 
		} 
		/** 
		* 输出标题和表头信息 
		*/ 
		protected function _showTitle() { 
			$this->_table='<table cellspacing="0" cellpadding="0" width="100%" height="38" class="js_tb_head"><tbody><tr class="calendar_th"><th class="weekend">周日</th><th height="38">周一</th><th>周二</th><th>周三</th><th>周四</th><th>周五</th><th class="weekend">周六</th></tr></tbody></table>'; 
			//$this->_table.="<tbody><tr>"; 
			//$this->_table .="<td style='color:red'>星期日</td>"; 
			//$this->_table .="<td>星期一</td>"; 
			//$this->_table .="<td>星期二</td>"; 
			//$this->_table .="<td>星期三</td>"; 
			//$this->_table .="<td>星期四</td>"; 
			//$this->_table .="<td>星期五</td>"; 
			//$this->_table .="<td style='color:red'>星期六</td>"; 
			$this->_table.='<table cellspacing="0" cellpadding="0" width="100%" class="calendar_table"><tbody><tr>'; 
		} 
		/** 
		* 输出日期信息 
		* 根据当前日期输出日期信息 
		*/ 
		protected function _showDate($wheresql) { 
			$nums=$this->_dayofweek+1; 
			for ($i=1;$i<=$this->_dayofweek;$i++){//输出1号之前的空白日期 
				$this->_table.='<td class="table-today"> </td>'; 
			} 
			for ($i=1;$i<=$this->_days;$i++){//输出天数信息
				if($i<10){
					$m='0'.$i;
				}else{
					$m=$i;
				}
				global $db;
				$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."workdate where workdate='".$this->_year."-".$this->_month."-".$m."' ".$wheresql." ORDER BY id desc");
				$this->_table.='<td ';
				if(get_date('Ymd',PHP_TIME)==$this->_year.$this->_month.$m){
					$this->_table.='class="table-drag" ';
				}else{
					$this->_table.='class="table-today" ';
				}
				if($num<1){
					$this->_table.= 'onClick="window.open (';
					$this->_table.= "'admin.php?ac=workdate&fileurl=workbench&do=add&ymd=".$this->_year."-".$this->_month."-".$m."', 'newwindow_".$this->_year.$this->_month.$m."', 'height=550, width=600, top=6, left=200,right=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')";
					$this->_table.= '" ';
				}
				$this->_table.='><dl class="day_box"><dt class="e_clear"><span style="color:#808080;font-size:18px;font-weight: 600;" class="lunar-text">'.$i.'</span>';
				if(get_date('Ymd',PHP_TIME)==$this->_year.$this->_month.$m){
					$this->_table.='<span class="today-text" style="color:#FF0000;">今天</span>';
				}
				$this->_table.='</dt>';
				
				$query = $db->query("SELECT * FROM ".DB_TABLEPRE."workdate where workdate='".$this->_year."-".$this->_month."-".$m."' ".$wheresql." ORDER BY id desc LIMIT 0,5");
				while ($row = $db->fetch_array($query)) {
					$this->_table.='<dd class="task ui-corner-all">';
					$this->_table.='<a href="javascript:;" ';
					$this->_table.= 'onClick="window.open (';
					$this->_table.= "'admin.php?ac=workdate&fileurl=workbench&do=views&id=".$row['id']."', 'newwindow_".$row['id']."', 'height=550, width=600, top=6, left=200,right=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')";
					$this->_table.= '">';
					if($row['otype']==1){
						$this->_table.='全天 '.cut_str($row['content'],14);
					}else{
						$this->_table.=$row['startdate'].' '.cut_str(strip_tags($row['content']),14);
					}
					$this->_table.='</a></dd>';
				}
				if($num>=5){
					$this->_table.='<dd class="task_more">';
					$this->_table.='<a href="javascript:;" ';
					$this->_table.= 'onClick="window.open (';
					$this->_table.= "'admin.php?ac=workdate&fileurl=workbench&do=listviews&ymd=".$this->_year."-".$this->_month."-".$m."', 'newwindow_".$this->_year.$this->_month.$m."', 'height=550, width=700, top=6, left=200,right=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')";
					$this->_table.= '">';
					$this->_table.= '共'.$num.'条,查看更多>></a></dd>';
				}
				$this->_table.='</dl></td>'; 
				if ($nums%7==0){//换行处理：7个一行 
					$this->_table.='</tr><tr>'; 
				} 
				$nums++; 
			} 
			$this->_table.="</tr></tbody></table>";  
		} 
		/** 
		* 输出日历 
		*/ 
		public function showCalendar($wheresql) { 
			$this->_showTitle(); 
			$this->_showDate($wheresql); 
			echo $this->_table; 
		} 
	}
	$wheresql = '';
	if (getGP('type','G')=='1') {
		$wheresql .= " AND uid = ".$_USER->id."";
	}else{
		if(!is_superadmin()){
			$wheresql .= " AND uid = ".$_USER->id."";
		}
	}
	$calc=new Calendar();
	
	
	$ym=$_GET['ym'];
	if($ym==''){
		$ym=get_date('Y/m',PHP_TIME);
	}
	$yms=explode('/',$ym);
	include_once('template/workdatelist.php');

}elseif ($do == 'update') {
	
	get_key("date_workdate_delete");
	//$idarr = getGP('id','P','array');
	$id = getGP('id','G');
	//foreach ($idarr as $id) {
		$db->query("DELETE FROM ".DB_TABLEPRE."workdate WHERE id = '$id'");
		//$db->query("DELETE FROM ".DB_TABLEPRE."bbs_log WHERE bbsid = '$id' and type='8'  ");
	//}
	$content=serialize($idarr);
	$title='删除日程信息';
	get_logadd($id,$content,$title,10,$_USER->id);
	echo "<script>self.opener.location.reload();</script>";
	echo '<script language="JavaScript">window.close()</script>';
	//show_msg('日程信息删除成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');

}elseif ($do == 'listviews') {
	$wheresql = '';
	if(!is_superadmin()){
		$wheresql .= " AND uid = ".$_USER->id."";
	}
	$sql = "SELECT * FROM ".DB_TABLEPRE."workdate where workdate='".$_GET['ymd']."' ".$wheresql." ORDER BY id desc";
	$result = $db->fetch_all($sql);
	include_once('template/workdatelistview.php');

}elseif ($do == 'add') {
	
	if($_POST['view']!=''){
		$id = getGP('id','P','int');
		if($id!=''){
			$otype = check_str(getGP('otype','P'));
			if($otype==''){
				$otype=2;
			}
			$workdate = check_str(getGP('workdate','P'));
			$startdate = getGP('startdate1','P').":".getGP('startdate2','P')."";
			$contents = check_str(getGP('content','P'));
			$workdate = array(
				'otype' => $otype,
				'workdate' => $workdate,
				'startdate' => $startdate,
				'content' => $contents
			);
			update_db('workdate',$workdate, array('id' => $id));
			$content='';
			$content=serialize($workdate);
			$title='编辑日程信息';
			get_logadd($id,$content,$title,10,$_USER->id);
			
		}else{
			$otype = check_str(getGP('otype','P'));
			if($otype==''){
				$otype=2;
			}
			$workdate = check_str(getGP('workdate','P'));
			$startdate = getGP('startdate1','P').":".getGP('startdate2','P')."";
			$contents = check_str(getGP('content','P'));
			$date = get_date('Y-m-d H:i:s',PHP_TIME);
			$uid=$_USER->id;
			$workdate = array(
				'otype' => $otype,
				'workdate' => $workdate,
				'startdate' => $startdate,
				'content' => $contents,
				'date' => $date,
				'uid' => $uid
			);
			insert_db('workdate',$workdate);
			$id=$db->insert_id();
			$content=serialize($workdate);
			$title='新建日程信息';
			get_logadd($id,$content,$title,10,$_USER->id);
		}
		//if(getGP('id','P','int')!=''){
			echo "<script>self.opener.location.reload();</script>";
			echo '<script language="JavaScript">window.close()</script>';
		//}else{
		//	show_msg('日程信息操作成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
		//}
	}else{
		$id = getGP('id','G','int');
		if($id!=''){
			$user = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."workdate  WHERE id = '$id'  ");
			get_key(date_workdate_edit);
			$startdate[0]=$user['workdate'];
			$starttime=explode(':',$user['startdate']);
			$_title['name']='编辑';
		}else{ 
			get_key(date_workdate_Increase);
			if($_GET['ymd']!=''){
				$startdate[0]=$_GET['ymd'];
			}else{
				$startdate=explode(' ',get_date('Y-m-d H:i:s',PHP_TIME));
			}
			$starttime=explode(':',$startdate[1]);
			$_title['name']='发布';
		}
		include_once('template/workdateadd.php');
	}
}elseif ($do == 'views') {
		$id = getGP('id','G','int');
		if($_POST['view']!=''){
			
			$bbsid = getGP('bbsid','P');
			$title = check_str(getGP('title','P'));
			$author = getGP('author','P');
			$content = getGP('content','P');
			$type = getGP('type','P');
			$enddate = get_date('Y-m-d H:i:s',PHP_TIME);
			$uid = $_USER->id;
			//主表信息
			$bbs_log = array(
				'bbsid' => $bbsid,
				'title' => $title,
				'author' => $author,
				'content' => $content,
				'enddate' => $enddate,
				'type'=>8,
				'uid' => $uid
			);
			insert_db('bbs_log',$bbs_log);
			$content=serialize($bbs_log);
			$title='回复信息';
			get_logadd($id,$content,$title,10,$_USER->id);
			show_msg('评论发布成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=views&id='.$bbsid);
		}else{
			if($id!=''){
				$blog = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."workdate  WHERE id = '$id'");
				$_title['name']='信息浏览';
			}
		}
		include_once('template/workdateviews.php');
}elseif ($do == 'excel') {
	$datename="workdate_".get_date('YmdHis',PHP_TIME);
	$outputFileName = 'data/excel/'.$datename.'.xls';
		$content = array();
		$archive=array("事务类型","日期","发布时间","发布人","内容");
		$content[] = $archive;
		$wheresql = '';
		$sql = "SELECT * FROM ".DB_TABLEPRE."workdate WHERE 1 $wheresql   ORDER BY id desc";
		$result = $db->query($sql);
		while ($row = $db->fetch_array($result)) {	
			if($row[otype]=='1'){
				$type='全天';
			}else{
				$type='小时';
			}
			$archive = array(
				"".$type."",
				"".str_replace("-",".",$row[workdate])."",
				"".str_replace("-",".",$row['date'])."",
				"".get_realname($row['uid'])."",
				"".$row['content'].""
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