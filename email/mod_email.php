<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
empty($do) && $do = 'list';
if ($do == 'list') {
	include_once('template/email.php');
}elseif ($do == 'email') {
	//列表信息 
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac=email&fileurl=email&do=email';
		$vstartdate = getGP('vstartdate','G');
		$venddate = getGP('venddate','G');
		if ($vstartdate!='' && $venddate!='') {
			$wheresql .= " AND (date>='".$vstartdate."' and date<='".$venddate."')";
			$url .= '&vstartdate='.$vstartdate.'&venddate='.$venddate;
		}
		$type = getGP('type','G');
		$url .= '&type='.$type;
		if ($type==0) {
			$wheresql .= " AND type='0' ";
		}elseif ($type==2) {
			$wheresql .= " AND type='2' ";
		}else{
			$wheresql .= " AND (type='0' or type='1')  ";
		}
		if ($typeid=getGP('typeid','G')) {
			$wheresql .= " AND typeid='".$typeid."' ";
			$url .= '&typeid='.$typeid;
		}
		//权限判断
		$un = getGP('un','G');
		$ui = getGP('ui','G');
		if(!is_superadmin() && $ui==''){
			$wheresql .= " and receuser='".$_USER->id."'";
		}
		if ($ui!='') {
			$wheresql .= " and receuser in(".$ui.")";
			$url .= '&ui='.$ui.'&un='.$un;
		}
		$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."recemail WHERE 1 $wheresql  order by date desc");
		$sql = "SELECT * FROM ".DB_TABLEPRE."recemail WHERE 1 $wheresql  order by date desc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	include_once('template/list.php');
}elseif ($do == 'send') {
	//列表信息 
	$wheresql = '';
	$page = max(1, getGP('page','G','int'));
	$pagesize = $_CONFIG->config_data('pagenum');
	$offset = ($page - 1) * $pagesize;
	$url = 'admin.php?ac=email&do=send&fileurl=email';
		$vstartdate = getGP('vstartdate','G');
		$venddate = getGP('venddate','G');
		if ($vstartdate!='' && $venddate!='') {
			$wheresql .= " AND (date>='".$vstartdate."' and date<='".$venddate."')";
			$url .= '&vstartdate='.$vstartdate.'&venddate='.$venddate;
		}

		if ($type = getGP('type','G')) {
			$wheresql .= " AND type='".$type."' ";
			$url .= '&type='.$type;
		}
		//权限判断
		$un = getGP('un','G');
		$ui = getGP('ui','G');
		if(!is_superadmin() && $ui==''){
			$wheresql .= " and user='".$_USER->id."'";
		}
		if ($ui!='') {
			$wheresql .= " and user in(".$ui.")";
			$url .= '&ui='.$ui.'&un='.$un;
		}
		$num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."sendmail WHERE 1 $wheresql  order by date desc");
		$sql = "SELECT * FROM ".DB_TABLEPRE."sendmail WHERE 1 $wheresql  order by date desc LIMIT $offset, $pagesize";
	$result = $db->fetch_all($sql);
	include_once('template/send.php');
}elseif ($do == 'add') {
	if($_POST['view']!=''){
		$subject = check_str(getGP('subject','P'));
		$receuser = check_str(getGP('receuser','P'));
		$ccuser = check_str(getGP('ccuser','P'));
		$bssuser = check_str(getGP('bssuser','P'));
		$webuser = check_str(getGP('webuser','P'));
		$type = check_str(getGP('type','P'));
		//获取附件包
		$append='';
		$query = $db->query("SELECT * FROM ".DB_TABLEPRE."fileoffice where number='".getGP('filenumber','P')."' and officetype=10 and filetype=2 ORDER BY id Asc");
		while ($row = $db->fetch_array($query)) {
			$append.=$row['filename'].'|'.$row['fileaddr'].'||';
		}
		$appendix = $append;
		if($type!=1){
			$db->query("DELETE FROM ".DB_TABLEPRE."fileoffice WHERE number='".getGP('filenumber','P')."' and officetype=10 and filetype=2 ");
		}
		$content = trim(getGP('content','P'));
		$user=$_USER->id;
		$date = get_date('Y-m-d H:i:s',PHP_TIME);
		//发送邮件
		$sendmail = array(
			'subject' => $subject,
			'receuser' => $receuser,
			'ccuser' => $ccuser,
			'bssuser' => $bssuser,
			'webuser' => $webuser,
			'appendix' => $appendix,
			'content' => $content,
			'type' => $type,
			'user' => $user,
			'date' => $date
		);
		insert_db('sendmail',$sendmail);
		$id=$db->insert_id();
		if($type!=1){
		//更新附件
			$fileoffice = array(
				'officeid' => $id
			);
			update_db('fileoffice',$fileoffice, array('number' =>$_POST['filenumber'],'officetype' =>10));
		}
		//收件箱　收件人
		$receuserid = check_str(getGP('receuserid','P'));
		if($receuserid!=''){
			$receuserid=explode(',',$receuserid);
			for($i=0;$i<sizeof($receuserid);$i++){
				$recemail = array(
					'subject' => $subject,
					'receuser' => $receuserid[$i],
					'user' => $user,
					'appendix' => $appendix,
					'content' => $content,
					'type' => 0,
					'date' => get_date('y-m-d H:i:s',PHP_TIME),
					'sendid' => $id,
					'typeid' => 0
				);
				insert_db('recemail',$recemail);
			}
		}
		//收件箱　抄送人
		$ccuserid = check_str(getGP('ccuserid','P'));
		if($ccuserid!=''){
			$ccuserid=explode(',',$ccuserid);
			for($i=0;$i<sizeof($ccuserid);$i++){
				$recemail = array(
					'subject' => $subject,
					'receuser' => $ccuserid[$i],
					'user' => $user,
					'appendix' => $appendix,
					'content' => $content,
					'type' => 0,
					'date' => get_date('y-m-d H:i:s',PHP_TIME),
					'sendid' => $id,
					'typeid' => 0
				);
				insert_db('recemail',$recemail);
			}
		}
		//收件箱　密送人
		$bssuserid = check_str(getGP('bssuserid','P'));
		if($bssuserid!=''){
			$bssuserid=explode(',',$bssuserid);
			for($i=0;$i<sizeof($bssuserid);$i++){
				$recemail = array(
					'subject' => $subject,
					'receuser' => $bssuserid[$i],
					'user' => $user,
					'appendix' => $appendix,
					'content' => $content,
					'type' => 0,
					'date' => get_date('y-m-d H:i:s',PHP_TIME),
					'sendid' => $id,
					'typeid' => 0
				);
				insert_db('recemail',$recemail);
			}
		}
		//发送外部邮件
		//$webuser = check_str(getGP('webuser','P'));
	   
		show_msg('邮件信息发送成功！'.$Message, 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=addtrue');
	}else{
		$filenumber=random(6,'0123456789').get_date('ymdHis',PHP_TIME);
		$sendid=getGP('sendid','G');
		$type=getGP('type','G');
		$sql = "SELECT * FROM ".DB_TABLEPRE."sendmail  WHERE id = '".$sendid."'";
		$row = $db->fetch_one_array($sql);
		$mailsignaturesql = "SELECT * FROM ".DB_TABLEPRE."mailsignature  WHERE uid = '".$_USER->id."'";
		$mailsignature = $db->fetch_one_array($mailsignaturesql);
		include_once('template/emailadd.php');
	}
}elseif ($do == 'type') {
	$db->query("update ".DB_TABLEPRE."recemail set typeid='".getGP('typeid','G')."' where id = '".getGP('id','G')."'");
	show_msg('己成功将邮件转到'.getGP('title','G').'！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'&do=view&id='.getGP('id','G'));

}elseif ($do == 'view') {
	$sql = "SELECT * FROM ".DB_TABLEPRE."recemail  WHERE id = '".getGP('id','G')."'";
	$row = $db->fetch_one_array($sql);
	//标志为己读
	$db->query("update ".DB_TABLEPRE."recemail set type=1 where id = '".getGP('id','G')."'");
	include_once('template/view.php');
}elseif ($do == 'sendview') {
	$sql = "SELECT * FROM ".DB_TABLEPRE."sendmail  WHERE id = '".getGP('id','G')."'";
	$row = $db->fetch_one_array($sql);
	include_once('template/sendview.php');
}elseif ($do == 'update') {
	//get_key("wage_delete");
	if(getGP('type','G')==''){
		$idarr = getGP('id','P','array');
		foreach ($idarr as $id) {
			$db->query("DELETE FROM ".DB_TABLEPRE."recemail WHERE id = '$id' ");
		}
		show_msg('己成功将邮件删除！', 'admin.php?ac=email&fileurl=email&do=email&type=1');
	}
	if(getGP('type','G')==2){
		$id = getGP('id','G');
		$db->query("update ".DB_TABLEPRE."recemail set type=2 where id = '".$id."'");
		show_msg('己成功将邮件放到回收站！', 'admin.php?ac=email&fileurl=email&do=email&type=1');
		exit;
	}else{
		$id = getGP('id','G');
		$db->query("DELETE FROM ".DB_TABLEPRE."recemail where id = '$id' ");
		show_msg('己成功将邮件删除！', 'admin.php?ac=email&fileurl=email&do=email&type=1');
		exit;
	}
}elseif ($do == 'updatesend') {
		$idarr = getGP('id','P','array');
		foreach ($idarr as $id) {
			$db->query("DELETE FROM ".DB_TABLEPRE."sendmail WHERE id = '$id' ");
		}
		show_msg('己成功将邮件删除！', 'admin.php?ac=email&fileurl=email&do=send&type='.getGP('type','P'));
	
}elseif ($do == 'addtrue') {
	include_once('template/addtrue.php');
}
?>