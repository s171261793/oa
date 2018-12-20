<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script charset="utf-8" src="eweb/kindeditor.js"></script>
<title>Office 515158 2011 OA办公系统</title>
</head>
<body class="bodycolor">
<table width="80%" border="0" align="center" cellpadding="3" cellspacing="0" class="small" style="margin-top:20px;">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 查看[<?php echo get_realname($row['user'])?>]任务进度</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right; margin-right:20px;">
	
	<a href="admin.php?ac=user&fileurl=<?php echo $fileurl?>&did=<?php echo $duty['id'];?>" style="font-size:12px;"><<返回列表页</a></span>
    </td>
  </tr>
</table>

<table class="TableBlock" border="0" width="80%" align="center" style="border-bottom:#4686c6 solid 0px;">
	<tr>
      <td nowrap class="TableContent" width="15%">完成进度：</td>
      <td class="TableData">
	  <?php
	  $key1 = $db->fetch_one_array("SELECT sum(progress) as progress FROM ".DB_TABLEPRE."duty_log WHERE dutyid='".$duty['id']."' and duid='".$row['id']."' ");
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
	  ?></td>
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

<table width="80%" border="0" align="center" cellpadding="3" cellspacing="0" class="small" style="margin-top:30px;">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> [<?php echo get_realname($row['user'])?>]的任务进度信息</span>
	
    </td>
  </tr>
</table>

<?php
$sql = "SELECT * FROM ".DB_TABLEPRE."duty_log WHERE dutyid='".$duty['id']."' and duid='".$row['id']."' order by id asc";
$result = $db->fetch_all($sql);
foreach ($result as $rows) {
?>
<table class="TableBlock" border="0" width="80%" align="center" style="border-bottom:#4686c6 solid 0px;margin-bottom:20px;">
<tr>
      <td nowrap class="TableHeader" width="15%">发布人：</td>
      <td class="TableData"><?php echo get_realname($rows['uid'])?></td>
      <td class="TableHeader">发布时间：</td>
      <td class="TableData"><?php echo $rows['date'];?></td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 完成进度：</td>
      <td class="TableData"><?php echo $rows['progress'];?>%</td>
      <td class="TableContent">附件：</td>
      <td class="TableData"><? if($rows['appendix']!=''){?>
<a href="down.php?urls=<?php echo $rows['appendix']?>">下载附件</a>
<? }else{?>
无附件
<? }?></td>
    </tr>
	
	
	


	<tr>
      <td nowrap class="TableContent" width="15%"> 备注：</td>
      <td colspan="3" class="TableData">
      <?php echo $rows['note'];?></td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 完成内容：</td>
      <td colspan="3" class="TableData">
      <?php echo $rows['content'];?></td>
    </tr>
	</table>
	
<?php } ?>	

</body>
</html>
