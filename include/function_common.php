<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: fcnction_common.php 1209087 2013-01-30 08:58:28Z baiwei.jiang $
*/
!defined('IN_TOA') && exit('Access Denied!');
function get_login($user){
	if ( !$user ) {
		show_msg('你还没有登录，请先登录', 'login.php', 1000);
	}
}
//读取姓名
function get_realname($id=0){
	if($id!=0){
		global $db;
		$sql = "SELECT name FROM ".DB_TABLEPRE."user_view where uid='".$id."'  ORDER BY uid desc limit 0,1";
		$row = $db->fetch_one_array($sql);
		if($row['name']!=''){
			return $row['name'];
		}
	}
}
//读取用户名及USER表其它名称
function get_realusername($fid=0,$uname=''){
    global $db;
	$sql = "SELECT ".$uname."  FROM ".DB_TABLEPRE."user where id='".$fid."'  ORDER BY id desc limit 0,1";
	$row = $db->fetch_one_array($sql);
	if($row[$uname]!=''){
		return $row[$uname];
	}
	else{
		$sql = "SELECT b.".$uname."  FROM ".DB_TABLEPRE."user a left join ".DB_TABLEPRE."user_view b on a.id=b.uid where id='".$fid."'  ORDER BY id desc limit 0,1";
		$row = $db->fetch_one_array($sql);
		return $row[$uname];
	}
}
//读取id
function get_userid($id=0){
    global $db;
	$sql = "SELECT uid FROM ".DB_TABLEPRE."user_view where name='".$id."' ORDER BY uid desc limit 0,1";
	$row = $db->fetch_one_array($sql);
	if($row['uid']!=''){
		return $row['uid'];
	}
}
//根据姓名获取批量ID
function get_realid($name=''){
	if($name!=''){
		global $db;
		$staff=explode(',',$name);
		for($i=0;$i<sizeof($staff);$i++){
			$sql = "SELECT uid FROM ".DB_TABLEPRE."user_view where name='".trim($staff[$i])."' limit 0,1";
			$row = $db->fetch_one_array($sql);
			if($row['uid']!=''){
				$html.=$row['uid'].',';
			}
		}
	}
	return substr($html, 0, -1);
}
//读取手机
function get_realphone($id=0){
    global $db;
	$sql = "SELECT phone FROM ".DB_TABLEPRE."user_view where name='".$id."' ORDER BY uid desc limit 0,1";
	$row = $db->fetch_one_array($sql);
	if($row['phone']!=''){
		return $row['phone'];
	}
}
$headurl="http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF'];
$pahttp="http://";
//部门
function get_realdepalist($fatherid=0,$selid=0,$layer=0 ){
    $str=""; 
    global $db;
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."department where father='$fatherid'  ORDER BY id Asc");
	if(count($query)>0){
	   for($i=0;$i<$layer;$i++){
		   $str.="├";
	   }
		while ($row = $db->fetch_array($query)) {
			$selstr = $row['id'] == $selid ? 'selected="selected"' : '';
			$htmlstr= '<option value="'.$row['id'].'"  '.$selstr.'>'.$str.$row['name'].'</option>';
			echo $htmlstr;
			get_realdepalist($row['id'],$selid,$layer+1);
		}
	}
    return ;

}
//岗位
function get_postlist($fatherid=0,$selid=0,$layer=0 ){
    $str=""; 
    global $db;
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."position where father='$fatherid' ORDER BY id Asc  ");
	if(count($query)>0){
	   for($i=0;$i<$layer;$i++){
		   $str.="├";
	   }
		while ($row = $db->fetch_array($query)) {
			$selstr = $row['id'] == $selid ? 'selected="selected"' : '';
			$htmlstr= '<option value="'.$row['id'].'"  '.$selstr.'>'.$str.$row['name'].'</option>';
			echo $htmlstr;
			get_postlist($row['id'],$selid,$layer+1);
		}
	}
   return ;
}
//用户组
function get_grouplist($selid = 0) {
	global $db;
	$html = '';
	$sql = "SELECT id,groupname FROM ".DB_TABLEPRE."usergroup";
	$query = $db->query($sql);
	while ($row = $db->fetch_array($query)) {
		$selstr = $row['id'] == $selid ? 'selected="selected"' : '';
		$html .= '<option value="'.$row['id'].'" '.$selstr.' >'.$row['groupname'].'</option>';
	}
	return $html;
}
//输出用户组名称
function get_groupname($id = 0) {
	global $db;
	$sql = "SELECT groupname FROM ".DB_TABLEPRE."usergroup where id=".$id."  ";
	$result = $db->fetch_one_array($sql);
	if($result['groupname']!=''){
		return $result['groupname'];
	}
}
//成员
function get_reallist($selid = 0) {
	global $db;
	$html = '';
	$sql = "SELECT uid,name FROM ".DB_TABLEPRE."user_view  order by uid asc";
	$query = $db->query($sql);
	while ($row = $db->fetch_array($query)) {
		$selstr = $row['uid'] == $selid ? 'selected="selected"' : '';
		$html .= '<option value="'.$row['uid'].'" '.$selstr.' >'.$row['name'].'</option>';
	}
	return $html;
}
//读部门
function get_realdepaname($name=0){
	if($name!=''){
		global $db;
		$staff=explode(',',$name);
		for($i=0;$i<sizeof($staff);$i++){
			$sql = "SELECT name FROM ".DB_TABLEPRE."department where id='".trim($staff[$i])."' limit 0,1";
			$row = $db->fetch_one_array($sql);
			if($row['name']!=''){
				$html.=$row['name'].',';
			}
		}
	}
	return substr($html, 0, -1);
}
//岗位
function get_postname($name=0){
	/*global $db;
	if(trim($id)){
		$sql = "SELECT * FROM ".DB_TABLEPRE."position where id=".$id."";
		if($result = $db->fetch_one_array($sql)){
			return $result['name'];
		}
	}*/
	if($name!=''){
		global $db;
		$staff=explode(',',$name);
		for($i=0;$i<sizeof($staff);$i++){
			$sql = "SELECT name FROM ".DB_TABLEPRE."position where id='".trim($staff[$i])."' limit 0,1";
			$row = $db->fetch_one_array($sql);
			if($row['name']!=''){
				$html.=$row['name'].',';
			}
		}
	}
	return substr($html, 0, -1);
}

