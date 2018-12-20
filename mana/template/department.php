 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="x-ua-compatible" content="ie=7" />
<link href="template/default/tree/images/admincp.css?SES" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<style type="text/css">
	.tb{
		clear:both;
		width:50%;
		margin-top:8px;
	}
	.lef{float:left;}
</style>
</head>
<body>
<script src="template/default/tree/js/common.js?SES" type="text/javascript"></script>
<script src="template/default/tree/js/admincp.js?SES" type="text/javascript"></script>
<div id="append_parent"></div>
<div class="container lef" id="cpcontainer" style="width:497px;overflow:auto:height:100%;">

	<table width="50%" class="tb tb2 " id="tips">
	<!-- <tr><th  class="partition"><a href="javascript:;" onclick="show_all()">展开</a> | <a href="javascript:;" onclick="hide_all()">折叠</a>  </th><th  class="partition" ><input type="button" value="确认并提交" class="BigButtonBHover" onClick="sendForm();"></th>
	</tr></table> -->
	<script type="text/JavaScript"> 
	var forumselect = '';
	function sendForm()
	{
	      document.save.submit();
	}

	function dels(id)
	{
		if(confirm('确定删除?')==false)
		{
			return false;
		}
		else
		{
			window.location="/admin.php?ac=department&fileurl=mana&do=delete&departemnt="+id;
		}
	}

	function clickds(urlid)
	{
		document.getElementById("idsc").src="/admin.php?ac=department&fileurl=mana&do=user&department="+urlid;
	}

	function edits(id)
	{
		window.location="/admin.php?ac=department&fileurl=mana&do=edit&department="+id;
	}


	</script>
	<form name="save" method="post" autocomplete="off" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=save" >

	<input type="hidden" name="inputname" value="<?php echo $_GET['inputname']?>" />
	<a href="/admin.php?ac=department&fileurl=mana&do=adds">添加部门</a>
	<a href="/admin.php?ac=department&fileurl=mana">新的添加部门</a>
	<!--menu star-->
	<table class="tb tb2 ">
	<!--title-->
	<!--one-->
	<?php
	global $db;
	$query = $db->query("SELECT * FROM ".DB_TABLEPRE."department where father='0'  ORDER BY id Asc");

		while ($row = $db->fetch_array($query)) {
	?>
	<tr class="hover">
	<td class="td25" onclick="toggle_group('group_<?php echo trim($row[id])?>', $('a_group_<?php echo trim($row[id])?>'))">
	<a href="javascript:;" id="a_group_<?php echo trim($row[id])?>">[-]</a></td>
				
				<td><div class="parentboard"><?php echo '<input type="checkbox" name="id[]" value="'.$row['id'].'" class="checkbox" />';?> <a href="javascript:void(0)" onclick="edits(<?php echo $row['id'];?>)">(编辑)</a>&nbsp<a href="javascript:void(0)" onclick="clickds(<?php echo $row['id'];?>)"><?php echo trim($row[name])?></a>&nbsp<a href="/admin.php?ac=department&fileurl=mana&do=add&departemntids=<?php echo $row['id'];?>" >+</a>&nbsp<a href="javascript:void(0)" onclick="dels(<?php echo $row['id'];?>)">-</a></div></td>
				
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
	<div  class="container" style="margin-top:-30px;float: left;"><iframe  id="idsc" src="/admin.php?ac=department&fileurl=mana&do=user" align="centrer" width="850px" height="620px"></iframe></div>	
	


	
</body>
</html>
