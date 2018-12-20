<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: mod_menu 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/

(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
get_key("config_menu");
empty($do) && $do = 'list';
if ($do == 'list') {
	include_once('template/menu.php');

}elseif ($do == 'save') {
	
	$idarr = getGP('id','P','array');
	$menuname = getGP('menuname','P','array');
	$menuurl = getGP('menuurl','P','array');
	$menunum = getGP('menunum','P','array');
	$menutype = getGP('menutype','P','array');
	$keytable  = getGP('keytable','P','array');
	foreach ($idarr as $id) {
		if($menuname[$id]=='')$menuname[$id]='新菜单名称';
		if($menuurl[$id]=='')$menuurl[$id]='#';
		if($menunum[$id]=='')$menunum[$id]='999';
		$menu = array(
			'menuname' => $menuname[$id],
			'menuurl' => $menuurl[$id],
			'menunum' => $menunum[$id],
			'menutype' => $menutype[$id],
			'keytable' => $keytable[$id]
		);
		update_db('menu',$menu, array('menuid' => $id));
	}
	if(getGP('newid','P','array')!='' || getGP('newids','P','array')!=''){
		$newname = '';
		foreach (getGP('newname','P','array') as $name) {
			$newname.=$name.',';
		}
		$newnumber = '';
		foreach (getGP('newnumber','P','array') as $name) {
			$newnumber.=$name.',';
		}
		$newmenuurl = '';
		foreach (getGP('newmenuurl','P','array') as $name) {
			$newmenuurl.=$name.',';
		}
		$newinherited = '';
		foreach (getGP('newinherited','P','array') as $name) {
			$newinherited.=$name.',';
		}
		$newname=substr($newname, 0, -1);
		$newnumber=substr($newnumber, 0, -1);
		$newmenuurl=substr($newmenuurl, 0, -1);
		$newinherited=substr($newinherited, 0, -1);
		$newname=explode(',',$newname);
		$newnumber=explode(',',$newnumber);
		$newmenuurl=explode(',',$newmenuurl);
		$newinherited=explode(',',$newinherited);
			for($i=0;$i<sizeof($newname);$i++){
				if($newname[$i]!=''){
					if($newinherited[$i]!=''){
						$fatherid=$newinherited[$i];
					}else{
						$fatherid='0';
					}
					$menu = array(
						'menuname' => $newname[$i],
						'menuurl' => $newmenuurl[$i],
						'menunum' => $newnumber[$i],
						'menutype' => '0',
						'menukey' =>'0',
						'fatherid'=>$fatherid
					);
					insert_db('menu',$menu);
				}
			}
		//$str=',新增了<font color=red>'.sizeof($newname).'</font>条信息';
	}
	oa_mana_recache('menu','menuid','menunum');
	oa_where_recache('menu','menuid','menunum','menutype=2','home');
	show_msg('批量菜单信息更新成功'.$str.'！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
}elseif ($_GET['do'] == 'update') {
	$db->query("DELETE FROM ".DB_TABLEPRE."menu WHERE menuid = '".$_GET[id]."' ");
	show_msg('菜单信息删除成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
} 

?>