//获取岗位代码 传入uid
function get_postcode($uid=0){
	

	if($uid!='')
	{
		global $db;
			
		$sql = "SELECT positionid FROM ".DB_TABLEPRE."user where id=".trim($uid)." limit 0,1";

		$info = $db->fetch_one_array($sql);
		preg_match('/\d+/',$info['positionid'],$departmentid);
		$sql = "SELECT name,code FROM ".DB_TABLEPRE."position where id='".trim($departmentid[0])."' limit 0,1";

		$row = $db->fetch_one_array($sql);
			
	}
	return $row;
}

//显示多级审核人
function get_realname_access($orderid=0){
	global $db;
	$sql = "SELECT user_id,update_time FROM ".DB_TABLEPRE."weekly_flow_course where weekly_id=".trim($orderid)." and status=1";
	$info = $db->fetch_all($sql);
	return $info;
}

//计算分钟
function count_minute($startTime,$endTime)
{
	//转换成时间戳
	$startTime = strtotime($startTime);
	$endTime = strtotime($endTime);
	if( empty($startTime) || empty($endTime) ){ $startTime=0;$endTime=0;}
	$count = round(($endTime-$startTime)/60,2);//计算填写周报用了多长时间（分钟）
	return $count;
}

function get_postid($name=0){
	/*global $db;
	if(trim($id)){
		$sql = "SELECT * FROM ".DB_TABLEPRE."position where id=".$id."";
		if($result = $db->fetch_one_array($sql)){
			return $result['name'];
		}
	}*/
	if($name!=''){
		global $db;
		$staff=explode(',',$name);
		for($i=0;$i<sizeof($staff);$i++){
			$sql = "SELECT id FROM ".DB_TABLEPRE."position where name='".trim($staff[$i])."' limit 0,1";
			$row = $db->fetch_one_array($sql);
			if($row['id']!=''){
				$html.=$row['id'].',';
			}
		}
	}
	//return substr($html, 0, -1);
	return ','.$html;
}
//办公类型(下拉)
function get_typelist($selid = 0,$typeid=0) {
	global $db;
	$html = '';
	$sql = "SELECT oid,oname FROM ".DB_TABLEPRE."office_type where otype=".$typeid."";
	$query = $db->query($sql);
	while ($row = $db->fetch_array($query)) {
		$selstr = $row['oid'] == $selid ? 'selected="selected"' : '';
		$html .= '<option value="'.$row['oid'].'" '.$selstr.' >'.$row['oname'].'</option>';
	}
	return $html;
}
//办公类型(输出)
function get_typename($selid = 0) {
    if($selid==''){
		$oid=0;
	}else{
		$oid=$selid;
	}
	global $db;
	$html = '';
	$sql = "SELECT oid,oname FROM ".DB_TABLEPRE."office_type where oid=".$oid."";
	$query = $db->query($sql);
	while ($row = $db->fetch_array($query)) {
		$html .= ''.$row['oname'].'';
	}
	return $html;
}
//2013版去掉
function get_log($id){
	if($id=='1'){
		$t_id='|515158.com|';
	}else{
		$t_id=str_replace("|515158.com|","<br>",$id);
	}
	return $t_id;
}
//权限
function get_key($inputname){

      if(!is_superadmin() && !check_purview($inputname))
		    {
				// show_msg('对不起，你没有权限执行本操作！', 'home.php');
				show_msg('对不起，你没有权限执行本操作！', 'admin.php?ac=index&fileurl=sms');
			}
		return ;
}
//选项（单/多）；表单名称；默认值；选项名称,宽,高
function get_pubuser($input=0,$inputname=0,$value=0,$name=0,$width=50,$height=4,$user=''){
   
   if($input=='1'){
   echo "<input type='text' name='".$inputname."' style='width:".$width."px;height:".$height."px;background-color:#F5F5F5;color:#006600;' value='".$value."' readonly />";
   echo "<input type='hidden' name='".$inputname."id' value='".get_userid($value)."' />";
   echo "<input type='hidden' name='".$inputname."phone' value='".get_realphone($value)."' />";
   ?>
   <a href="javascript:;" onClick="window.open ('admin.php?ac=user_radio&fileurl=public&inputname=<?php echo $inputname?>&user=<?php echo $user?>', 'newwindow', 'height=500, width=500, top=50, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')"><?php echo $name?></a>
   <?php
   
   }elseif($input=='2'){

   echo "<textarea name='".$inputname."' cols='".$width."' rows='".$height."' readonly style='background-color:#F5F5F5;color:#006600;' id='".$inputname."'>".$value."</textarea>";
   echo "<input type='hidden' name='".$inputname."id' value='".get_realid($value)."' />";
   echo "<input type='hidden' name='".$inputname."phone' /><br>";
   ?>
   <script type="text/javascript"> 
   function show_<?php echo trim($inputname)?>(){
	   <?php if($value!=''){?>
	   window.open ('admin.php?ac=user_checkbox&fileurl=public&inputname=<?php echo $inputname?>&user=<?php echo $value?>', 'newwindow', 'height=500, width=500, top=50, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');
	   <?php }else{?>
	   var uservalue = document.getElementById('<?php echo trim($inputname)?>').value;
	   window.open ('admin.php?ac=user_checkbox&fileurl=public&inputname=<?php echo $inputname?>&user='+uservalue, 'newwindow', 'height=500, width=500, top=50, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');
	   <?php }?>
	}
</script>
   <a href="javascript:;" onClick="show_<?php echo trim($inputname)?>();"><?php echo $name?></a>
   <?php
   }elseif($input=='3'){
   echo "<input type='text' name='".$inputname."' style='width:".$width."px;height:".$height."px;background-color:#F5F5F5;color:#006600;' value='".$value."' readonly />";
   echo "<input type='hidden' name='".$inputname."id' />";
   echo "<input type='hidden' name='".$inputname."phone' />";
   ?>
   <a href="javascript:;" onClick="window.open ('admin.php?ac=user_checkbox&fileurl=public&inputname=<?php echo $inputname?>', 'newwindow', 'height=500, width=500, top=50, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')"><?php echo $name?></a>
   <?php
   }
   return ;
}
//列表选择按钮权限
//名称；值；条件1；条件2；
function get_boxlistkey($name=0,$value=0,$user1=0,$user2=0){
	echo '<input type="checkbox" name="';
	echo $name.'" value="'.$value.'" class="checkbox"';
		if(!is_superadmin() && $user1!=$user2)
		{
			echo 'disabled="disabled"';
		}
	echo ' />';
}
//
function get_helps(){
	echo '<font color="#FF0000" title="打*号表示为必填">(*)</font>';
}
//URL权限
//标题；URL；条件1；条件2；
function get_urlkey($name=0,$url,$user1=0,$user2=0){
	if(!is_superadmin() && $user1){
		echo '<font color=#cccccc>'.$name.'</font>';
	}else{
		echo '<a href="'.$url.'">'.$name.'</a>';
	}
}
//提示框
function get_smsbox($name=0,$value=0){
	  $_CONFIGs=new config();
	  echo '<b>提醒'.$name.'：</b>';
	  if($_CONFIGs->config_data('configinfo')=='1'){
		  echo '<input type="checkbox" name="sms_info_box_'.$value.'" value="1" checked="checked" />短消息提示';
	  }
	  if($_CONFIGs->config_data('configsms')=='1'){
		  if(check_purview("office_sms")!='0'){
			  echo '<input type="checkbox" name="sms_phone_box_'.$value.'" value="1" />手机短信提示
			   ';
		   }
	   }
}
//部门选择
//选项（单/多）；表单名称；默认值；选项名称,宽,高
function get_depabox($input=0,$inputname=0,$value=0,$name=0,$width=50,$height=4){
   
   if($input=='1'){
   echo "<input type='text' name='".$inputname."' style='width:".$width."px;height:".$height."px;background-color:#F5F5F5;color:#006600;' value='".$value."' readonly />";
   echo "<input type='hidden' name='".$inputname."id' value='".get_realdepaid($value)."' />";
   //echo "<input type='hidden' name='".$inputname."phone' />";
   ?>
   <a href="#" onClick="window.open ('admin.php?ac=dep_radio&fileurl=public&inputname=<?php echo $inputname?>', 'newwindow', 'height=500, width=500, top=50, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')"><?php echo $name?></a>
   <?php
   
   }else{
   echo "<textarea name='".$inputname."' cols='".$width."' rows='".$height."' readonly style='background-color:#F5F5F5;color:#006600;'>".$value."</textarea>";
   echo "<input type='hidden' name='".$inputname."id' value='".get_realdepaid($value)."'/>";
  // echo "<input type='hidden' name='".$inputname."phone' /><br>";
   ?><br>
   <a href="#" onClick="window.open ('admin.php?ac=dep_checkbox&fileurl=public&inputname=<?php echo $inputname?>', 'newwindow', 'height=500, width=500, top=50, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')"><?php echo $name?></a>
   <?php
   }
   return ;
}

