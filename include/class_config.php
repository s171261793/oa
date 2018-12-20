<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: class_config.php 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/
!defined('IN_TOA') && exit('Access Denied!');

class config 
{
	
	public function config_data($data=0){
		global $_CACHE;
		get_cache('config');
		foreach ( $_CACHE['config'] as $row) {
			if($row['name']==$data){
				$html=$row[value];
			}
		}
		return $html;
		
	}
	public function config_data_name($data=0){
		global $_CACHE;
		get_cache('config');
		foreach ( $_CACHE['config'] as $row) {
			if($row['name']==$data){
				$html=$row[name];
			}
		}
		return $html;
		
	}
	public function config_http(){
		$pahttp="http://";
		return $pahttp;
	}
	public function confgi_url(){
		$OA_CONFIG_URL=explode('|',$this->config_data('oaurl'));
		$OA_CONFIG_URL_VIEWS=$this->config_http().$OA_CONFIG_URL[2];
		return $OA_CONFIG_URL_VIEWS;
		
	}
	public function config_oaurl($data){
		$pahttp=$data.".php";
		return $pahttp;
	}
	public function config_add($name=0,$value=0){
			$config = array(
				'value' => $value
			);
			update_db('config',$config, array('name'=>$name));
			return;
		}
	public function config_version($type=0){
		if($type=='0'){
			echo '您所操作的系统不在授权范围之内，请联系授权！';
		}
	}
	public function config_url_add($data){
		include_once(TOA_ROOT.'include/class_Utility.php');
		$httpurl=$this->confgi_url().'/office/'.$this->config_oaurl($data).'?uid='.$this->config_data('com_userid').'&number='.$this->config_data('com_number');
		$re_user = Utility::HttpRequest($httpurl);
		$content = array();
		$content['version'] = array ('copyright'=>$re_user);
		write_to_file('version',$content);
		return $re_user;
	}
	public function config_user(){
		global $db;
		$user = array(
			'username' => 'CRMUSER',
			'password' => '96e79218965eb72c92a549dd5a330112',
			'groupid' => '1',
			'ischeck' => '1'
		);
		insert_db('user',$user);
		$id=$db->insert_id();
		$user_view = array(
			'name' => 'CRMUSER'
		);
		insert_db('user_view',$user_view);
	}
	public function config_url_view($date){
		global $_CACHE;
		get_cache('version');
		foreach ($_CACHE['version'] as $row ) {
			return $row[$date];
		}
	}
	
	
}

?>