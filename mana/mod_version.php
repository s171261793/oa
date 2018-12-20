<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: mana_version.php 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
get_key("config_inc");
empty($do) && $do = 'list';
if ($do == 'list') {
	include_once('template/version.php');
} elseif ($do == 'save') {
	for($i=1;$i<=16;$i++){
		if($i%4==0 && $i<16){
			$strs='-';
		}else{
			$strs='';
		}
		$namearr .= getGP('t'.$i.'','P').$strs;
	 }
	 if(getGP('com_number','P')!=''){
	 	$namearr=getGP('com_number','P');
	 }
	 $httpurl=$_CONFIG->confgi_url().'/office/'.$_CONFIG->config_oaurl('version').'?nums='.$_POST["nums"].'&number='.strtoupper(trim($namearr));
	 $re_user = Utility::HttpRequest($httpurl.'&date='.get_date('YmdHis',PHP_TIME));
	 $re_user=explode('|',$re_user);
	 //数据处理
	 if($re_user[0]!='1'){
		 //com_name
		 if($_CONFIG->config_data_name('com_name')!=''){
			get_config_update('com_name',$re_user[0]);
		 }else{
			get_config_insert('com_name',$re_user[0]);
		 }
		 //com_person
		 if($_CONFIG->config_data_name('com_person')!=''){
			get_config_update('com_person',$re_user[1]);
		 }else{
			get_config_insert('com_person',$re_user[1]);
		 }
		 //com_tel
		 if($_CONFIG->config_data_name('com_tel')!=''){
			get_config_update('com_tel',$re_user[2]);
		 }else{
			get_config_insert('com_tel',$re_user[2]);
		 }
		 //com_phone
		 if($_CONFIG->config_data_name('com_phone')!=''){
			get_config_update('com_phone',$re_user[3]);
		 }else{
			get_config_insert('com_phone',$re_user[3]);
		 }
		 //com_address
		 if($_CONFIG->config_data_name('com_address')!=''){
			get_config_update('com_address',$re_user[4]);
		 }else{
			get_config_insert('com_address',$re_user[4]);
		 }
		 //qq
		 if($_CONFIG->config_data_name('qq')!=''){
			get_config_update('qq',$re_user[5]);
		 }else{
			get_config_insert('qq',$re_user[5]);
		 }
		 //email
		 if($_CONFIG->config_data_name('email')!=''){
			get_config_update('email',$re_user[6]);
		 }else{
			get_config_insert('email',$re_user[6]);
		 }
		 //com_url
		 if($_CONFIG->config_data_name('com_url')!=''){
			get_config_update('com_url',$re_user[7]);
		 }else{
			get_config_insert('com_url',$re_user[7]);
		 }
		  //com_userid
		 if($_CONFIG->config_data_name('com_userid')!=''){
			get_config_update('com_userid',$re_user[8]);
		 }else{
			get_config_insert('com_userid',$re_user[8]);
		 }
		  //usernum
		 if($_CONFIG->config_data_name('usernum')!=''){
			get_config_update('usernum',$re_user[9]);
		 }else{
			get_config_insert('usernum',$re_user[9]);
		 }
		  //com_editionnum
		 if($_CONFIG->config_data_name('com_editionnum')!=''){
			get_config_update('com_editionnum',$re_user[10]);
		 }else{
			get_config_insert('com_editionnum',$re_user[10]);
		 }
		  //com_number
		 if($_CONFIG->config_data_name('com_number')==''){
			get_config_insert('com_number',strtoupper($namearr));
		 }
		 get_config_update('crmdate',get_date('Y-m-d H:i:s',PHP_TIME));
		 oa_mana_recache('config','name','name');
		 show_msg('感谢您对天生创想的支持，产品授权信息更新成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');	
	 }else{
	 	show_msg($re_user[1], 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&error='.$re_user[1]);
	 }

} 
?>