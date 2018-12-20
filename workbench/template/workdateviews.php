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
<table width="550" border="0" align="center" cellpadding="3" cellspacing="0" class="small" style='margin-top:30px;'>
  <tr>
    <td class="Big" style="vertical-align:middle;"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 日程<?php echo $_title['name']?></span>&nbsp;&nbsp;&nbsp;&nbsp;
	<?php if($blog['uid']==$_USER->id || is_superadmin()){?>
	<span style="font-size:12px; float:right; margin-right:20px;">
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=add&id=<?php echo $blog['id']?>" style="font-size:12px;"><img src="template/default/new/images/todo_edit.png">编辑</a>&nbsp;&nbsp;<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=update&id=<?php echo $blog['id']?>" style="font-size:12px;"><img src="template/default/new/images/todo_del.png">删除</a>
	</span>
	<?php }?>
    </td>
  </tr>
</table>

<form name="save" method="post" action="?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=views">
	<input type="hidden" name="view" value="edit" />
	<input type="hidden" name="bbsid" value="<?php echo $blog['id']?>" />
	<input type="hidden" name="author" value="<?php echo get_realname($_USER->id)?>" />
<table class="TableBlock" border="0" width="550" align="center" style="border-bottom:#4686c6 solid 0px;">
		<tr>
			<td nowrap class="TableContent" width="90">开始时间：</td>
			  <td class="TableData">
			  <?php
			  if($blog['otype']==1){
				  echo '全天&nbsp;&nbsp;'.$blog['workdate'];
			  }else{
			  	  echo $blog['workdate'].'&nbsp;'.$blog['startdate'];
			  }
			  ?>
			  </td>  	  	
		</tr>
		<tr>
      <td nowrap class="TableContent"> 发布人：</td>
      <td class="TableData"><?php echo get_realname($blog['uid'])?>     </td>
		<tr>
			<td nowrap class="TableContent" width="90">发布时间：</td>
			  <td class="TableData">
					<?php echo $blog['date']?></td>  	  	
		</tr>
		<tr>
      <td nowrap class="TableContent"> 内容：</td>
      <td class="TableData"><?php echo $blog['content']?></td>
    </tr>
		
    </tr>
	
	</table>	
</body>
</html>
