<html>
<head>
<title>信息添加编辑</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script src="template/default/tree/js/admincp.js?SES" type="text/javascript"></script>
<script src="template/default/js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script charset="utf-8" src="eweb/kindeditor.js"></script>

</head>
<body class="bodycolor">
<table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 邮件类别管理</span>&nbsp;&nbsp;&nbsp;&nbsp;
	
    </td>
  </tr>
</table>
<script Language="JavaScript"> 
function sendForm()
{
   document.save.submit();
}
</script>

<form name="save" method="post" action="?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
	<input type="hidden" name="view" value="save" />
	<input type="hidden" name="id" value="<?php echo $row['id']?>" />
	 <table  width="600" style="border:#4686c6 solid 1px;" align="center">	
		<tr>
		  <td align="center" class="TableData">
	<script>
        KE.show({
                id : 'content'
        });
</script>
				<textarea name="content" rows="5" cols="60" style="width:600px;height:300px;"><?php echo $row['content']?></textarea>
		 
		  
	      </td>	  	
		</tr>


		<tr align="center" class="TableControl">
			<td colspan="5" nowrap>
			<input type="button" value="保存" class="BigButtonBHover" onClick="sendForm();">&nbsp;	    </td>
	  </tr>
	 </table>
  
</form>

 
</body>

</html>






