//部门选择
//选项（单/多）；表单名称；默认值；选项名称,宽,高
function get_positionbox($input=0,$inputname=0,$value=0,$name=0,$width=50,$height=4){
   
   if($input=='1'){
   echo "<input type='text' name='".$inputname."' style='width:".$width."px;height:".$height."px;background-color:#F5F5F5;color:#006600;' value='".$value."' readonly />";
   echo "<input type='hidden' name='".$inputname."id' value='".get_postid($value)."' />";
   //echo "<input type='hidden' name='".$inputname."phone' />";
   ?>
   <a href="#" onClick="window.open ('admin.php?ac=pos_radio&fileurl=public&inputname=<?php echo $inputname?>', 'newwindow', 'height=500, width=500, top=50, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')"><?php echo $name?></a>
   <?php
   
   }else{
   echo "<textarea name='".$inputname."' cols='".$width."' rows='".$height."' readonly style='background-color:#F5F5F5;color:#006600;'>".$value."</textarea>";
   echo "<input type='hidden' name='".$inputname."id' value='".get_postid($value)."' />";
  // echo "<input type='hidden' name='".$inputname."phone' /><br>";
   ?><br>
   <a href="#" onClick="window.open ('admin.php?ac=pos_checkbox&fileurl=public&inputname=<?php echo $inputname?>', 'newwindow', 'height=500, width=500, top=50, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')"><?php echo $name?></a>
   <?php
   }
   return ;
}
//公共汇总
function public_number($table,$where=''){
	global $db;
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE.$table.$where." ");
	return $num;
}
//公共读取数据
function public_value($name='',$table='config',$where=''){
	if($name!=''){
		global $db;
		$sql = "SELECT ".$name." FROM ".DB_TABLEPRE.$table." where ".$where." limit 0,1";
		$row = $db->fetch_one_array($sql);
		if($row[$name]!=''){
			return $row[$name];
		}
	}
}
//上传
function public_upload($name='',$value='',$w,$h,$title){
	if($w=='' || $w=='0') $w='180';
	if($h=='' || $h=='0') $h='22';
	if($title=='') $title='附件上传';
	$_CONFIGS=new config();
	if($_CONFIGS->config_data('upload')==1){
		$html= '<input type="text" name="'.$name.'" class="BigInput" style="width:'.$w.'px;height:'.$h.'px;line-height:'.$h.'px;font-size:14px;" value="'.$value.'" />';
		$html.= '<a href="#" onClick="';
		$html.= "window.open ('admin.php?ac=uploadflash&fileurl=public&name=".$name."', ";
		$html.= "'newwindow111', 'height=200, width=480, top=0, left=0, toolbar=no, ";
		$html.= "menubar=no, scrollbars=yes, resizable=no,location=no, status=no'";
		$html.= ')">+'.$title.'</a>';
	}else{
		$html= '<input type="text" name="'.$name.'" class="BigInput" style="width:'.$w.'px;height:'.$h.'px;line-height:'.$h.'px;font-size:14px;" value="'.$value.'" />';
		$html.= '<a href="#" onClick="';
		$html.= "window.open ('admin.php?ac=uploadadd&fileurl=public&name=".$name."', ";
		$html.= "'newwindow111', 'height=200, width=480, top=0, left=0, toolbar=no, ";
		$html.= "menubar=no, scrollbars=yes, resizable=no,location=no, status=no'";
		$html.= ')">+'.$title.'</a>';
	}
	echo $html;
}
//当前用户ID获取部门名称
function get_depauseridname($userid=0,$type=0){
	global $db;
	if(trim($userid)){
		$sql = "SELECT departmentid FROM ".DB_TABLEPRE."user where id=".$userid."";
		if($result = $db->fetch_one_array($sql)){
			if($type==1){
				return $result['departmentid'];
			}else{
				return get_realdepaname($result['departmentid']);
			}
		}
	}
}
//获取ID，根据名称部门
function get_realdepaid($name=''){
	/*global $db;
	if(trim($name)){
		$sql = "SELECT id FROM ".DB_TABLEPRE."department where name='".$name."'";
		if($result = $db->fetch_one_array($sql)){
			return $result['id'];
		}
	}*/
	if($name!=''){
		global $db;
		$staff=explode(',',$name);
		for($i=0;$i<sizeof($staff);$i++){
			$sql = "SELECT id FROM ".DB_TABLEPRE."department where name='".trim($staff[$i])."' limit 0,1";
			$row = $db->fetch_one_array($sql);
			if($row['id']!=''){
				$html.=$row['id'].',';
			}
		}
	}
	//return substr($html, 0, -1);
	return ','.$html;
}
//成员检测
function get_usershow($vuidtype='',$url=''){
	global $db;
	global $_USER;
	$sql = "SELECT id,keytypeuser FROM ".DB_TABLEPRE."user where id='".$_USER->id."' and keytype='1' ";
	if($result = $db->fetch_one_array($sql)){
		//return '<img class="v-al-middle" src="template/default/images/2EDkuGH6eXMM.gif" /><a id="J-show-amount" href="'.$url.'" >查看下属成员信息</a>';
		$html.='<style type="text/css"> #attachshow{display:none;}</style><a href="#"';
		$html.='onClick="showMenus(';
		$html.="'attachshow'";
		$html.=')" style="line-height:30px;"><span>查看下属成员信息';
		$html.='<img src="template/default/images/2EC5tZlqdV.gif"';
		$html.=' align="absmiddle"></span></a>';
		$html.='<div class="attach_div" id="attachshow" align="left">';
		$html.='<a href="'.$url.'&vuidtype="><img src="template/default/images/newfolder.gif" ';
		$html.='align="absmiddle" width=16 height=16>只看自己</a>';
		$html.='<a href="'.$url.'&vuidtype=-1"><img src="template/default/images/movetofolder.gif" ';
		$html.='align="absmiddle" width=16 height=16>所有成员</a>';
		$query = $db->query("SELECT a.id,b.name FROM ".DB_TABLEPRE."user a,".DB_TABLEPRE."user_view b where a.id=b.uid and a.id in (".get_realid($result['keytypeuser']).") ORDER BY a.numbers Asc");
		while ($row = $db->fetch_array($query)) {
			$html.='<a href="'.$url.'&vuidtype='.$row['id'].'"><img src="template/default/images/2EDkuGH6eXMM.gif" ';
			$html.='align="absmiddle" width=16 height=16>'.$row['name'].'</a>';
		}
		$html.='</div>';
	}
	return $html;
}
//查看下级成员,老版本方法，2014版本后失效
function get_subordinate($uid=0,$username=''){
	global $db;
	$whsql='ssss';
	$sql = "SELECT keytypeuser FROM ".DB_TABLEPRE."user where id='".$uid."' and keytype='1'";
	if($result = $db->fetch_one_array($sql)){
		$keytypeuser=explode(',',$result['keytypeuser']);
		for($i=0;$i<sizeof($keytypeuser);$i++){
			$whsql .=" or ".$username."=".get_userid($keytypeuser[$i]);
		}
		$sqlstrname=str_replace('ssss or','',$whsql);
		$html=" AND (".str_replace('ssss','',$sqlstrname).")";
	}
	return $html;
}
function get_suborname($uid=0,$username=''){
	global $db;
	$whsql='';
	$sql = "SELECT keytypeuser FROM ".DB_TABLEPRE."user where id='".$uid."' and keytype='1'";
	if($result = $db->fetch_one_array($sql)){
		$keytypeuser=explode(',',$result['keytypeuser']);
		for($i=0;$i<sizeof($keytypeuser);$i++){
			$whsql .=$username."='".trim($keytypeuser[$i])."'"." or ";
		}
		$sqlstrname=substr($whsql, 0, -3);
		$html=" AND (".trim($sqlstrname).")";
	}
	return $html;
}
//新方法，目前适用于CRM
function get_keyuser($ui,$un){
	global $db;
	global $_USER;
	$sql = "SELECT keytypeuser,keytype FROM ".DB_TABLEPRE."user where id='".$_USER->id."' and keytype='1'";
	if($row = $db->fetch_one_array($sql)){
		echo '<input type="hidden" name="un"';
		//echo ' readonly ';
		echo ' value="'.$un.'" onpropertychange="sendForm();" />';
		echo "<input type='hidden' name='ui' value='".$ui."' />";
		echo '<a href="#" onClick="';
		echo "window.open ('admin.php?ac=keyuser&fileurl=public&keytype=".$row['keytype']."&un=".$un."', 't".$_USER->id."', 'height=600, width=500, top=50, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')";
		echo '">+查看下属人员</a>';
	}
}
//excel下载
function get_exceldown($keys,$type=0){
	if(!is_superadmin() && !check_purview($keys)){
	}else{
		if($type==1){
			return '<button type="button" id="query_export" class="btn btn-info" onClick="javascript:document:excel.submit();">导出查询列表</button>';	
		}else{
			return '<a href="javascript:document:excel.submit();" seed="CR-download-top" id="J-download"><img class="v-al-middle" src="template/default/images/2EC5tZlqdV.gif" />下载查询结果</a>';	
		}
	}
}
//载取内容
function get_subcontent($str, $start, $end){
        if ( $start == '' || $end == '' ){
               return;
        }
        $str = explode($start, $str);
        $str = explode($end, $str[1]);
        return $str[0]; 
}

