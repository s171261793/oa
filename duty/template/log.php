<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="template/default/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="template/default/content/js/common.js"></script>
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script type="text/javascript"> 
function sendForm()
{
   document.save.submit();
}
</script>
<title>Office 515158 2011 OA办公系统</title>
</head>
<body class="bodycolor">



<table width="80%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big" style="font-size:12px;"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> <?php echo $duty['title']?>&nbsp;&nbsp;&nbsp;任务进度管理</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right; margin-right:50px;">
	<?php if($duty['dkey']=='1'){?>
	<input type="button" value="录入进度" class="BigButtonBHover" onClick="javascript:window.location='admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=add&did=<?php echo $_GET['did'];?>'"><?php }?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin.php?ac=duty&fileurl=<?php echo $fileurl?>" style="font-size:12px;"><<返回列表页</a>
	</span>
    </td>
  </tr>
</table>


<?php
foreach ($result as $row) {
?>
<table class="TableBlock" border="0" width="80%" align="center" style="border-bottom:#4686c6 solid 0px;margin-top:10px;">
<tr>
      <td nowrap class="TableHeader" width="15%">发布人：</td>
      <td class="TableData"><?php echo get_realname($row['uid'])?></td>
      <td class="TableHeader">发布时间：</td>
      <td class="TableData"><?php echo $row['date'];?></td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 完成进度：</td>
      <td class="TableData"><?php echo $row['progress'];?>%</td>
      <td class="TableContent">附件：</td>
      <td class="TableData"><? if($row['appendix']!=''){?>
<a href="down.php?urls=<?php echo $row['appendix']?>">下载附件</a>
<? }else{?>
无附件
<? }?></td>
    </tr>
	
	
	


	<tr>
      <td nowrap class="TableContent" width="15%"> 备注：</td>
      <td colspan="3" class="TableData">
      <?php echo $row['note'];?></td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 完成内容：</td>
      <td colspan="3" class="TableData">
      <?php echo $row['content'];?></td>
    </tr>
	</table>
	
<?php } ?>	
<table width="80%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big" style="font-size:12px;"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 我的任务描述</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	
    </td>
  </tr>
</table>
<table class="TableBlock" border="0" width="80%" align="center" style="border-bottom:#4686c6 solid 0px;margin-bottom:20px;">
<tr>
      <td nowrap class="TableContent" width="15%"> 任务周期：</td>
      <td colspan="3" class="TableData">
      <?php echo $uid['startdate'];?>到<?php echo $uid['enddate'];?></td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 附件：</td>
      <td colspan="3" class="TableData">
      <? if($uid['appendix']!=''){?>
<a href="down.php?urls=<?php echo $uid['appendix']?>">下载附件</a>
<? }else{?>
无附件
<? }?></td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 备注：</td>
      <td colspan="3" class="TableData">
      <?php echo $uid['note'];?></td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 完成内容：</td>
      <td colspan="3" class="TableData">
      <?php echo $uid['content'];?></td>
    </tr>
	</table>
</body>
</html>
