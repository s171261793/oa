<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script type="text/javascript"> 
function show_number()
{
   mytop=(screen.availHeight-600)/2;
   myleft=(screen.availWidth-1002)/2;
   window.open("admin.php?ac=<?php echo str_replace("crm_","",$_GET['modid']);?>&fileurl=<?php echo $fileurl?>&do=view&id=<?php echo $_GET['viewid'];?>","","height=600,width=1002,status=0,toolbar=no,menubar=no,location=no,scrollbars=yes,top="+mytop+",left="+myleft+",resizable=yes");
}
</script>
<title>Office 515158 2011 OA办公系统</title>
 
</head>
<body class="bodycolor">
<table width="70%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> <?php echo $row['title']?></span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right; margin-right:20px;">
	<a href="admin.php?ac=<?php echo str_replace("crm_","",$_GET['modid']);?>&fileurl=<?php echo $fileurl?>&type=1" style="font-size:12px;"><< 返回审批列表</a>&nbsp;|&nbsp;<a href="javascript:;" onClick="show_number()">
      <font color="red">查看流程内容</font>
</a></span>
    </td>
  </tr>
</table>

<script Language="JavaScript"> 
function CheckForm()
{
   if(document.save.content.value=="")
   { alert("批示意见不能为空！");
     document.save.content.focus();
     return (false);
   }
   <?php if($wherestr){?>
   if(document.save.staff.value=="")
   { alert("下一步审批人员不能为空！");
     document.save.staff.focus();
     return (false);
   }
   <?php }?>
   return true;
}
function sendForm()
{
   if(CheckForm())
      document.save.submit();
}
</script>
	<form name="save" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
	<input type="hidden" name="view" value="edit" />
	<input type="hidden" name="viewid" value="<?php echo $row['id']?>" />
	<input type="hidden" name="modid" value="<?php echo $_GET['modid']?>" />
	<input type="hidden" name="oldappkey" value="<?php echo $per['appkey']?>" />
	<input type="hidden" name="oldappkey1" value="<?php echo $per['appkey1']?>" />
	<input type="hidden" name="perid" value="<?php echo $per['perid']?>" />
	<input type="hidden" name="oldappflow" value="<?php echo $per['flowid']?>" />
<table class="TableBlock" border="0" width="70%" align="center">
	<tr>
      <td nowrap class="TableHeader" colspan="2"><b>&nbsp;审批操作</b></td>
    </tr>
	
	<?php
		echo '<tr>';
		echo '<td nowrap class="TableContent"> 批示意见：</td>';
		echo '<td class="TableData"><textarea name="content" cols="60" rows="3">';
		echo '</textarea></td></tr>';
		echo '<tr><td nowrap class="TableContent"> 操作类型：</td><td class="TableData">';
		echo '<input name="pkey" type="radio" style="border:0;" value="1" checked/>通过';
		echo '<input name="pkey" type="radio" style="border:0;" value="2" />拒绝';
		if($per['flowkey']==3){
			echo '<input name="pkey" type="radio" style="border:0;" value="3" />退回';
		}
		/*保留模块
		if($per['flowmovement']==6){
			echo '<input type="hidden" name="disnode" value="1" />';
			echo '<tr>';
			echo '<td nowrap class="TableContent"> 指定阅读人员：</td>';
			echo '<td class="TableData">';
			get_pubuser(2,"distribution","0","+选择阅读人员",40,4);
			echo '<br>';
			echo '注：为空表示所有人员可阅读';
			echo '</td></tr>';
		}*/
		if($wherestr){
			echo '<tr><td nowrap class="TableHeader"> 下一步审批流程：</td>';
			echo '<td class="TableData">';
			//设定下一步审批信息
			echo '<input type="hidden" name="flowid" value="'.$flow['fid'].'" />';
			echo '<input type="hidden" name="appkey" value="'.$flow['flowkey2'].'" />';
			echo '<input type="hidden" name="appkey1" value="'.$flow['flowkey3'].'" />';
			if($flow['flowkey2']=='2'){
			  //单人审批
				  if($flow['flowkey1']=='1'){//可选
					  get_pubuser(1,"staff",'',"+选择审批人员",120,20);
				  }else{//不可选
				  
					  get_pubuser(1,"staff",'',"+选择审批人员",120,20,$flow['flowuser']);
				  }
			  }else{
			  //多人审批
				  if($flow['flowkey1']=='1'){//可选
					  get_pubuser(2,"staff",$flow['flowuser'],"+选择审批人员",40,4);
				  }else{
					  //不可选
					  echo "<textarea name='staff' cols='40' rows='4'";
					  echo " readonly style='background-color:#F5F5F5;color:#006600;'>";
					  echo $flow['flowuser']."</textarea>";
					  echo "<input type='hidden' name='staffid' value='".get_realid($flow['flowuser'])."' />";
				  }
			  }
			  echo '<br>';
			  echo get_smsbox("审批人员","shownamemaster").'</td></tr>';
		  }
	
	?>
	
	
	
	<tr align="center" class="TableControl">
      <td colspan="2" nowrap height="35">
<input type="button" name="Submit" value="提交审批" class="BigButtonBHover" onclick="sendForm();"> 	  </td>
    </tr>
</table>

</form>

</body>
</html>
