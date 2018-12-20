<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="template/default/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="template/default/content/js/common.js"></script>
<title>Office 515158 2011 OA办公系统</title>
 
</head>
<body  class="bodycolor">
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> <?php echo $human_form_type?>表单管理</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px;"><a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&type1=1" <?php if($_GET["type1"]=='1'){?> style="color:red;"<?php }?>>档案</a>&nbsp;|&nbsp;
	  <a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&type1=2" <?php if($_GET["type1"]=='2'){?> style="color:red;"<?php }?>>证照</a>&nbsp;|&nbsp;
	  <a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&type1=3" <?php if($_GET["type1"]=='3'){?> style="color:red;"<?php }?>>学习经历</a>&nbsp;|&nbsp;
	  <a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&type1=4" <?php if($_GET["type1"]=='4'){?> style="color:red;"<?php }?>>工作经历</a>&nbsp;|&nbsp;
	  <a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&type1=5" <?php if($_GET["type1"]=='5'){?> style="color:red;"<?php }?>>劳动技能</a>&nbsp;|&nbsp;
	  <a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&type1=6" <?php if($_GET["type1"]=='6'){?> style="color:red;"<?php }?>>社会关系</a>&nbsp;|&nbsp;
	  <a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&type1=7" <?php if($_GET["type1"]=='7'){?> style="color:red;"<?php }?>>人事调动</a>&nbsp;|&nbsp;
	  <a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&type1=8" <?php if($_GET["type1"]=='8'){?> style="color:red;"<?php }?>>复职管理</a>&nbsp;|&nbsp;
	  <a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&type1=9" <?php if($_GET["type1"]=='9'){?> style="color:red;"<?php }?>>职称评定</a>&nbsp;|&nbsp;
	  <a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&type1=10" <?php if($_GET["type1"]=='10'){?> style="color:red;"<?php }?>>员工关怀</span>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="新建表单" class="BigButtonBHover" onClick="javascript:window.location='admin.php?ac=human_form_add&fileurl=human&type1=<?php echo $_GET["type1"]?>'">
    </td>
  </tr>
</table>

<form name="update" method="post" action="admin.php?ac=crm_form&fileurl=crm&type1=<?php echo $_GET["type1"]?>">
<table class="TableBlock" border="0" width="90%" align="center">
 
   
	<tr>
      <td nowrap class="TableHeader" width="6%">选项</td>
      <td width="19%" class="TableHeader">表单名称</td>
      <td width="13%" class="TableHeader">控件名称</td>
      <td width="14%" class="TableHeader">默认值</td>
      <td width="12%" align="center" class="TableHeader">类型</td>
      <td width="13%" align="center" class="TableHeader">表单类型</td>
      <td width="11%" align="center" class="TableHeader">验证方式</td>

      <td width="9%" align="center" class="TableHeader">操作</td>
    </tr>
<?foreach ($result as $row) {?>
	<tr>
      <td nowrap class="TableContent" width="6%"><?php
if($row["key1"]=='1'){
echo '<input type="checkbox" name="id[]" value="'.$row['id'].'" disabled="disabled" />';
}else{
get_boxlistkey("id[]",$row['id'],$row['uid'],$_USER->id);
}
?></td>
      <td class="TableData"><?php echo $row['formname']?></td>
      <td align="left" class="TableData"><?php echo $row['inputname']?></td>
      <td align="center" class="TableData"><?php echo $row['inputvalue']?></td>
      <td align="center" class="TableData">
	  <?php
if($row["type"]=='1'){
	echo '<font color=red>图片</font>';
}elseif($row["type"]=='2'){
	echo '<font color=#006600>附件</font>';
}elseif($row["type"]=='3'){
	echo '<font color=#006600>日期</font>';
}elseif($row["type"]=='4'){
	echo '<font color=#006600>部门</font>';
}elseif($row["type"]=='5'){
	echo '<font color=#006600>成员</font>';
}elseif($row["type"]=='0'){
	echo '<font color=#006600>表单</font>';
}
?>	  </td>
      <td align="center" class="TableData">
	  <?php
if($row["inputtype"]=='1'){
	echo '<font color=red>输入框</font>';
}elseif($row["inputtype"]=='2'){
	echo '<font color=#006600>输入区</font>';
}elseif($row["inputtype"]=='3'){
	echo '<font color=#006600>单选</font>';
}elseif($row["inputtype"]=='4'){
	echo '<font color=#006600>复选</font>';
}elseif($row["inputtype"]=='5'){
	echo '<font color=#006600>下拉</font>';
}
?>	  </td>
      <td align="center" class="TableData">
	  <?php
if($row["confirmation"]=='1'){
	echo '<font color=red>是</font>';
}elseif($row["confirmation"]=='2'){
	echo '<font color=#006600>否</font>';
}
?>	  </td>

      <td align="center" class="TableData"><?php get_urlkey("编辑","admin.php?ac=human_form_edit&do=list&fileurl=human&id=".$row['id']."&type1=".$_GET["type1"]."","".$row['uid']!=$_USER->id)?></td>
    </tr>
	
<?}?>	

	
    <tr align="center" class="TableControl">
      <td height="35" colspan="10" align="left" nowrap>
       <!-- <input type="checkbox" class="checkbox" value="1" name="chkall" onClick="check_all(this)" /><b>全选</b>&nbsp;&nbsp;<input type="submit" name="do" id="button" class="BigButtonBHover" value="删 除"/>&nbsp;&nbsp;<input type="submit" name="do" id="button" class="BigButtonBHover" value="排 序"/> -->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo showpage($num,$pagesize,$page,$url)?></td>
    </tr>
  </table>
</form>


 
</body>
</html>
