 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="x-ua-compatible" content="ie=7" />
<link href="template/default/tree/images/admincp.css?SES" rel="stylesheet" type="text/css" />
</head>
<body onload="hide_all();">
<script src="template/default/tree/js/common.js?SES" type="text/javascript"></script>
<script src="template/default/tree/js/admincp.js?SES" type="text/javascript"></script>
<div id="append_parent"></div>
<div class="container" id="cpcontainer"><div class="itemtitle"><h3>菜单管理</h3></div>
<table class="tb tb2 " id="tips">
<tr><th  class="partition"><a href="javascript:;" onclick="show_all()">全部展开</a> | <a href="javascript:;" onclick="hide_all()">全部折叠</a> </th></tr></table>
<script type="text/JavaScript"> 
var forumselect = '<?php echo get_menu_newinherited(0,0,0)?>';
var rowtypedata = [
	[[1, ''], [1,'<input type="text" class="txt" name="newnumber[]" value="999" />', 'td25'], [5, '<div><input name="newname[]" value="顶级菜单名称" size="20" type="text" class="txt" /><input type="text" name="newmenuurl[]" value="URL地址" class="txt" style="width:260px;" /><input type="hidden" name="newid[]" value="1" /><a href="javascript:;" class="deleterow" onClick="deleterow(this)">删除</a></div>']],
	[[1, ''], [1,'<input type="text" class="txt" name="newnumber[]" value="999" />', 'td25'], [5, '<div class="board"><input name="newname[]" value="菜单名称" size="20" type="text" class="txt" /><input type="text" name="newmenuurl[]" value="URL地址" class="txt" style="width:260px;" /><input type="hidden" name="newids[]" value="2" /><a href="javascript:;" class="deleterow" onClick="deleterow(this)">删除</a><select name="newinherited[]"><option value="">指定上级菜单</option>' + forumselect + '</select></div>']],
	[[1, ''], [1,'<input type="text" class="txt" name="newnumber[]" value="999" />', 'td25'], [5, '<div class="board"><input name="newname[]" value="菜单名称" size="20" type="text" class="txt" /><input type="text" name="newmenuurl[]" value="URL地址" class="txt" style="width:260px;" /><input type="hidden" name="newids[]" value="2" /><a href="javascript:;" class="deleterow" onClick="deleterow(this)">删除</a><select name="newinherited[]"><option value="">指定上级菜单</option>' + forumselect + '</select></div>']],
];
</script>
<form name="cpform" method="post" autocomplete="off" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=save" >
<!--menu star-->
<table class="tb tb2 ">
<!--title-->
<tr class="header"><th></th><th>显示顺序</th><th>名称/地址/权限</th><th></th><th>类型</th><th><a href="javascript:;" onclick="if(getmultiids()) location.href='admin.php?action=forums&operation=edit&multi=' + getmultiids();return false;">操作</a></th></tr>
<!--one-->
<?php
global $db;
$query = $db->query("SELECT * FROM ".DB_TABLEPRE."menu where fatherid='0'  ORDER BY menunum Asc  ");
	while ($row = $db->fetch_array($query)) {
?>
<tr class="hover">
<td class="td25" onclick="toggle_group('group_<?php echo trim($row[menuid])?>', $('a_group_<?php echo trim($row[menuid])?>'))">
<a href="javascript:;" id="a_group_<?php echo trim($row[menuid])?>">[-]</a></td>
			<td class="td25"><input type="hidden" name="id[]" value="<?php echo trim($row[menuid])?>" /><input type="text" class="txt" name="menunum[<?php echo trim($row[menuid])?>]" value="<?php echo trim($row[menunum])?>" /></td>
			<td><div class="parentboard"><input type="text" name="menuname[<?php echo trim($row[menuid])?>]" value="<?php echo trim($row[menuname])?>" class="txt" /> 
			<input type="text" name="menuurl[<?php echo trim($row[menuid])?>]" value="<?php echo trim($row[menuurl])?>" class="txt" style="width:260px;" <?php if(COOKSHOW==1){?>readonly<?php }?>/><input type="text" name="keytable[<?php echo trim($row[menuid])?>]" value="<?php echo trim($row[keytable])?>" class="txt" style="width:100px;" <?php if(COOKSHOW==1){?>readonly<?php }?>/></div></td>
			<td class="td25 lightfont">(<?php echo trim($row[menuid])?>)</td>
			<td class="td23"><select name="menutype[<?php echo trim($row[menuid])?>]">
			  <option value="0" <?php if($row[menutype]=='0'){?> selected="selected"<?php }?>>正常</option>
			   <option value="2" <?php if($row[menutype]=='2'){?> selected="selected"<?php }?>>桌面</option>
			  <option value="1" <?php if($row[menutype]=='1'){?> selected="selected"<?php }?>>隐藏</option>
			  </select>
		</td>
			<td width="160">
			<?php
			if(COOKSHOW==1){
				 echo ' 不可删除';
			}else{
			?>
			<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=update&id=<?php echo trim($row[menuid])?>" class="act">删除</a>
			<?php }?>
			</td>
			</tr>
			
<!--view-->

<?php
get_menu_list($row['menuid'],0,0,$ac,$fileurl);
?>


<!--add-->
			<tr><td></td><td colspan="4"><div class="lastboard"><a href="###" onclick="addrow(this, 1, 1)" class="addtr">添加新菜单</a></div></td><td>&nbsp;</td></tr>
			
<?php
}
?>		
			
			
			
			
			
			
			
			
			<tr><td></td><td colspan="4"><div><a href="###" onclick="addrow(this, 0)" class="addtr">添加顶级菜单</a></div></td><td class="bold"></td></tr><tr><td colspan="15"><div class="fixsel"><input type="submit" class="btn" id="submit_editsubmit" name="editsubmit" title="按 Enter 键可随时提交你的修改" value="提交" /></div></td></tr>
			
			
			
			<script type="text/JavaScript">_attachEvent(document.documentElement, 'keydown', function (e) { entersubmit(e, 'editsubmit'); });</script></table>
</form>
 
</div>
</body>
</html>
