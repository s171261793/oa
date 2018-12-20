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
<table width="70%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 邮箱<?php echo $_title['name']?></span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right;margin-right:20px;">
	
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>" style="font-size:12px;"><<返回列表页</a></span>
    </td>
  </tr>
</table>
<script Language="JavaScript"> 
function CheckForm()
{
   if(document.save.mail.value=="")
   { alert("邮箱不能为空！");
     document.save.mail.focus();
     return (false);
   }
   if(document.save.smtp.value=="")
   { alert("smtp不能为空！");
     document.save.smtp.focus();
     return (false);
   }
   if(document.save.pop3.value=="")
   { alert("pop3不能为空！");
     document.save.pop3.focus();
     return (false);
   }
   if(document.save.username.value=="")
   { alert("用户名不能为空！");
     document.save.username.focus();
     return (false);
   }
   if(document.save.password.value=="")
   { alert("密码不能为空！");
     document.save.password.focus();
     return (false);
   }
   
   return true;
}
function sendForm()
{
   if(CheckForm())
      document.save.submit();
}
</script>

<form name="save" method="post" action="?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=add">
	<input type="hidden" name="view" value="edit" />
	<input type="hidden" name="id" value="<?php echo $user['id']?>" />
	 <table class="TableBlock" border="0" width="70%" align="center" style="border-bottom:#4686c6 solid 0px;">
		<tr>
			<td nowrap class="TableContent" width="90">邮箱：<? get_helps()?></td>
			  <td class="TableData">
					<input type="text" class="BigInput" name="mail" value="<?php echo $user['mail']?>">
					<br>例如:service@515158.com
				</td>  	  	
		</tr>
		<tr>
			<td nowrap class="TableContent" width="90">接收服务器(POP3)：<? get_helps()?></td>
			  <td class="TableData">
					<input type="text" class="BigInput" name="pop3" value="<?php echo $user['pop3']?>">&nbsp;&nbsp;&nbsp;&nbsp;端口:<input type="text" class="BigInput" name="pop3num" value="<?php echo $user['pop3num']?>" style="width:40px;">
				</td>  	  	
		</tr>
		<tr>
			<td nowrap class="TableContent" width="90">发送服务器(SMTP)：<? get_helps()?></td>
			  <td class="TableData">
					<input type="text" class="BigInput" name="smtp" value="<?php echo $user['smtp']?>">&nbsp;&nbsp;&nbsp;&nbsp;端口:<input type="text" class="BigInput" name="smtpnum" value="<?php echo $user['smtpnum']?>" style="width:40px;">
				</td>  	  	
		</tr>
		<tr>
			<td nowrap class="TableContent" width="90">登录帐户：<? get_helps()?></td>
			  <td class="TableData">
					<input type="text" class="BigInput" name="username" value="<?php echo $user['username']?>" >
				</td>  	  	
		</tr>
		<tr>
			<td nowrap class="TableContent" width="90">登录密码：<? get_helps()?></td>
			  <td class="TableData">
					<input type="text" class="BigInput" name="password" value="<?php echo $user['password']?>" >
				</td>  	  	
		</tr>
		
		
		<tr align="center" class="TableControl">
			<td colspan="2" nowrap>
			<input type="button" value="保存" class="BigButtonBHover" onClick="sendForm();">&nbsp;	    </td>
	  </tr>
	 </table>
  
</form>

 
</body>
</html>
