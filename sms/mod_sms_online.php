
<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');

get_key("office_info_Increase");
empty($do) && $do = 'list';
if ($do == 'list') {
	$name=getGP('user','G');
	$uid=getGP('id','G','int');
	$user = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."user  WHERE id = '".$uid."'  ");
	include_once('template/online_add.php');

} elseif ($do == 'view') {
	
    $wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	
	$receiveperson = getGP('receiveperson','G','int');
	$url = 'admin.php?ac=sms_online&fileurl=sms&do=view&receiveperson='.$receiveperson;
    $num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."sms_receive where (sendperson='".$_USER->id."' and receiveperson='".$receiveperson."') or (receiveperson='".$_USER->id."' and sendperson='".$receiveperson."') ORDER BY date desc");
    $sql = "SELECT * FROM ".DB_TABLEPRE."sms_receive where (sendperson='".$_USER->id."' and receiveperson='".$receiveperson."') or (receiveperson='".$_USER->id."' and sendperson='".$receiveperson."') ORDER BY date desc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	include_once('template/online_receive.php');

}elseif ($do == 'ajax') {
	$receiveperson = getGP('receiveperson','G','int');
	$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."sms_receive where (sendperson='".$_USER->id."' and receiveperson='".$receiveperson."') or (receiveperson='".$_USER->id."' and sendperson='".$receiveperson."') ORDER BY date desc");
	if($num>=10){
		$num=$num-10;
	}else{
		$num=0;
	}
	$db->query("update ".DB_TABLEPRE."sms_receive set online=1,smskey=2 WHERE receiveperson = '".$_USER->id."'  ");
	$sql = "SELECT * FROM ".DB_TABLEPRE."sms_receive where (sendperson='".$_USER->id."' and receiveperson='".$receiveperson."') or (receiveperson='".$_USER->id."' and sendperson='".$receiveperson."') ORDER BY date asc LIMIT ".$num.",10";
	$result = $db->fetch_all($sql);
	$i=0;
	foreach ($result as $row) {
			
		//过滤下载
		$content=str_replace("data/uploadfile/","down.php?urls=data/uploadfile/",$row['content']);
		$content=str_replace('target="_blank"',"",$content);
		$content=str_replace('&',"-",$content);
		$content=str_replace('admin.php?ac=',"admin.php?ac=receive&fileurl=sms&do=smskeymana&id=".$row['id']."&urls=",$content);
		$content=str_replace('<a',"&nbsp;&nbsp;<a",$content);
		if($row['pic']!=''){
			$src=$row['pic'];
		}else{
			$src='template/default/images/sex01.gif';
		}
		echo "<div class='message clearfix'>
		<div class='user-logo'>
		<img src='".$src."'/>
		</div>
		<div class='wrap-text'>
		<h5 class='clearfix'>".get_realname($row['sendperson'])."</h5>
		<div>".$content."</div>
		</div>
		<div class='wrap-ri'>
		<div clsss='clearfix'><span>".$row['date']."</span></div>
		</div>
		<div style='clear:both;'></div>
		</div>";
	}
}elseif ($do == 'add') {
	$receiveperson = getGP('receiveperson','G','int');
	//发送消息表
	$sms_send = array(
		'receiveperson' => get_realname($receiveperson),
		'content' => unescape(getGP('content','G')),
		'uid' => $_USER->id,
		'date' => get_date('Y-m-d H:i:s',PHP_TIME)
	);
	insert_db('sms_send',$sms_send);
	$id=$db->insert_id();
	$sms_receive = array(
		'sendperson' => $_USER->id,
		'date' => get_date('Y-m-d H:i:s',PHP_TIME),
		'content' => unescape(getGP('content','G')),
		'receiveperson' => $receiveperson,
		'type' => '2',
		'smskey' => '1',
		'sendid'=>$id
	);
	//接收消息表
	insert_db('sms_receive',$sms_receive);
	weixinsms(get_realname($receiveperson),unescape(getGP('content','G')));
	//echo $receiveperson.'fdsa'.$_GET['content'];
	//exit;
}
?>