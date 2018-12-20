<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: sms.class.php 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/
!defined('IN_TOA') && exit('Access Denied!');

function SMS_ADD_POST($person=0,$content=0,$type,$url=0,$userid)
{
    //发送消息表
	
	$sms_send = array(
		'receiveperson' => $person,
		'content' => $content,
		'uid' => $userid,
		'date' => get_date('y-m-d H:i:s',PHP_TIME)
	);
	insert_db('sms_send',$sms_send);

	global $db;
	$blog = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."sms_send  WHERE receiveperson = '".$person."' and uid='".$userid."' order by id desc");
	$id=$blog["id"];
	weixinsms($person,$content);
	//获取字符串
	$receivepersonarr=explode(',',$person); 
	//发送消息表
	for($i=0;$i<sizeof($receivepersonarr);$i++)
	{
	//接收消息表
	
	$sms_receive = array(
		'sendperson' => $userid,
		'date' => get_date('y-m-d H:i:s',PHP_TIME),
		'content' => $content,
		'receiveperson' => get_userid($receivepersonarr[$i]),
		'type' => '2',
		'smskey' => '1',
		'sendid'=>$id
	);
	//接收消息表
	insert_db('sms_receive',$sms_receive);
	}
	
	if($id!='')
	{
   $oalog = array(
		'uid' => $userid,
		'content' => $content.get_log(1).$person,
		'title' => '发布短消息',
		'startdate' => get_date('Y-m-d H:i:s',PHP_TIME),
		'contentid' => $id,
		'type' => '4'
	);
	insert_db('oalog',$oalog);
	
	}
	if($type=='1'){
	goto_page($url);
	}
}
//手机短信发送
function PHONE_ADD_POST($person=0,$content=0,$receiveperson=0,$type=0,$url=0,$userid=0)
{
    //判断当前可用通道
	global $db;
	$blog = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."phone_channel where id=1 and pkey='1' and (type='2' or type='3') order by id desc");
	//获取账户信息
	$username=$blog["username"];
	$password=$blog["password"];
	//获取接口信息
	$connection=explode('#515158#',$blog["connection"]); 
	$personfor=explode(',',$person);
	$receivepersonfor=explode(',',$receiveperson);
	//$ef='';
	for($i=0;$i<sizeof($personfor);$i++){
		if($personfor[$i]!=''){
			$date=get_date('y-m-d H:i:s',PHP_TIME);
			$sms_add=explode('#01',$connection[2]);
			$ugcode_vod= new ugcode();
			$contentgdb2312=$ugcode_vod->ugcode_vod(1,$content);
			$phoneurl=$sms_add[0].trim($username).$sms_add[1].trim($password).$sms_add[2].trim($personfor[$i]).$sms_add[3].trim($contentgdb2312).$sms_add[4].$sms_add[5];
			
			$res = Utility::HttpRequest($phoneurl);
			if($blog["connectionid"]=='1'){
				$res_sms=explode('/',$res);
				if($res_sms[0]=='000'){$type='1';}else{$type='2';}
			}else{
				$res_sms=explode('&',$res);
				if($res_sms[0]=='result=0'){$type='1';}else{$type='2';}
			}
			//数据入库
			$phone_send = array(
				'content' => $content,
				'receivephone' => $personfor[$i],
				'sendperson' => $userid,
				'receiveperson' => $receivepersonfor[$i],
				'date' => get_date('y-m-d H:i:s',PHP_TIME),
				'type' => $type,
				'channelid'=>$blog["id"]
			);
			insert_db('phone_send',$phone_send);
			sleep(1);
		}
	}
	
}
?>