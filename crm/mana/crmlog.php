<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<title>Office 515158 2011 OA办公系统</title>
</head>
<body class="bodycolor">
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 操作记录查看</span>
    </td>
  </tr>
</table>
<table class="TableBlock" border="0" width="95%" align="center">
 
   
	<tr>
      <td width="60" align="center" nowrap class="TableHeader">序号</td>
      <td align="left" class="TableHeader">操作主题</td>
	  <td width="80" align="center" class="TableHeader">操作员</td>
      <td width="120" align="center" class="TableHeader">操作时间</td>
    </tr>
<?php foreach ($result as $row) {?>
	<tr>
      <td nowrap class="TableContent">
<?php echo $row['id'];?></td>
      <td align="left" class="TableData"><?php echo $row['title']?></td>
      <td align="center" class="TableData"><?php echo get_realname($row['uid'])?></td>
      <td align="center" class="TableData"><?php echo $row['date']?></td>
    </tr>
	
<?php }?>	

	
    <tr align="center" class="TableControl">
      <td height="35" colspan="9" align="left" nowrap>
       
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo showpage($num,$pagesize,$page,$url)?></td>
    </tr>
  </table>
 
</body>
</html>
