 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="x-ua-compatible" content="ie=7" />
<link href="template/default/tree/images/admincp.css?SES" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
</head>
<body>
<script src="template/default/tree/js/common.js?SES" type="text/javascript"></script>
<script src="template/default/tree/js/admincp.js?SES" type="text/javascript"></script>
<div id="append_parent"></div>
<div class="container" id="cpcontainer">
<table width="100%" class="tb tb2 " id="tips">
<tr><th  class="partition"><!--<a href="javascript:;" onclick="show_all()">展开</a> | <a href="javascript:;" onclick="hide_all()">折叠</a> --> </th><th  class="partition" ><input type="button" value="确认并提交" class="BigButtonBHover" onClick="sendForm();"></th>
</tr></table>
<script type="text/JavaScript"> 
var forumselect = '';
function sendForm()
{
      document.save.submit();
}
</script>
<form name="save" method="post" autocomplete="off" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=save" >
<input type="hidden" name="inputname" value="<?php echo $_GET['inputname']?>" />
<!--menu star-->
<table class="tb tb2 ">
<!--title-->
<!--one-->
<?php
global $db;
$query = $db->query("SELECT * FROM ".DB_TABLEPRE."position where father='0'  ORDER BY id Asc");
	while ($row = $db->fetch_array($query)) {
?>
<tr class="hover">
<td class="td25" onclick="toggle_group('group_<?php echo trim($row[id])?>', $('a_group_<?php echo trim($row[id])?>'))">
<a href="javascript:;" id="a_group_<?php echo trim($row[id])?>">[-]</a></td>
			
			<td><div class="parentboard"><?php echo '<input type="checkbox" name="id[]" value="'.$row['id'].'" class="checkbox" />';?> <?php echo trim($row[name])?></div></td>
			
	  </tr>
			
<!--view-->

<?php
public_list($row['id'],0,0,$ac,$fileurl);
?>


<!--add-->
			
			
<?php
}
?>		
			
			
			
			
			
			
			
			
			
			
			
			
			<script type="text/JavaScript">_attachEvent(document.documentElement, 'keydown', function (e) { entersubmit(e, 'editsubmit'); });</script></table>
</form>
 
</div>
</body>
</html>
