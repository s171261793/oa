<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<title>信息添加编辑</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script src="template/default/tree/js/admincp.js?SES" type="text/javascript"></script>
<script charset="utf-8" src="eweb/kindeditor.js"></script>
<script type="text/javascript"> 

</script>
</head>
<body class="bodycolor">
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="small" style='margin-top:30px;'>
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> <?php echo GET_INC_TRAINING_RECOR_NAME($blog['trainingid'])?>&nbsp;&nbsp;<?php echo $_title['name']?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
	<span style="font-size:12px; float:right;margin-right:20px;">
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&id=<?php echo $_GET['rid']?>" style="font-size:12px;"><<返回列表页</a></span>
    </td>
  </tr>
</table>

<form name="save" method="post" action="?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=views">
<table class="TableBlock" border="0" width="90%" align="center" style="border-bottom:#4686c6 solid 0px;">
		<tr>
			<td nowrap class="TableContent" width="90">受培训人员：</td>
			  <td class="TableData">
					<?php echo $blog['user']?>				</td>  	  	
		</tr>
		<tr>
			<td nowrap class="TableContent" width="90">培训计划名称：</td>
			  <td class="TableData">
					<?php echo GET_INC_TRAINING_RECOR_NAME($blog['trainingid'])?>				</td>  	  	
		</tr>
		
		<tr>
      <td nowrap class="TableContent"> 培训费用：</td>
      <td class="TableData"><?php echo $blog['price']?>     </td>
    </tr>
	<tr>
      <td valign="top" nowrap class="TableContent"> 培训机构：</td>
      <td class="TableData"><?php echo $blog['organization']?></td>
    </tr>
	<tr>
      <td valign="top" nowrap class="TableContent"> 培训时间：</td>
      <td class="TableData"><?php echo $blog['training']?></td>
    </tr>
	</table>	
	

  
</form>

 
</body>
</html>
