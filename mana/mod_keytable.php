<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: mod_keytable 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/

(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
get_key("config_keytable");
empty($do) && $do = 'list';
if ($do == 'list') {
	include_once('template/keytable.php');

}elseif ($do == 'save') {
	
	$idarr = getGP('id','P','array');
	$number = getGP('number','P','array');
	$name = getGP('name','P','array');
	$inputname = getGP('inputname','P','array');
	$inputvalue = getGP('inputvalue','P','array');
	$type = getGP('type','P','array');
	$inputchecked = getGP('inputchecked','P','array');
	foreach ($idarr as $id) {
		if($name[$id]=='')$name[$id]='新名称';
		if($inputname[$id]=='')$inputname[$id]='input_name';
		if($inputvalue[$id]=='')$inputvalue[$id]='0';
		if($number[$id]=='')$number[$id]='999';
		if($type[$id]=='')$type[$id]='1';
		if($inputchecked[$id]=='')$inputchecked[$id]='1';
		$keytable = array(
			'name' => $name[$id],
			'inputname' => $inputname[$id],
			'inputvalue' => $inputvalue[$id],
			'inputchecked' => $inputchecked[$id],
			'type' => $type[$id],
			'number' => $number[$id]
		);
		update_db('keytable',$keytable, array('id' => $id));
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
		$newinherited = '';
		foreach (getGP('newinherited','P','array') as $name) {
			$newinherited.=$name.',';
		}
		$newname=substr($newname, 0, -1);
		$newnumber=substr($newnumber, 0, -1);
		$newinherited=substr($newinherited, 0, -1);
		$newname=explode(',',$newname);
		$newnumber=explode(',',$newnumber);
		$newinherited=explode(',',$newinherited);
			for($i=0;$i<sizeof($newname);$i++){
				if($newname[$i]!=''){
					if(str_replace('515158','',$newname[$i])=='')$newname[$i]='新名称';
					if(str_replace('515158','',$newnumber[$i])=='')$newnumber[$i]='999';
					if(str_replace('515158','',$newinherited[$i])!=''){
						$fatherid=str_replace('515158','',$newinherited[$i]);
					}else{
						$fatherid='0';
					}
					$keytable = array(
						'name' => str_replace('515158','',$newname[$i]),
						'inputname' => 'input_name',
						'inputvalue' => '0',
						'inputchecked' => '1',
						'type' => '1',
						'number' => $newnumber[$i],
						'fatherid' => $fatherid
					);
					insert_db('keytable',$keytable);
				}
			}
		$str=',新增了<font color=red>'.sizeof($newname).'</font>条信息';
	}
	
	oa_mana_recache('keytable','id','number');
	show_msg('批量权限信息更新成功'.$str.'！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
}elseif ($_GET['do'] == 'update') {
	
	$db->query("DELETE FROM ".DB_TABLEPRE."keytable WHERE id = '".$_GET[id]."' ");
	show_msg('权限信息删除成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
} 

?>