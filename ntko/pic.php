<?php
$fileUrl = '../'.$_GET['fileaddr'];
$username='系统查看';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../template/default/content/css/style2014.css"><title>Office 515158 2011 OA办公系统</title>
<SCRIPT LANGUAGE="JavaScript">
function refreshParentss() {
  window.opener.location.href = window.opener.location.href;
  window.close();  
 } 
</SCRIPT>
</head>
<body>

<div class="search_area">
        <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td align="left" class="Big" style="font-size:16px; color:#009900; font-weight:bold;">
	<?php echo $_GET['title'];?>
	</td>
	<td align="right" class="Big" style="font-size:16px; color:#009900; font-weight:bold;">

	<button id="do_search" type="button" onClick="refreshParentss();" class="btn btn-success">关闭</button>
	</td>
  </tr>
</table>

</div>
<div  style="position:absolute; height:82%; width:100%;overflow:auto; padding-top:10px;">

<table class="TableBlock" border="0" width="90%" align="center" style="margin-top:30px;">
	
	<tr>
      <td height="800" colspan="2" valign="top">
	  
	  
	    <img src="<?php echo $fileUrl;?>" />	  </td>
	</tr>


  </table>

</div>
</body>
</html>
