<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<title>信息选择</title>
<script language="javascript" type="text/javascript" src="template/default/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="template/default/content/js/common.js"></script>
<script type="text/javascript"> 
function infovalue(vid,title)
{
   window.opener.document.save.<?php echo $_GET['name']?>.value=title;
   window.opener.document.save.<?php echo $_GET['id']?>.value=vid;
}
</script>
</head>
<body>

<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <form method="get" action="admin.php" name="saves" >
		<input type="hidden" name="ac" value="<?php echo $ac?>" />
		<input type="hidden" name="name" value="<?php echo $_GET['name']?>" />
		<input type="hidden" name="id" value="<?php echo $_GET['id']?>" />
		<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
		<input type="hidden" name="do" value="ck" />
  <tr>
    <td class="Big" style="padding-left:10px;">
	<div id="navMenu">流水号：<input type="text" value="<?php echo urldecode($number)?>" name="number" style='width:100px;' class="BigInput">&nbsp;&nbsp;&nbsp;&nbsp;名称：<input type="text" value="<?php echo urldecode($title)?>" name="title" style='width:180px;' class="BigInput">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="ui-button-text"id="J-submit-time" value="查 找"/></div>
    </td>
  </tr>
 </form>
</table>
<form name="update" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=update">	 
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
	  <input type="checkbox" name="id[]" value="<?php echo $row['id']?>" class="checkbox" /></td>
      <td class="TableData"><?php echo $row['number']?></td>
      <td align="left" class="TableData"><a href="#" onClick="infovalue('<?php echo $row['id']?>','<?php echo $row['title']?>');"><?php echo $row['title']?></a></td>
      </tr>
	<?php
	}
	?>
	
	<tr align="center" class="TableControl">
      <td height="35" colspan="3" align="left" nowrap>
        <input type="checkbox" class="checkbox" value="1" name="chkall" onClick="check_all(this)" />全选&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" name="Submit" value="确认提交" class="BigButtonBHover"  />
						  &nbsp;&nbsp;&nbsp;&nbsp;注：全选时点此提交按钮，单个选择请点信息标题
						  
</td>
    </tr>		
	
  </table>
  </form>	
	
</body>
</html>

