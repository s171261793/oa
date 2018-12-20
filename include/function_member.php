<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: function_member.php 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/
!defined('IN_TOA') && exit('Access Denied!');
function get_oalog_type($type){
	switch ($type)
	{
		case 1:
		  echo "系统设置";
		  break;
		case 2:
		  echo "权限组设置";
		  break;
		case 3:
		  echo "用户帐号";
		  break;
		case 4:
		  echo "短消息";
		  break;
		case 5:
		  echo "电子邮件";
		  break;
		case 6:
		  echo "手机短信";
		  break;
		case 7:
		  echo "个人考勤";
		  break;
		case 8:
		  echo "个人假条";
		  break;
		case 9:
		  echo "通讯录";
		  break;
		case 10:
		  echo "工作日程";
		  break;
		case 11:
		  echo "工作日记";
		  break;
		case 12:
		  echo "工作计划";
		  break;
		case 13:
		  echo "新闻";
		  break;
		case 14:
		  echo "发文";
		  break;
		case 15:
		  echo "收文";
		  break;
		case 16:
		  echo "传真";
		  break;
		case 17:
		  echo "知识";
		  break;
		case 18:
		  echo "部门";
		  break;
		case 19:
		  echo "会议";
		  break;
		case 20:
		  echo "档案";
		  break;
		case 21:
		  echo "收藏";
		  break;
		case 22:
		  echo "图书";
		  break;
		case 23:
		  echo "办公用品";
		  break;
		case 24:
		  echo "固定资产";
		  break;
		case 25:
		  echo "岗位";
		  break;
		case 26:
		  echo "人事合同";
		  break;
		case 27:
		  echo "招聘管理";
		  break;
		case 28:
		  echo "培训计划";
		  break;
		case 29:
		  echo "奖惩记录";
		  break;
		case 30:
		  echo "论坛";
		  break;
		case 31:
		  echo "投票";
		  break;
		case 32:
		  echo "项目管理";
		  break;
		case 33:
		  echo "任务管理";
		  break;
		case 34:
		  echo "文档管理";
		  break;
		case 35:
		  echo "工作流";
		  break;
		default:
		  echo "错误类型";
	}
	return ;
}
//menu
function get_menu_list($fatherid=0,$selid=0,$layer=0,$ac,$fileurl,$homemana){
    global $db;
	$sql="SELECT * FROM ".DB_TABLEPRE."menu where fatherid='$fatherid' and menutype!='1' ORDER BY menunum Asc";
	$query = $db->query($sql);
	echo '<tbody id="group_'.trim($fatherid).'">';
	if(count($query)>0){
		while ($row = $db->fetch_array($query)) {
			$rsfno = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."menu where fatherid='".$row[menuid]."' ORDER BY menunum asc");
			global $_USER;
			$rsuser = $db->fetch_one_array("SELECT uid FROM ".DB_TABLEPRE."user_view where  uid='".$_USER->id."' and homemana like '%".$row[menuid].",%' limit 0,1");
			echo '<tr class="hover">';
			echo '<td class="td25"></td>';
			echo '<td class="td25">';
			if($row['menutype']==2){
				echo '<input type="checkbox" name="id[]" value="'.trim($row[menuid]).'" style="border:0px;" ';
				if(trim($rsuser['uid'])!=''){
					echo 'checked="checked"';
				}
				echo '/>';
			}
			echo '</td>';
			echo '<td><div class="board">'.trim($row[menuname]).'</div></td></tr>';
	
			if($rsfno[menuid]!=''){
				get_menu_list_view($row['menuid'],$selid,$layer+1,$ac,$fileurl,$homemana);
			}
		}
	}
   echo '</tbody>';
   return ;

}

function get_menu_list_view($fatherid=0,$selid=0,$layer=0,$ac,$fileurl,$homemana){
    global $db;
	$sql="SELECT * FROM ".DB_TABLEPRE."menu where fatherid='$fatherid' and menutype=2 ORDER BY menunum Asc";
	$query = $db->query($sql);
	if(count($query)>0){
		while ($row = $db->fetch_array($query)) {
			global $_USER;
			$rsuser = $db->fetch_one_array("SELECT uid FROM ".DB_TABLEPRE."user_view where  uid='".$_USER->id."' and homemana like '%".$row[menuid].",%' limit 0,1");
			echo'<tr class="hover"><td class="td25"></td>';
			echo'<td class="td25">';
			echo '<input type="checkbox" name="id[]" value="'.trim($row[menuid]).'" style="border:0px;" ';
			if(trim($rsuser['uid'])!=''){
				echo 'checked="checked"';
			}
			echo '/></td>';
			echo'<td><div id="cb_'.trim($row[menuid]).'" class="childboard">';
			echo''.trim($row[menuname]).'</div></td></tr>';
			
		}
	}
   return ;

}
?>