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
   { alert("报价单名称不能为空！");
     document.save.title.focus();
     return (false);
   }
   if(document.save.cname.value=="")
   { alert("公司信息不能为空！");
     document.save.cname.focus();
     return (false);
   }
   if(document.save.price.value=="")
   { alert("总金额不能为空！");
     document.save.price.focus();
     return (false);
   }
   <?php if($_flow==1){?>
   if(document.save.userkey.value=="")
   { alert("审批人员不能为空！");
     document.save.userkey.focus();
     return (false);
   }
   <?php }?>
<?
global $db;
$query = $db->query("SELECT * FROM ".DB_TABLEPRE."crm_form where type1='crm_offer'  ORDER BY inputnumber Asc");
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
<a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>" ><span><img src="template/default/content/images/p3.gif" width="16" height="16" align="absmiddle">报价单信息</span></a>
<a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=add" class="active"><span><img src="template/default/content/images/p2.gif" width="16" height="16" align="absmiddle">报价单添加</span></a>
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
	  
	  <td class="TableContent" width="15%"> 报价名称：<? get_helps()?></td>
      <td class="TableData" width="35%">
	  <input name="title" type="text" class="BigInput" id="title" style="width: 300px;" value=""/>
       </td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 
        总金额：<? get_helps()?></td>
      <td class="TableData" width="35%"><input name="price" type="text" class="BigInput" id="price" style="width: 200px;" onKeyUp="value=value.replace(/[^0-9^.]/g,'');"/></td>
	  
	  <td class="TableContent" width="15%"> 客户名称：<? get_helps()?></td>
      <td class="TableData" width="35%">
	  <?php
	  if($_GET['cid']!=''){
		  echo public_value('title','crm_company','id='.$_GET['cid']);
	  	  echo '<input type="hidden" name="cid" value="'.$_GET['cid'].'" />';
	  }else{
		  crm_title('选择企业','cname','cid','crm_company',1);
	  }
	  ?>
	  
       </td>
    </tr>
	
	
</table>
<table class="TableBlock" border="0" width="90%" align="center">
<tr>
      <td nowrap class="TableHeader" colspan="4">产品信息</td>
    </tr>
	<tr>
      <td nowrap class="TableContent" style="font-weight:bold;">产品名称</td>
      <td class="TableContent" width="15%" align="center" style="font-weight:bold;">产品单价</td>
      <td class="TableContent" width="15%" align="center" style="font-weight:bold;">产品数量</td>
      <td class="TableContent" width="15%" align="center" style="font-weight:bold;">单位</td>
    </tr>
	<?php
	$plist=explode(',',$pid); 
	for($i=0;$i<sizeof($plist);$i++){
	$row = $db->fetch_one_array("SELECT title,price,id FROM ".DB_TABLEPRE."crm_product  WHERE id = '".$plist[$i]."' ");
	?>
	<input type="hidden" name="pid[]" value="<?php echo $row['id'];?>" />
	<tr>
      <td nowrap class="TableData"><?php echo $row['title'];?></td>
      <td class="TableData" width="15%" align="center"><input name="price_<?php echo trim($row['id']);?>" type="text" class="BigInput" id="price" style="width: 100px;" value="<?php echo trim($row['price']);?>" onKeyUp="value=value.replace(/[^0-9^.]/g,'');" /></td>
      <td class="TableData" width="15%" align="center"><input name="number_<?php echo $row['id'];?>" type="text" class="BigInput" id="number" style="width: 100px;" onKeyUp="value=value.replace(/[^0-9]/g,'');" /></td>
      <td class="TableData" width="15%" align="center"><input name="unit_<?php echo trim($row['id']);?>" type="text" class="BigInput" id="unit" style="width: 100px;" /></td>
    </tr>
	<?php }?>
	
</table>

<?php
//引入表单
form_add('报价单信息','crm_offer');
//引入编辑器
form_add_eweb('crm_offer');
//引入流程
if($_flow==1){
	crm_flow_add('crm_offer');
}
?>

</div> 
</form>

 
</body>
</html>
