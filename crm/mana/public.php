<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<title>信息选择</title>
<script type="text/javascript"> 
function infovalue(vid,title)
{
   window.opener.document.save.<?php echo $_GET['name']?>.value=title;
   window.opener.document.save.<?php echo $_GET['id']?>.value=vid;
}
</script>
</head>
<body>
<form method="get" action="admin.php" name="save" >
		<input type="hidden" name="ac" value="<?php echo $ac?>" />
		<input type="hidden" name="name" value="<?php echo $_GET['name']?>" />
		<input type="hidden" name="id" value="<?php echo $_GET['id']?>" />
		<input type="hidden" name="modid" value="<?php echo $_GET['modid']?>" />
		<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big" style="padding-left:10px;">
	<div id="navMenu">流水号：<input type="text" value="<?php echo urldecode($number)?>" name="number" style='width:100px;' class="BigInput">&nbsp;&nbsp;&nbsp;&nbsp;名称：<input type="text" value="<?php echo urldecode($title)?>" name="title" style='width:180px;' class="BigInput">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="ui-button-text"id="J-submit-time" value="查 找"/></div>
    </td>
  </tr>
</table>
	 
	 <table class="TableBlock" border="0" width="98%" align="center">
		<tr>
			<td nowrap class="TableHeader" width="30"></td>
			  <td width="120" class="TableHeader">流水号</td>
			  <td class="TableHeader">名称</td>
	    </tr>
		<?php
		foreach ($result as $row) {
		?>
			<tr>
      <td nowrap class="TableContent">
	  <?php echo $row['id']?></td>
      <td class="TableData"><?php echo $row['number']?></td>
      <td align="left" class="TableData"><a href="#" onClick="infovalue('<?php echo $row['id']?>','<?php echo $row['title']?>');"><?php echo $row['title']?></a></td>
      </tr>
	<?php
	}
	?>
	
			
		
  </table>
  
</form>	
</body>
</html>

