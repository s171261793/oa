<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<title>人员选择</title>
 
</head>
<body>

<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <form method="get" action="admin.php" name="save" >
		<input type="hidden" name="ac" value="<?php echo $ac?>" />
		<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
		<input type="hidden" name="inputname" value="<?php echo $_GET[inputname]?>" />
  <tr>
    <td class="Big" style="padding-left:10px;"><div id="navMenu"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3">人员选择</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;姓名：<input type="text" value="<?php echo urldecode($keyword)?>" name="keyword" style='width:100px;' class="BigInput">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="ui-button-text"id="J-submit-time" value="搜 索"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="确认选择" class="BigButtonBHover" onClick="javascript:actForm.submit();"></div>
    </td>
  </tr>
  </form>
</table>
<form method="post" name="actForm" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=add">
  <input type="hidden" name="inputname" value="<?php echo $_GET[inputname]?>">	 
	 <table class="TableBlock" border="0" width="98%" align="center">
		<tr>
			<td nowrap class="TableHeader" width="10%">选项</td>
			  <td width="40%" class="TableHeader">姓名</td>
			<td nowrap class="TableHeader" width="10%">选项</td>
			  <td width="40%" class="TableHeader">姓名</td>
       </tr>
		<?php
		$i=0;
		foreach ($result as $row) {
		$i++;
		?>
		<td nowrap class="TableContent">
	  <input type="hidden" name="oaid<?php echo $row['vid']?>" value="<?php echo $row['uid']?>" />
		<input type="hidden" name="oaname<?php echo $row['vid']?>" value="<?php echo $row['name']?>" />
		<input type="hidden" name="oaphone<?php echo $row['vid']?>" value="<?php echo $row['phone']?>" />
	  <input type="radio" name="vid[]" value="<?php echo $row['vid']?>" style="border:0px;" />
	  </td>
      <td class="TableData"><?php echo $row['name']?></td>

	<?php
	if($i%2==0){
		echo '</tr><tr>';
	}
	}
	?>
	
			
		
  </table>
  
</form>	
</body>
</html>

