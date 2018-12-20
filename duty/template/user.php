<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="template/default/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="template/default/content/js/common.js"></script>
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script type="text/javascript"> 
function sendForm()
{
   document.save.submit();
}
</script>
<title>Office 515158 2011 OA办公系统</title>
</head>
<body class="bodycolor">
<div id="navPanel">
<form method="get" action="admin.php" name="save" class="ui-grid-21 ui-grid-right ui-form" style=" margin-top:3px;">

<div id="search" style="float: right;">

		<input type="hidden" name="ac" value="<?php echo $ac?>" />
		<input type="hidden" name="do" value="list" />
		<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
		<input type="hidden" name="did" value="<?php echo $_GET['did']?>" />
	任务状态： <select name="dkey" id="dkey">
	<option value=""></option>
	<option value="1" <?php if($dkey==1){?>selected="selected"<?php }?>>进行中</option>
	<option value="2" <?php if($dkey==2){?>selected="selected"<?php }?>>未完成</option>
	<option value="3" <?php if($dkey==3){?>selected="selected"<?php }?>>己完成</option>
		</select>&nbsp;&nbsp;	
		执行人：<?php
	  get_pubuser(1,"user",$user,"+选择执行人",80,20)
	  ?>&nbsp;&nbsp;任务周期：<input type="text" value="<?php echo $vstartdate?>"  style="width:80px;" readonly="readonly"  onClick="WdatePicker();" name='vstartdate' > - <input type="text" value="<?php echo $venddate?>"  style="width:80px;" readonly="readonly"  onClick="WdatePicker();" name='venddate' >&nbsp;&nbsp;<input
	type="submit" value="查 询" class="SmallButton" />



</div>
 </form>
</div>

<table width="98%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big" style="font-size:12px;"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> <?php echo $duty['title']?>&nbsp;&nbsp;&nbsp;执行人管理</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right; margin-right:20px;">
	
	<a href="admin.php?ac=duty&fileurl=<?php echo $fileurl?>" style="font-size:12px;"><<返回列表页</a></span>
    </td>
  </tr>
</table>

<form name="update" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&did=<?php echo $duty['id'];?>">
<input type="hidden" name="do" value="update"/>
<table class="TableBlock" border="0" width="98%" align="center">
	<tr>
      <td nowrap class="TableHeader" width="50">选项</td>
      <td class="TableHeader" width="150">执行人</td>
	  <td width="150" align="center" class="TableHeader">任务周期</td>
      <td class="TableHeader">进度</td>
      <td width="90" class="TableHeader" align="center">状态</td>
      <td width="100" align="center" class="TableHeader">操作</td>
    </tr>
<?php
foreach ($result as $row) {
$logupdate = $db->fetch_one_array("SELECT sum(progress) as progress FROM ".DB_TABLEPRE."duty_log WHERE dutyid='".$duty['id']."' and duid='".$row['id']."'");
	if($logupdate["progress"]>='100'){
		$db->query("UPDATE ".DB_TABLEPRE."duty_user SET dkey=3 WHERE id = '".$row['id']."' and dutyid='".$duty['id']."'");
	}
	if($row['enddate']<get_date('Y-m-d',PHP_TIME) && $logupdate["progress"]<'100'){
    	$db->query("UPDATE ".DB_TABLEPRE."duty_user SET dkey=2 WHERE id = '".$row['id']."' and dutyid='".$duty['id']."'");
	}
?>
	<tr>
      <td nowrap class="TableContent" width="5%">
<input type="checkbox" name="id[]" value="<?php echo $row['id']?>" class="checkbox" />  
</td>
 <td class="TableData"><a href="admin.php?ac=<?php echo $ac?>&do=view&fileurl=<?php echo $fileurl?>&id=<?php echo $row['id']?>&did=<?php echo $duty['id'];?>"><?php echo get_realname($row['user'])?></a></td>
	  <td align="center" class="TableData"><?php echo $row['startdate']?>至<?php echo $row['enddate']?></td>
      <td align="left" class="TableData">
	  <?php
	  $key1 = $db->fetch_one_array("SELECT sum(progress) as progress FROM ".DB_TABLEPRE."duty_log WHERE dutyid='".$duty['id']."' and duid='".$row['id']."' ");
	 // echo $key1["progress"];
	 if($key1["progress"]<='100'){
		 echo '<div style="width:100%; background-color:#CCCCCC;">';
			 echo '<div style="width:';
			 if($key1["progress"]!=''){
				 echo $key1["progress"];
			 }else{
				 echo '1';
			 }
			 echo '%; background-color:#006600;">
			  &nbsp;
			  </div>
		  </div>';
	 }else{
		 echo "任务己完成，但己超出来完成进度！";
	 }
	 echo $key1["progress"]."%";
	  ?>
	  </td>
      
      <td align="center" class="TableData">
	  <?php if($row['dkey']=='1'){echo "进行中";}elseif($row['dkey']=='2'){echo "<font color=red>未完成</font>";}else{echo "<font color=#006600>己完成</font>";}?>	  </td>
      <td align="center" class="TableData">
	   <a href="admin.php?ac=<?php echo $ac;?>&do=add&fileurl=<?php echo $fileurl;?>&id=<?php echo $row['id'];?>&did=<?php echo $duty['id'];?>">编辑</a> | 
	   <a href="admin.php?ac=<?php echo $ac;?>&do=view&fileurl=<?php echo $fileurl;?>&id=<?php echo $row['id'];?>&did=<?php echo $duty['id'];?>">查看</a>
	  </td>
    </tr>
	
<?php } ?>	

	
    <tr align="center" class="TableControl">
      <td height="35" colspan="9" align="left" nowrap>
        <input type="checkbox" class="checkbox" value="1" name="chkall" onClick="check_all(this)" /><b>全选</b>&nbsp;&nbsp;&nbsp;&nbsp;<img src="template/default/content/images/ico-1.png" align="absmiddle">
						  <a href="javascript:document:update.submit();">清理数据</a> &nbsp;&nbsp;
						  <?php
						echo get_exceldown('excel_1');?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo showpage($num,$pagesize,$page,$url)?>
</td>
    </tr>
  </table>
</form>

	<form name="excel" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&did=<?php echo $duty['id'];?>">
		<input type="hidden" name="do" value="excel" />
	</form>
 
</body>
</html>