//附件操作
function get_publicfileadd($number,$fileid,$filetype,$officetype,$filename,$fileaddr){
		global $_USER;
  		$fileoffice = array(
			'number' => $number,
			'fileid' => $fileid,
			'filetype' => $filetype,
			'officetype' => $officetype,
			'filename' => $filename,
			'uid' => $_USER->id,
			'date' => get_date('Y-m-d H:i:s',PHP_TIME),
			'fileaddr' => $fileaddr
		);
		insert_db('fileoffice',$fileoffice);
		return ;
}
//LOG日志
function get_logadd($id,$content,$title,$type,$userid){
	if($id!=''){
  		$oalog = array(
		'uid' => $userid,
		'content' => $content,
		'title' => $title,
		'startdate' => get_date('Y-m-d H:i:s',PHP_TIME),
		'contentid' => $id,
		'type' => $type
		);
		insert_db('oalog',$oalog);
	}
	return ;
}
//拼音转换
function Pinyin($_String, $_Code='UTF8'){ //GBK页面可改为gb2312，其他随意填写为UTF8
        $_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha". 
                        "|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|". 
                        "cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er". 
                        "|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui". 
                        "|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang". 
                        "|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang". 
                        "|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue". 
                        "|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne". 
                        "|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen". 
                        "|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang". 
                        "|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|". 
                        "she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|". 
                        "tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu". 
                        "|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you". 
                        "|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|". 
                        "zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo"; 
        $_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990". 
                        "|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725". 
                        "|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263". 
                        "|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003". 
                        "|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697". 
                        "|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211". 
                        "|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922". 
                        "|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468". 
                        "|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664". 
                        "|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407". 
                        "|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959". 
                        "|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652". 
                        "|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369". 
                        "|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128". 
                        "|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914". 
                        "|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645". 
                        "|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149". 
                        "|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087". 
                        "|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658". 
                        "|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340". 
                        "|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888". 
                        "|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585". 
                        "|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847". 
                        "|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055". 
                        "|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780". 
                        "|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274". 
                        "|-10270|-10262|-10260|-10256|-10254"; 
        $_TDataKey   = explode('|', $_DataKey); 
        $_TDataValue = explode('|', $_DataValue);
        $_Data = array_combine($_TDataKey, $_TDataValue);
        arsort($_Data); 
        reset($_Data);
        if($_Code!= 'gb2312') $_String = _U2_Utf8_Gb($_String); 
        $_Res = ''; 
        for($i=0; $i<strlen($_String); $i++) { 
                $_P = ord(substr($_String, $i, 1)); 
                if($_P>160) { 
                        $_Q = ord(substr($_String, ++$i, 1)); $_P = $_P*256 + $_Q - 65536;
                } 
                $_Res .= _Pinyin($_P, $_Data); 
        } 
        return preg_replace("/[^a-z0-9]*/", '', $_Res); 
} 
function _Pinyin($_Num, $_Data){ 
        if($_Num>0 && $_Num<160 ){
                return chr($_Num);
        }elseif($_Num<-20319 || $_Num>-10247){
                return '';
        }else{ 
                foreach($_Data as $k=>$v){ if($v<=$_Num) break; } 
                return $k; 
        } 
}
function _U2_Utf8_Gb($_C){ 
        $_String = ''; 
        if($_C < 0x80){
                $_String .= $_C;
        }elseif($_C < 0x800) { 
                $_String .= chr(0xC0 | $_C>>6); 
                $_String .= chr(0x80 | $_C & 0x3F); 
        }elseif($_C < 0x10000){ 
                $_String .= chr(0xE0 | $_C>>12); 
                $_String .= chr(0x80 | $_C>>6 & 0x3F); 
                $_String .= chr(0x80 | $_C & 0x3F); 
        }elseif($_C < 0x200000) { 
                $_String .= chr(0xF0 | $_C>>18); 
                $_String .= chr(0x80 | $_C>>12 & 0x3F); 
                $_String .= chr(0x80 | $_C>>6 & 0x3F); 
                $_String .= chr(0x80 | $_C & 0x3F); 
        } 
        return iconv('UTF-8', 'GB2312', $_String); 
}
//获取上一月或下一个月
function GetMonth($date,$sign="1"){
			//得到系统的年月
			$tmp_date=date($date);
			//切割出年份
			$tmp_year=substr($tmp_date,0,4);
			//切割出月份
			$tmp_mon =substr($tmp_date,4,2);
			$tmp_nextmonth=mktime(0,0,0,$tmp_mon+1,1,$tmp_year);
			$tmp_forwardmonth=mktime(0,0,0,$tmp_mon-1,1,$tmp_year);
			if($sign==0){
				//得到当前月的下一个月 
				return $fm_next_month=date("Y/m",$tmp_nextmonth);        
			}else{
				//得到当前月的上一个月 
				return $fm_forward_month=date("Y/m",$tmp_forwardmonth);         
			}
}
//解析CSV
function input_csv($handle) {
	$out = array ();
	$n = 0;
	while ($data = fgetcsv_reg($handle, 10000)) {
		$num = count($data);
		for ($i = 0; $i < $num; $i++) {
			$out[$n][$i] = $data[$i];
		}
		$n++;
	} 
	return $out; 
} 

