<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script src="template/default/tree/js/admincp.js?SES" type="text/javascript"></script>
<script charset="utf-8" src="eweb/kindeditor.js"></script>

<title>标融办公系统</title>
 
</head>
<body class="bodycolor">
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 周报完成率合格线编辑</span>&nbsp;&nbsp;&nbsp;&nbsp;
  <span style="font-size:12px; float:right;margin-right:20px;">
  
  <!-- <a href="admin.php?ac=receive&fileurl=<?php echo $fileurl?>" style="font-size:12px;"><<返回列表页</a></span> -->
    </td>
  </tr>
</table>
<script Language="JavaScript"> 
function CheckForm()
{
   if(document.save.line_complate.value=="")
   { alert("数字不能为空！");
     document.save.line_complate.focus();
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
<form name="save" method="post" action="">
  <input type="hidden" name="savetype" value="add" />
<table class="TableBlock" border="0" width="90%" align="center" style="border-bottom:#4686c6 solid 0px;">
    <tr>
      <td nowrap class="TableContent" width="15%">完成率：<font color="red">( * 设置周报完成率合格线范围是0到100 )</font></td>
      <td nowrap class="TableContent" width="15%"><input type="text" value="<?=$info['line_complate']?>" name="line_complate"> %</td>
    </tr>
   
 
    <tr align="center" class="TableControl">
      <td colspan="2" nowrap height="35">
     <input type="button" name="Submit" value="设置保存" class="BigButton" onclick="sendForm();">
      </td>
    </tr>
  </table>
</form>
</body>
</html>
