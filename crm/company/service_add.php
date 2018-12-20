<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script src="template/default/tree/js/admincp.js?SES" type="text/javascript"></script>
<script charset="utf-8" src="eweb/kindeditor.js"></script>

<title>Office 515158 2011 OA办公系统</title>
 <script Language="JavaScript"> 
function CheckForm()
{
   if(document.save.title.value=="")
   { alert("客户回访回访主题不能为空！");
     document.save.title.focus();
     return (false);
   }
   if(document.save.cname.value=="")
   { alert("公司信息不能为空！");
     document.save.cname.focus();
     return (false);
   }
   if(document.save.startdate.value=="")
   { alert("指定回访时间不能为空！");
     document.save.startdate.focus();
     return (false);
   }
   if(document.save.user.value=="")
   { alert("回访人员不能为空！");
     document.save.user.focus();
     return (false);
   }
<?
global $db;
$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_service'  ORDER BY inputnumber Asc");
	while ($row = $db->fetch_array($query)) {
		if($row["confirmation"]=='1'){
?>

if(document.save.<?php echo $row["inputname"]?>.value=="")
   { alert("<?php echo $row["formname"]?>不能为空！");
     document.save.<?php echo $row["inputname"]?>.focus();
     return (false);
   }
   
<?php
	}
}
?>
   return true;
}
function sendForm()
{
   if(CheckForm())
      document.save.submit();
}
</script>
</head>
<body class="bodycolor">
<form name="save" method="post" action="?ac=<?php echo $ac;?>&do=add&fileurl=<?php echo $fileurl;?>" style="margin-top:1px; margin-left:0px; margin-right:0px;">
	<input type="hidden" name="view" value="add" />
<div id="navPanel">
<div id="navMenu" style="padding-left:50px;">
<a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>" ><span><img src="template/default/content/images/p3.gif" width="16" height="16" align="absmiddle">客户回访信息</span></a>
<a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=add" class="active"><span><img src="template/default/content/images/p2.gif" width="16" height="16" align="absmiddle">客户回访添加</span></a>
</div>
<div id="search" style="float: right; padding-right:100px;">
	
	<input type="button" value=" 保 存 " class="BigButtonBHover" onClick="sendForm();">


 
</div>
</div>



<div style="position:absolute; height:90%; width:100%;overflow:auto"> 
<table class="TableBlock" border="0" width="90%" align="center" style="margin-top:20px;">
<tr>
      <td nowrap class="TableHeader" colspan="4">基本信息</td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 
        流水号：<? get_helps()?></td>
      <td class="TableData" width="35%"><input name="number" type="text" class="BigInput" id="number" style="width: 200px;" value="T<?php echo get_date('YmdHis',PHP_TIME)?>"/></td>
	  
	  <td class="TableContent" width="15%"> 回访主题：<? get_helps()?></td>
      <td class="TableData" width="35%">
	  <input name="title" type="text" class="BigInput" id="title" style="width: 300px;" value=""/>
       </td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 
        指定回访时间：<? get_helps()?></td>
      <td class="TableData" width="35%"><input name="startdate" type="text" class="BigInput" id="startdate" style="width: 200px;" onClick="WdatePicker();"/></td>
	  
	  <td class="TableContent" width="15%"> 回访客户：<? get_helps()?></td>
      <td class="TableData" width="35%">
	  <input type="text" name="cname" style="width:300px;" readonly  class="BigInput" value="" /><input type='hidden' name='cid' value='' /><br><a href="#" onClick="window.open ('admin.php?ac=public&fileurl=crm&name=cname&id=cid&do=ck', 'crm_company', 'height=600, width=600, top=50, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')">+选择企业</a>	
	  
       </td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 
        指定回访人员：<? get_helps()?></td>
      <td class="TableData" width="35%"><?php echo get_pubuser(1,'user',"","+选择人员",'',22);?></td>
	  
	  <td class="TableContent" width="15%"> </td>
      <td class="TableData" width="35%">
	 
	  
       </td>
    </tr>
	
</table>
<?php
//引入表单
form_add('客户回访信息','crm_service');
//引入编辑器
form_add_eweb('crm_service');
?>

</div> 
</form>

 
</body>
</html>