function fgetcsv_reg($handle, $length = null, $d = ',', $e = '"') {
	$d = preg_quote($d);
	$e = preg_quote($e);
	$_line = "";
	$eof=false;
	while ($eof != true) {
		$_line .= (empty ($length) ? fgets($handle) : fgets($handle, $length));
		$itemcnt = preg_match_all('/' . $e . '/', $_line, $dummy);
		if ($itemcnt % 2 == 0)
		$eof = true;
	}
	$_csv_line = preg_replace('/(?: |[ ])?$/', $d, trim($_line));
	$_csv_pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';
	preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
	$_csv_data = $_csv_matches[1];
		for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++) {
		$_csv_data[$_csv_i] = preg_replace('/^' . $e . '(.*)' . $e . '$/s', '$1', $_csv_data[$_csv_i]);
		$_csv_data[$_csv_i] = str_replace($e . $e, $e, $_csv_data[$_csv_i]);
	}
	return empty ($_line) ? false : $_csv_data;
}
function weixin($data=0,$type=0,$value=''){
	if($type==1){
		$url='http://'.TOA_URL.'/API/user.php?u='.trim($value);
		$res = Utility::HttpRequest($url);
		//$res=json_decode($res);
	}else{
		global $_CACHE;
		get_cache('weixin_config');
		foreach ( $_CACHE['weixin_config'] as $row) {
			if($row['name']==$data){
				$html=$row[value];
			}
		}
	}
	return $html;
		
}
function Access_Token(){
	global $db;
	$assdate=strtotime(get_date('Y-m-d H:i:s',PHP_TIME))-strtotime(weixin('assdate'));
	if($assdate>=7000){
		$url="https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=".weixin('CorpID')."&corpsecret=".weixin('Secret')."";
		$res = Utility::HttpRequest($url);
		$res=json_decode($res);
		$db->query("UPDATE ".DB_TABLEPRE."weixin_config set value='".$res->access_token."' WHERE name = 'Access_Token'");
		$db->query("UPDATE ".DB_TABLEPRE."weixin_config set value='".get_date('Y-m-d H:i:s',PHP_TIME)."' WHERE name = 'assdate'");
		oa_mana_recache('weixin_config','name','id');
	}
	return weixin('Access_Token');
}
function weixin_code($code='',$state=''){
	global $db;
	if($code!=''){
		setcookie("UID",'', time()-3600);
		$token=Access_Token();
		$urllist="https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token=".$token."&code=".$code."&agentid=".weixin('AppID')."";
		$res = Utility::HttpRequest($urllist);
		$res=json_decode($res);
		$filenumber=random(16,'A1B2C3D4E5F6G7H8I9J1K2L3M4N5O6P7Q8R9S1T2U3V4W5X6Y7Z8');
		//$db->query("UPDATE ".DB_TABLEPRE."weixin_member set appcode='".$filenumber."' WHERE userid = '".$res->UserId."'");
		$row = $db->fetch_one_array("SELECT userid FROM ".DB_TABLEPRE."weixin_member WHERE userid = '".$res->UserId."' and enable=1");
		if (trim($row['userid'])!='') {
			//$value=$res->UserId."s".trim($row['appcode']);
			setcookie("UserId",$res->UserId, time()+3600*10);
			return $res->UserId;
		}
		
	}
}
function weixinsms($person=0,$content){
	global $db;
	global $_USER;
	if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'toa_weixin_config'"))==1){
		//获取数据，判断在线的不发，没有关注的不发送
		if($person=='0'){
			$sql = "SELECT a.userid,a.department FROM ".DB_TABLEPRE."weixin_member a,".DB_TABLEPRE."user b where a.userid=b.id and b.online=0";
		}else{
			$sql = "SELECT a.userid,a.department FROM ".DB_TABLEPRE."weixin_member a,".DB_TABLEPRE."user b where a.userid=b.id and b.online=0 and a.userid in(".get_realid($person).")";
		}
		$query = $db->query($sql);
		$department='';
		$userid='';
		while ($row = $db->fetch_array($query)) {
			$department.=$row['department'].'|';
			$userid.=$row['userid'].'|';
		}
		//'.substr($department, 0, -1).'
		if(substr($userid, 0, -1)!=''){
			$token=Access_Token();
			$url="https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=".$token."";
			$html='{
			   "touser": "'.substr($userid, 0, -1).'",
			   "toparty": "",
			   "totag": "",
			   "msgtype": "text",
			   "agentid": "'.weixin('AppID').'",
			   "text": {
				   "content": "'.$content.'"
			   },
			   "safe":"0"
			}';
			Utility::POST($url,$html);
		}
	}
	return;
}
?>