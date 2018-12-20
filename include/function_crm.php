<?php
!defined('IN_TOA') && exit('Access Denied!');
//获取工作流数据
function crm_db($id=0,$name='',$type=''){
	global $db;
	$row = $db->fetch_one_array("SELECT content,formid FROM ".DB_TABLEPRE."crm_db where viewid='".$id."' and inputname='".$name."' and type='".$type."' ORDER BY did Asc");
	if($row['content']!=''){
		return $row['content'];
	}else{
		return ;
	}
}
//单选
function crm_radio($name='',$radiovalue='',$value=''){
		$inputvaluenum=explode('|',$radiovalue); 
		for($i=0;$i<sizeof($inputvaluenum);$i++){
			$html.= '<input name="'.$name.'" type="radio" value="'.$inputvaluenum[$i].'" ';
			if($value==''){
				if($i=='0'){
					$html.= 'checked="checked"';
				}
			}else{
				if($value==$inputvaluenum[$i]){
					$html.= 'checked="checked"';
				}
			}
			$html.= '/>'.$inputvaluenum[$i].'';
		}
	return $html;
}
//多选
function crm_checkbox($name='',$radiovalue='',$value=''){
		$inputvaluenum=explode('|',$radiovalue); 
		for($i=0;$i<sizeof($inputvaluenum);$i++){
			$html.= '<input name="'.$name.'[]" type="checkbox" value="'.$inputvaluenum[$i].'" ';
			if($value==''){
				if($i=='0'){
					$html.= 'checked="checked"';
				}
			}else{
				if(sizeof(explode($inputvaluenum[$i],$value))>1){
					$html.= 'checked="checked"';
				}
			}
			$html.= '/>'.$inputvaluenum[$i].'';
		}
	return $html;
}
//日期
function crm_date($name='',$w,$h,$value){
	if($w=='' || $w=='0') $w='180';
	if($h=='' || $h=='0') $h='22';
	if($value=='') $value=get_date('Y-m-d',PHP_TIME);
	return '<input size="10" style="width:'.$w.'px;height:'.$h.'px;line-height:'.$h.'px;font-size:14px;" type="text" value="'.$value.'" name="'.$name.'" onClick="WdatePicker();" />';
}

