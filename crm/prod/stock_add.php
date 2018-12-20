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
   if(document.save.stocknum.value=="")
   { alert("库存数量不能为空！");
     document.save.stocknum.focus();
     return (false);
   }
   if(document.save.unit.value=="")
   { alert("单位不能为空！");
     document.save.unit.focus();
     return (false);
   }
<?
global $db;
$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_stock'  ORDER BY inputnumber Asc");
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
	<input type="hidden" name="type" value="<?php echo $_GET['type'];?>" />
	<input type="hidden" name="pid" value="<?php echo $_GET['pid'];?>" />
	<input type="hidden" name="number" value="T<?php echo get_date('YmdHis',PHP_TIME)?>" />
<div id="navPanel">
<div id="navMenu" style="padding-left:50px;">
<a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=stock&type=<?php echo $_GET['type']?>&id=<?php echo $_GET['pid']?>" ><span><img src="template/default/content/images/p3.gif" width="16" height="16" align="absmiddle"><?php echo public_value('title','crm_product','id='.$_GET['pid'])?></span></a>
<a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=add&type=<?php echo $_GET['type']?>&pid=<?php echo $_GET['pid']?>" class="active"><span><img src="template/default/content/images/p2.gif" width="16" height="16" align="absmiddle">库存操作</span></a>
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
        库存数量：<? get_helps()?></td>
      <td class="TableData" width="35%"><input name="stocknum" type="text" class="BigInput" id="price" size="40" style="width: 160px;" onKeyUp="value=value.replace(/[^0-9]/g,'');" /></td>
      <td class="TableContent" width="15%"> 单位：<? get_helps()?></td>
      <td class="TableData" width="35%"><input name="unit" type="text" class="BigInput" id="title" style="width: 160px;" maxlength="100" />
       </td>
    </tr>
	
</table>
<?php
//引入表单
form_add('库存信息','crm_stock');
//引入编辑器
form_add_eweb('crm_stock');
?>

</div> 
</form>

 
</body>
</html>
