<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<title>Office 515158 2011 OA办公系统</title>
</head>
<body class="bodycolor">
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big" style="font-size:12px;"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3">工作日程 [<?php echo $_GET['ymd'];?>]</span>
    </td>
  </tr>
</table>
<table class="TableBlock" border="0" width="95%" align="center" style="margin-bottom:20px;">
<?php
$i=0;
foreach ($result as $row) {
?>
	<tr>
      <td width="130" valign="top" nowrap class="TableHeader">
	  <?php echo get_realname($row['uid'])?><br>
	  [<?php
			  if($row['otype']==1){
				  echo '全天&nbsp;&nbsp;'.$row['workdate'];
			  }else{
			  	  echo $row['workdate'].'&nbsp;'.$row['startdate'];
			  }
			  ?>]</td>
      <td class="TableContent"><?php echo $row['content']?>
	  </td>
    </tr>
	
	
<?php }?>	
  </table>

</body>
</html>
