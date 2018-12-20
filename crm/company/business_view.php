<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<link href="template/webui/ligerUI/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="template/default/js/jquery.min.js"></script>
<script src="template/webui/ligerUI/js/ligerui.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function (){
	$("#accordion1").ligerAccordion();
});
</script><title>Office 515158 2011 OA办公系统</title>
</head>
<body class="bodycolor">
<div id="navPanel">
<div id="navMenu" style="padding-left:50px;">
<a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>" ><span><img src="template/default/content/images/p3.gif" width="16" height="16" align="absmiddle">代理商列表</span></a>
<a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=edit&id=<?php echo $view['id'];?>"><span><img src="template/default/content/images/p2.gif" width="16" height="16" align="absmiddle">代理商编辑</span></a>
<a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=view&id=<?php echo $view['id'];?>" class="active"><span><img src="template/default/content/images/p4.gif" width="16" height="16" align="absmiddle">代理商查看</span></a>
<a href="#" onClick="window.open ('admin.php?ac=public&do=crmlog&fileurl=crm&viewid=<?php echo $view['id'];?>&modid=crm_business', '<?php echo $view['id'];?>', 'height=600, width=600, top=50, left=150, toolbar=no, menubar=no, scrollbars=yes, resizable=yes,location=no, status=no')"><span><img src="template/default/images/admin_img/detail.png" width="16" height="16" align="absmiddle">操作记录</span></a>
</div>
<div id="search" style="float: right; padding-right:100px;">
	
	<input type="button" value="发布信息" class="BigButtonBHover" onClick="javascript:window.location='admin.php?ac=<?php echo $ac;?>&do=add&fileurl=<?php echo $fileurl;?>'">


 
</div>
</div>






<div style="position:absolute; height:90%; width:100%;overflow:auto"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" style="padding-top:20px;width:200px;padding-left:5px;">
	<style type="text/css">
        #accordion1{height:400px;overflow:hidden;}
    </style>
	<div id="accordion1"> 
	
	
     <div title="联系人" style="line-height:22px; padding-left:5px;">
      <?php
	global $db;
	$query = $db->query("SELECT name,type,id FROM ".DB_TABLEPRE."crm_contact where cid='".$view['id']."' and type=2 and type1!=1 ORDER BY id Asc");
	while ($row = $db->fetch_array($query)) {
	?>
    • <a href="admin.php?ac=contact&fileurl=<?php echo $fileurl;?>&do=view&id=<?php echo $row['id']?>&type=<?php echo $row['type']?>&cid=<?php echo $view['id']?>"><?php echo $row['name'];?></a><br>
	<?php }?>
        
        </div>


	<div title="客户关怀" style="line-height:22px; padding-left:5px;">
      <?php
	global $db;
	$query = $db->query("SELECT title,type,id FROM ".DB_TABLEPRE."crm_care where cid='".$view['id']."' and type=2 ORDER BY id desc");
	while ($row = $db->fetch_array($query)) {
	?>
    • <a href="admin.php?ac=care&fileurl=<?php echo $fileurl;?>&do=view&id=<?php echo $row['id']?>&type=<?php echo $row['type']?>&cid=<?php echo $view['id']?>"><?php echo $row['title'];?></a><br>
	<?php }?>
    </div>
	
	
	<div title="客户投诉" style="line-height:22px; padding-left:5px;">
      <?php
	global $db;
	$query = $db->query("SELECT title,type,id FROM ".DB_TABLEPRE."crm_complaints where cid='".$view['id']."' and type=2 ORDER BY id desc");
	while ($row = $db->fetch_array($query)) {
	?>
    • <a href="admin.php?ac=complaints&fileurl=<?php echo $fileurl;?>&do=view&id=<?php echo $row['id']?>&type=<?php echo $row['type']?>&cid=<?php echo $view['id']?>"><?php echo $row['title'];?></a><br>
	<?php }?>
    </div>
	
	
	<div title="下级代理商" style="line-height:22px; padding-left:5px;">
      <?php
	global $db;
	$query = $db->query("SELECT title,id FROM ".DB_TABLEPRE."crm_business where bid='".$view['id']."' ORDER BY id desc");
	while ($row = $db->fetch_array($query)) {
	?>
    • <a href="admin.php?ac=business&fileurl=<?php echo $fileurl;?>&do=view&id=<?php echo $row['id']?>"><?php echo $row['title'];?></a><br>
	<?php }?>
    </div>
	<div title="客户管理" style="line-height:22px; padding-left:5px;">
      <?php
	global $db;
	$query = $db->query("SELECT title,id FROM ".DB_TABLEPRE."crm_company where bid='".$view['id']."' ORDER BY id desc");
	while ($row = $db->fetch_array($query)) {
	?>
    • <a href="admin.php?ac=company&fileurl=<?php echo $fileurl;?>&do=view&id=<?php echo $row['id']?>"><?php echo $row['title'];?></a><br>
	<?php }?>
    </div>
	
	

	  </div>
	</td>
    <td valign="top">
<!--右边开始-->

<table class="TableBlock" border="0" width="95%" align="center" style="margin-top:20px;">
<tr>
      <td nowrap class="TableHeader" colspan="4">基本信息</td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 
        流水号：</td>
      <td class="TableData" width="35%"><?php echo $view['number'];?></td>
      <td class="TableContent" width="15%"> 代理商名称：</td>
      <td class="TableData" width="35%"><?php echo $view['title'];?>
       </td>
    </tr>
	<tr>
      <td nowrap class="TableContent">业务人员：</td>
      <td class="TableData"><?php echo $view['user']?></td>
      <td class="TableContent" width="15%">上级代理：</td>
      <td class="TableData" width="35%">
	  <?php if($view['bid']!=''){?>
	  <a href="#" onClick="window.open ('admin.php?ac=business&fileurl=crm&do=view&id=<?php echo $view['bid'];?>', '<?php echo $view['bid'];?>', 'height=600, width=1000, top=50, left=150, toolbar=no, menubar=no, scrollbars=yes, resizable=yes,location=no, status=no')">
	  <?php
	  if($view['bid']!=''){
		  echo public_value('title','crm_business','id='.$view['bid']);
	  }
	  ?></a>
	<?php }?>
      </td>
    </tr>
</table>
<?php
//引入表单
form_view('代理商信息','crm_business',$view['id']);
//引入编辑器
form_view_eweb('crm_business',$view['id']);
$user = $db->fetch_one_array("SELECT id,name FROM ".DB_TABLEPRE."crm_contact  WHERE type1 = '1' and cid='".$view['id']."' and type=2 ");
?>
<table class="TableBlock" border="0" width="95%" align="center" style="margin-top:20px; ">
<tr>
      <td nowrap class="TableHeader" colspan="4">联系人信息</td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 
        姓名：</td>
      <td class="TableData" width="35%"><?php echo $user['name'];?></td>
      <td class="TableContent" width="15%"> </td>
      <td class="TableData" width="35%">
       </td>
    </tr>
</table>
<?php

//引入表单
form_view('','crm_contact',$user['id']);
//引入编辑器
form_view_eweb('crm_contact',$user['id']);
?>
<!--右边结束 -->	
	</td>
  </tr>
</table>




</div> 



 
</body>
</html>
