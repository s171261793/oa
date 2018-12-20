<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="template/default/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="template/default/content/js/common.js"></script>
<title>Office 515158 2011 OA办公系统</title>
</head>
<body class="bodycolor">
<div id="navPanel">
<div id="navMenu" style="padding-left:30px;">
<?php for($i=0;$i<sizeof($r);$i++){?>
<a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&type1=<?php echo $r[$i];?>" <?php if($r[$i]==$_GET['type1']){?>class="active"<?php }?>><span><?php echo form_mod($r[$i]);?></span></a>
<?php }?>
</div>
<div id="search" style="float: right; padding-right:90px;">
	
	<input type="button" value="新建表单" class="BigButtonBHover" onClick="javascript:window.location='admin.php?ac=<?php echo $ac;?>&do=add&fileurl=<?php echo $fileurl;?>&type1=<?php echo $_GET["type1"]?>'">

 
</div>
</div>
<div style="position:absolute; height:90%; width:100%;overflow:auto"> 
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> <?php echo $crm_form_type?>表单管理</span>
    </td>
  </tr>
</table>

<form name="update" method="post" action="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&type1=<?php echo $_GET["type1"]?>">
<table class="TableBlock" border="0" width="98%" align="center">
 
   
	<tr>
      <td width="5%" align="center" nowrap class="TableHeader">选项</td>
      <td width="6%" align="center" class="TableHeader">排序</td>
      <td width="16%" align="center" class="TableHeader">表单名称</td>
      <td width="18%" align="center" class="TableHeader">控件名称</td>
      <td width="10%" align="center" class="TableHeader">默认值</td>
      <td width="9%" align="center" class="TableHeader">类型</td>
      <td width="10%" align="center" class="TableHeader">表单类型</td>
      <td width="8%" align="center" class="TableHeader">验证方式</td>
      <td width="7%" align="center" class="TableHeader">列表显示?</td>
      <td width="6%" align="center" class="TableHeader">操作</td>
    </tr>
<?php foreach ($result as $row) {?>
	<tr>
      <td nowrap class="TableContent" width="5%">
<?php
$dnum=$db->result("SELECT COUNT(*) AS dnum FROM ".DB_TABLEPRE."crm_db where formid='".$row['fid']."'");
if($dnum<1){
	echo '<input type="checkbox" name="id[]" value="'.$row['fid'].'" />';
}else{
	echo '<input type="checkbox" name="id[]" value="'.$row['fid'].'" disabled="disabled" />';
}
?></td>
      <td class="TableData"><input name="inputnumber[<?php echo $row['fid'];?>]" type="text" style="width:30px;" value="<?php echo $row['inputnumber']?>" /></td>
      <td align="center" class="TableData"><?php echo $row['formname']?></td>
      <td align="center" class="TableData"><?php echo $row['inputname']?></td>
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
      <td align="center" class="TableData">
	  <?php
if($row["type2"]=='1'){
	echo '<font color=red>是</font>';
}else{
	echo '<font color=#006600>否</font>';
}
?>	  </td>
      <td align="center" class="TableData"><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=edit&fid=<?php echo $row['fid']?>&type1=<?php echo $row['type1']?>">编辑</a></td>
    </tr>
	
<?php }?>	

	
    <tr align="center" class="TableControl">
      <td height="35" colspan="10" align="left" nowrap>
        <input type="checkbox" class="checkbox" value="1" name="chkall" onClick="check_all(this)" /><b>全选</b>&nbsp;&nbsp;<input type="submit" name="do" id="button" class="BigButtonBHover" value="删 除"/>&nbsp;&nbsp;<input type="submit" name="do" id="button" class="BigButtonBHover" value="排 序"/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo showpage($num,$pagesize,$page,$url)?>
</td>
    </tr>
  </table>
</form>

</div>
 
</body>
</html>