//文本域
function crm_input($name='',$value='',$w,$h){
	if($w=='' || $w=='0') $w='260';
	if($h=='' || $h=='0') $h='22';
	return '<input type="text" name="'.$name.'" style="width:'.$w.'px;height:'.$h.'px;line-height:'.$h.'px;font-size:14px;" value="'.$value.'" />';
}
//下拉框
function crm_select($name='',$radiovalue='',$value='',$w,$h){
	if($w=='' || $w=='0') $w='260';
	if($h=='' || $h=='0') $h='22';
	$inputvaluenum=explode('|',$radiovalue); 
	$html.='<select name="'.$name.'" id="'.$name.'" style="width:'.$w.'px;height:'.$h.'px;line-height:'.$h.'px;font-size:14px;">';
	$html.='<option value="" selected="selected">选择内容</option>';
	for($i=0;$i<sizeof($inputvaluenum);$i++){
		$html.='<option value="'.$inputvaluenum[$i].'"';
		if(trim($value)==trim($inputvaluenum[$i])){
			$html.='selected="selected"';
		}
		$html.='>'.$inputvaluenum[$i].'</option>';	
	}
	$html.='</select> ';
	return $html;
}
//文本框
function crm_textarea($name='',$value='',$w,$h){
	if($w=='' || $w=='0') $w='600';
	if($h=='' || $h=='0') $h='200';
	$_CONFIG=new config();
	if($_CONFIG->config_data('configwork')=='1'){
		$html.="<script>
						KE.show({
								id : '".$name."'
						});
				</script>";
	}
	$html.= '<textarea name="'.$name.'" style="width:'.$w.'px;height:'.$h.'px;" class="BigInput">'.$value.'</textarea>';
	return $html;
}
function crm_log($title,$viewid,$content1,$content2,$type,$mod){
	global $db;
	global $_USER;
	if($viewid!=''){
  		$crm_log = array(
			'viewid' => $viewid,
			'title' => $title,
			'uid' => $_USER->id,
			'content1' => $content1,
			'content2' => $content2,
			'date' => get_date('Y-m-d H:i:s',PHP_TIME),
			'type' => $type,
			'modid' => $mod
			);
		insert_db('crm_log',$crm_log);
	}
	return ;
}
//选择框
function crm_title($title,$name='',$id='',$modid='',$type,$vid,$vname){
	echo '<input type="text" name="'.$name.'" style="width:300px;"';
	if($type==1){
		echo ' readonly ';
	}
	echo ' class="BigInput" value="'.$vname.'" />';
	echo "<input type='hidden' name='".$id."' value='".$vid."' /><br>";
	echo '<a href="#" onClick="';
	echo "window.open ('admin.php?ac=public&fileurl=crm&name=".$name."&id=".$id."&modid=".$modid."', '".$modid."', 'height=600, width=600, top=50, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')";
	echo '">+'.$title.'</a>';
}
//流程判断
function crm_flow($modid=''){
	global $db;
	$flow = $db->fetch_one_array("SELECT fid FROM ".DB_TABLEPRE."crm_flow  WHERE modid = '".$modid."' and flownum>1");
	if($flow['fid']==''){
		return 0;
	}else{
		return 1;
	}
}
//流程查看
function crm_flow_view($id=0,$modid=''){
	global $db;
	$html.='<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" class="small" style="margin-top:10px;">
	  <tr>
		<td class="Big" style="font-size:12px;"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3">流程办理进度</span>
		</td>
	  </tr>
	</table>
	<table class="TableBlock" border="0" width="95%" align="center" >';
	$sql = "SELECT * FROM ".DB_TABLEPRE."crm_personnel where viewid='".$id."' and modid = '".$modid."'  order by perid asc";
	$result = $db->fetch_all($sql);
	$i=0;
	foreach ($result as $rows) {
	$sql = "SELECT * FROM ".DB_TABLEPRE."crm_flow  WHERE fid = '".$rows['flowid']."' and modid = '".$modid."'";
	$flow = $db->fetch_one_array($sql);
	$i++;
		$html.='<tr>
		  <td nowrap class="TableHeader" width="130">
		  第<b style="font-size:16px;">'.$i.'</b>步:'.$flow['flowname'].'</td>
		  <td class="TableContent"><b>审批人员：</b>'.$rows['name'];
		  if($rows['pertype']==0){
			  $html.= '<font color=red>[等待审批中]</font>';
		  }
		  $html.='</td>
		</tr>';
		if($flow['flownum']==1){
		$html.='<tr>
		  <td nowrap class="TableContent" align="right" width="130">
		  <span style="font-size:16px;">'.$rows['name'].'</span></td>
		  <td class="TableData">
		  <b>日期：</b>'.$rows['approvaldate'].'<br>
		  <b>状态：</b>'.crm_pertype($rows['pertype']).'<br>
		  <b>批示：</b>'.$rows['lnstructions'].'<br></td>
		</tr>';
		}else{
			if($rows['pertype']!=0){
				if($rows['appkey']==2){
			$html.='<tr>
			  <td nowrap class="TableContent" align="right" width="130">
			  <span style="font-size:16px;">'.$rows['name'].'</span></td>
			  <td class="TableData">
			  <b>日期：</b>'.$rows['approvaldate'].'<br>
			  <b>状态：</b>'.crm_pertype($rows['pertype']).'<br>
			  <b>批示：</b>'.$rows['lnstructions'].'<br></td>
			</tr>';
			}else{
				$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_personnel_log where perid='".$rows['perid']."' and modid = '".$modid."' ORDER BY lid Asc");
				while ($log = $db->fetch_array($query)) {
			$html.='<tr>
			  <td nowrap class="TableContent" align="right" width="130">
			  <span style="font-size:16px;">'.$log['name'].'</span></td>
			  <td class="TableData">
			  <b>日期：</b>'.$log['approvaldate'].'<br>
			  <b>状态：</b>'.crm_pertype_log($log['pertype']).'<br>
			  <b>批示：</b>'.$log['lnstructions'].'<br></td>
			</tr>';
					}
				}
			}
		}
		
	}
	$html.='</table>';
   return $html;
}
//流程添加
function crm_flow_add($modid=''){
	global $db;
	$flow = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."crm_flow  WHERE modid = '".$modid."' and flownum>1");
	echo '<table class="TableBlock" border="0" width="90%" align="center">
	<tr>
		  <td nowrap class="TableHeader" colspan="2"><b>&nbsp;审批人员</b></td>
		</tr>
	   <tr>
		  <td nowrap class="TableContent" width="15%"> 
			设置审批人员：';
			get_helps();
			echo'</td>
		  <td class="TableData">
		  <input type="hidden" name="flowid" value="'.$flow['fid'].'" />
		  <input type="hidden" name="appkey" value="'.$flow['flowkey2'].'" />
		  <input type="hidden" name="appkey1" value="'.$flow['flowkey3'].'" />';
		 if($flow['flowkey2']=='2'){
			 //单人审批
			 if($flow['flowkey1']=='1'){//可选
				 get_pubuser(1,"userkey",'',"+选择审批人员",120,20);
			 }else{
				 get_pubuser(1,"userkey",'',"+选择审批人员",120,20,$flow['flowuser']);
			 }
		 }else{
			 if($flow['flowkey1']=='1'){//可选
				 get_pubuser(2,"userkey",$flow['flowuser'],"+选择审批人员",40,4);
			 }else{
				 echo "<textarea name='userkey' cols='40' rows='4'";
				 echo " readonly style='background-color:#F5F5F5;color:#006600;'>";
				 echo $flow['flowuser']."</textarea>";
				 echo "<input type='hidden' name='userkeyid' value='".get_realid($flow['flowuser'])."' />";
			 }
			
		 }
		echo ' <br>';
		 get_smsbox("审批人员","work");
		 echo '<br>
		 注：流程第一步审批人员，这里选择你的下一级办理人，必需填写！ 
		 </td>
		</tr>
	</table>';
}
function crm_flow1($id,$modid){
	global $db;
	echo '<td align="left" class="TableData">';
	  $sql = "SELECT * FROM ".DB_TABLEPRE."crm_personnel  WHERE viewid = '".$id."'  and (pertype=0 or pertype=2 or pertype=4 or pertype=5) and modid='".$modid."'  order by perid desc";
	  $per = $db->fetch_one_array($sql);
	  $perkey=$per['pertype'];
	  if($per['pertype']==5){
		  echo '<font color=red>流程结束</font>';
	  }elseif($per['pertype']==2){
		  echo '<font color=red>流程被拒绝</font>';
	  }else{
	  	  $sql = "SELECT * FROM ".DB_TABLEPRE."crm_flow  WHERE fid = '".$per['flowid']."' order by fid desc";
		  $flow = $db->fetch_one_array($sql);
		  if($flow['flownum']!=''){
			  echo '<b>第<span style="font-size:18px; font-weight:bold; color:#FF0000;">'.$flow['flownum'].'</span>步：'.$flow['flowname'].'</b><br>';
			  echo '审批人：'.$per['name'];
		  }
	  }
	  echo '</td>';
}
function crm_flow2($id,$modid,$fileurl){
	global $db,$_USER;
	  $sql = "SELECT * FROM ".DB_TABLEPRE."crm_personnel  WHERE viewid = '".$id."'  and (pertype=0 or pertype=2 or pertype=4 or pertype=5) and modid='".$modid."'  order by perid desc";
	  $per = $db->fetch_one_array($sql);
	  $perkey=$per['pertype'];
	  $sql = "SELECT * FROM ".DB_TABLEPRE."crm_personnel where name like '%".get_realname($_USER->id)."%' and (pertype=0 or pertype=4) and modid='".$modid."' and viewid='".$id."'  order by perid desc";
			  $per = $db->fetch_one_array($sql);
			  if($per['perid']!=''){
				  if($per['appkey']==1 && $per['appkey1']==1){
					  $perlnum = $db->result("SELECT COUNT(*) AS perlnum FROM ".DB_TABLEPRE."crm_personnel_log where perid='".$per['perid']."' and uid='".$_USER->id."' and pertype=0");
					  if($perlnum>0){
						  echo '<a href="admin.php?ac=personnel&fileurl='.$fileurl.'&viewid='.$id.'&modid='.$modid.'">审批</a> | ';
					  }
				  }else{
					  echo '<a href="admin.php?ac=personnel&fileurl='.$fileurl.'&viewid='.$id.'&modid='.$modid.'">审批</a> | ';
				  }
			  }
}
function crm_flow_save($modid='',$vid=0,$userkey,$userkeyid,$flowid,$appkey,$appkey1,$sms_info_box_work,$sms_phone_box_work,$userkeyphone){
	global $db,$_USER;
	$sql = "SELECT * FROM ".DB_TABLEPRE."crm_flow  WHERE modid = '".$modid."' and flownum=1 order by fid asc";
		$flow = $db->fetch_one_array($sql);
		$personnel1 = array(
			'name' => get_realname($_USER->id),
			'uid' =>$_USER->id,
			'designationdate' =>get_date('Y-m-d H:i:s',PHP_TIME),
			'approvaldate' =>get_date('Y-m-d H:i:s',PHP_TIME),
			'lnstructions' =>'生成流程申请单，系统自动完成该步骤',
			'pertype' =>1,
			'viewid' => $vid,
			'modid' =>$modid,
			'flowid' => $flow['fid'],
			'appkey' => 2,
			'appkey1' => 2
			);
		insert_db('crm_personnel',$personnel1);
		//写入审批流程
		$personnel2 = array(
			'name' => $userkey,
			'uid' =>$userkeyid,
			'designationdate' =>get_date('Y-m-d H:i:s',PHP_TIME),
			'pertype' =>0,
			'viewid' => $vid,
			'modid' =>$modid,
			'flowid' => $flowid,
			'appkey' => $appkey,
			'appkey1' => $appkey1
			);
		//echo var_dump($personnel2);
		//exit;
		insert_db('crm_personnel',$personnel2);
		$pid=$db->insert_id();
		if($appkey=='1'){
			$userkey=explode(',',$userkey);
			$userkeyid=explode(',',$userkeyid);
			for($i=0;$i<sizeof($userkeyid);$i++){
				$personnel_log = array(
					'name' => $userkey[$i],
					'uid' =>$userkeyid[$i],
					'pertype' =>0,
					'perid' =>$pid,
					'viewid' =>$vid,
					'modid' =>$modid
					);
				insert_db('crm_personnel_log',$personnel_log);
			}
		}
		//提示
		if($sms_info_box_work!=''){
			$content='您有一个新CRM流程需要审批,请点击查看!<a href="admin.php?ac=personnel&fileurl=crm&viewid='.$vid.'&modid='.$modid.'">点击审批>></a>';
			//接收人；内容；类型（1：有返回回值;0：无返回值）;URL
			SMS_ADD_POST($userkey,$content,0,0,$_USER->id);
		}
		//手机短信
		if($sms_phone_box_work!=''){
			$content='您有一个新CRM流程需要审批,请登录OA进行审批!';
			PHONE_ADD_POST($userkeyphone,$content,$userkey,0,0,$_USER->id);
		}
}
function crm_pertype($type){
	switch ($type)
	{
		case 0:
		  return "未审批";
		  break;
		case 1:
		  return "通过";
		  break;
		case 2:
		  return "拒绝";
		  break;
		case 3:
		  return "退回";
		  break;
		case 4:
		  return "等待审批";
		  break;
		case 5:
		  return "结束";
		  break;
		default:
		  return "错误类型";
	}
	return ;
}
function crm_pertype_log($type){
	switch ($type)
	{
		case 0:
		  return "未审批";
		  break;
		case 1:
		  return "通过";
		  break;
		case 2:
		  return "拒绝";
		  break;
		case 3:
		  return "退回";
		  break;
		default:
		  return "错误类型";
	}
	return ;
}
?>