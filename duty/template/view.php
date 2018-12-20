<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script charset="utf-8" src="eweb/kindeditor.js"></script>
<title>Office 515158 2011 OA办公系统</title>
</head>
<body class="bodycolor">
<table width="80%" border="0" align="center" cellpadding="3" cellspacing="0" class="small" style="margin-top:20px;margin-bottom:10px;">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 查看[<?php echo trim($row['title'])?>]任务进度</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right; margin-right:20px;">
	
	<a href="admin.php?ac=duty&fileurl=<?php echo $fileurl?>" style="font-size:12px;"><<返回列表页</a></span>
    </td>
  </tr>
</table>

<table class="TableBlock" border="0" width="80%" align="center" style="border-bottom:#4686c6 solid 0px;">
	<tr>
      <td nowrap class="TableContent" width="15%">完成进度：</td>
      <td class="TableData">
	  <?php
	  $nums = $db->result("SELECT COUNT(*) AS nums FROM ".DB_TABLEPRE."duty_user  WHERE dutyid='".$row['id']."'");
	  $key1 = $db->fetch_one_array("SELECT sum(progress) as progress FROM ".DB_TABLEPRE."duty_log WHERE dutyid='".$row['id']."'");
	 // echo $key1["progress"];
	 if($key1["progress"]/$nums<='100'){
		 echo '<div style="width:100%; background-color:#CCCCCC;">';
			 echo '<div style="width:';
			 if($key1["progress"]!=''){
				 echo $key1["progress"]/$nums;
			 }else{
				 echo '1';
			 }
			 echo '%; background-color:#006600;">
			  &nbsp;
			  </div>
		  </div>';
	 }else{
		 echo "任务己完成，但超出来进度！";
	 }
	 $progress=$key1["progress"]/$nums;
	 $progress=explode('.',$progress);
	 if($progress[1]!=''){
		 echo $progress[0].'.'.substr($progress[1], 0, 2)."%";
	 }else{
		 echo $progress[0]."%";
	 }
	  ?></td>
    </tr>

	<tr>
	  <td colspan="2" nowrap class="TableContent">
	  <?php echo renderChartHTML("template/fusioncharts/Column3D.swf", "", $strtype, "","100%", "300", false);?>
	  </td>
  </tr>
	<tr>
      <td nowrap class="TableContent" width="15%">任务周期：</td>
      <td class="TableData"><?php echo $row['startdate'];?>到<?php echo $row['enddate'];?></td>
    </tr>
	
	<tr>
      <td nowrap class="TableContent" width="15%"> 附件文档：</td>
      <td class="TableData">
     <? if($row['appendix']!=''){?>
<a href="down.php?urls=<?php echo $row['appendix']?>">下载附件</a>
<? }else{?>
无附件
<? }?></td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 备注：</td>
      <td class="TableData">
      <?php echo $row['note'];?></td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 任务描述：</td>
      <td class="TableData">
      <?php echo $row['content'];?></td>
    </tr>
</table>
<?php if($row['uid']==$_USER->id){?>
<table width="80%" border="0" align="center" cellpadding="3" cellspacing="0" class="small" style="margin-top:30px;">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> [<?php echo trim($row['title'])?>]执行人信息</span>
	
    </td>
  </tr>
</table>
<table class="TableBlock" border="0" width="80%" align="center" style="margin-bottom:20px;">
	<tr>
     
      <td class="TableHeader" width="150">执行人</td>
	  <td width="150" align="center" class="TableHeader">任务周期</td>
      <td class="TableHeader">进度</td>
      <td width="90" class="TableHeader" align="center">状态</td>
      <td width="100" align="center" class="TableHeader">操作</td>
    </tr>
<?php
$sql = "SELECT * FROM ".DB_TABLEPRE."duty_user WHERE dutyid='".$row['id']."' order by id desc";
$result = $db->fetch_all($sql);
foreach ($result as $user) {
?>
	<tr>
      
 <td class="TableContent"><?php echo get_realname($user['user'])?></td>
	  <td align="center" class="TableData"><?php echo $user['startdate']?>至<?php echo $user['enddate']?></td>
      <td align="left" class="TableData">
	  <?php
	  $key1 = $db->fetch_one_array("SELECT sum(progress) as progress FROM ".DB_TABLEPRE."duty_log WHERE dutyid='".$row['id']."' and duid='".$user['id']."' ");
	 // echo $key1["progress"];
	 if($key1["progress"]<='100'){
		 echo '<div style="width:100%; background-color:#CCCCCC;">';
			 echo '<div style="width:';
			 if($key1["progress"]!=''){
				 echo $key1["progress"];
			 }else{
				 echo '1';
			 }
			 echo '%; background-color:#006600;">
			  &nbsp;
			  </div>
		  </div>';
	 }else{
		 echo "任务己完成，但己超出来完成进度！";
	 }
	 echo $key1["progress"]."%";
	  ?>
	  </td>
      
      <td align="center" class="TableData">
	  <?php if($user['dkey']=='1'){echo "进行中";}elseif($user['dkey']=='2'){echo "<font color=red>未完成</font>";}else{echo "<font color=#006600>己完成</font>";}?>	  </td>
      <td align="center" class="TableData"> 
	   <a href="javascript:;" onClick="window.open ('admin.php?ac=user&do=view&fileurl=<?php echo $fileurl;?>&id=<?php echo $user['id'];?>&did=<?php echo $row['id'];?>', 'newwindow_<?php echo $user['id'];?>', 'height=550, width=900, top=6, right=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')">查看详情</a>
	  </td>
    </tr>
	
<?php } ?>	

  </table>
<?php } ?>		

</body>
</html>
