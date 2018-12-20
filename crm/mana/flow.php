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
<a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&modid=<?php echo $r[$i];?>" <?php if($r[$i]==$modid){?>class="active"<?php }?>><span><?php echo form_mod($r[$i]);?></span></a>
<?php }?>
</div>
<div id="search" style="float: right; padding-right:90px;">
	
	<input type="button" value="新建流程" class="BigButtonBHover" onClick="javascript:window.location='admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=add&modid=<?php echo $modid?>'">

 
</div>
</div>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big" style="font-size:12px;"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> <?php echo form_mod($modid);?>流程管理</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	
    </td>
  </tr>
</table>

<form name="update" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&modid=<?php echo $modid?>">
  <input type="hidden" name="do" value="update"/>
<table class="TableBlock" border="0" width="90%" align="center">
 
   
	<tr>
      <td nowrap class="TableHeader" width="80">选项</td>
      <td  class="TableHeader">流程名称</td>
      <td width="120" align="center" class="TableHeader">流程步骤</td>
      <td width="120" align="center" class="TableHeader">类型</td>
      <td width="120" align="center" class="TableHeader">状态</td>
      <td width="120" align="center" class="TableHeader">审批状态</td>
	  <td width="120" align="center" class="TableHeader">审批关系</td>
      <td width="120" align="center" class="TableHeader">操作</td>
    </tr>
<?foreach ($result as $row) {?>
	<tr>
      <td nowrap class="TableContent" width="5%">
	  <?php
	  //$anum=$db->result("SELECT COUNT(*) AS anum FROM ".DB_TABLEPRE."crm_personnel where flowid='".$row['fid']."'");
	  ?>
	  <input type="checkbox" name="id[]" value="<?php echo $row['fid']?>" class="checkbox"  />
</td>
      <td class="TableData"><?php echo $row['flowname']?></td>
	  <td align="center" class="TableData">
	  第 <span style="font-size:18px; font-weight:bold; color:#FF0000;"><?php echo $row['flownum']?>	</span>步</td>
	  <td align="center" class="TableData">
	  <?php
	  if($row['flowkey']==1){
		  echo '顺序直行';
	  }elseif($row['flowkey']==2){
		   echo '<font color=#FF0000>流程结束</font>';
	  }elseif($row['flowkey']==3){
		   echo '退回流程';
	  }?></td>
      
      <td align="center" class="TableData">
	  <?php
	  if($row['flowkey1']==1){
		  echo '可选';
	  }else{
		   echo '<font color=#FF0000>不可选</font>';
	  }?>
	  </td>
      <td align="center" class="TableData">
	  <?php
	  if($row['flowkey2']==1){
		  echo '多人审批';
	  }else{
	  	 echo '单人审批';
	  }?>	  </td>
	  <td align="center" class="TableData">
	  <?php
	  if($row['flowkey3']==1){
		  echo '同时通过';
	  }else{
	  	 echo '一人通过';
	  }?>	  </td>
      <td align="center" class="TableData">
	  <?php if($row['flownum']!=1){?>
	  <a href="admin.php?ac=<?php echo $ac?>&do=add&fileurl=<?php echo $fileurl?>&modid=<?php echo $modid?>&fid=<?php echo $row['fid']?>">编辑</a>
	  <?php }else{echo '初使流程，不可操作';}?>
	  </td>
    </tr>
	
<?}?>	

	
    <tr align="center" class="TableControl">
      <td height="35" colspan="9" align="left" nowrap>
        <input type="checkbox" class="checkbox" value="1" name="chkall" onClick="check_all(this)" /><b>全选</b>&nbsp;&nbsp;<input type="submit" name="delete" id="button" class="BigButtonBHover" value="删 除"/>&nbsp;&nbsp;(注：删除流程时会将该流程下所有审批数据删除)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo showpage($num,$pagesize,$page,$url)?>
</td>
    </tr>
  </table>
</form>


 
</body>
</html>
