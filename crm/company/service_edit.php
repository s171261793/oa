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
   { alert("回访主题不能为空！");
     document.save.title.focus();
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
<form name="save" method="post" action="?ac=<?php echo $ac;?>&do=edit&fileurl=<?php echo $fileurl;?>" style="margin-top:1px; margin-left:0px; margin-right:0px;">
	<input type="hidden" name="view" value="add" />
	<input type="hidden" name="id" value="<?php echo $view['id'];?>" />
	<input type="hidden" name="type" value="<?php echo $view['type'];?>" />
<div id="navPanel">
<div id="navMenu" style="padding-left:50px;">
<a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>" ><span><img src="template/default/content/images/p3.gif" width="16" height="16" align="absmiddle">客户回访列表</span></a>
<a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=edit&id=<?php echo $view['id'];?>" class="active"><span><img src="template/default/content/images/p2.gif" width="16" height="16" align="absmiddle">客户回访</span></a>
<a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=view&id=<?php echo $view['id'];?>"><span><img src="template/default/content/images/p4.gif" width="16" height="16" align="absmiddle">客户回访查看</span></a>
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
        流水号：</td>
      <td class="TableData" width="35%"><?php echo $view['number'];?></td>
	  
	  <td class="TableContent" width="15%"> 回访主题：</td>
      <td class="TableData" width="35%">
	  <?php echo $view['title'];?>
       </td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 
        指定回访时间：</td>
      <td class="TableData" width="35%"><?php echo $view['startdate'];?></td>
	  
	  <td class="TableContent" width="15%"> 回访客户：</td>
      <td class="TableData" width="35%">
	  <?php
	  if($view['cid']!=''){
		  echo public_value('title','crm_company','id='.$view['cid']);
	  }
	  ?>	
	  
       </td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 
        回访人员：</td>
      <td class="TableData" width="35%"><?php echo $view['user'];?></td>
	  
	  <td class="TableContent" width="15%"> </td>
      <td class="TableData" width="35%">
	 
	  
       </td>
    </tr>

</table>
<?php
//引入表单
form_edit('客户回访信息','crm_service',$view['id']);
//引入编辑器
form_edit_eweb('crm_service',$view['id']);
?>

</div> 
</form>

 
</body>
</html>
