<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
//get_key("wage_type");
empty($do) && $do = 'list';
if($do == 'list') {
	 if(getGP('view','P')=='save'){
		 $content = getGP('content','P');
		 $id = getGP('id','P');
		 if($id!=''){
			 $mailsignature = array(
				 'content' => $content
				 );
			 update_db('mailsignature',$mailsignature, array('id' => $id,'uid' => $_USER->id));
		 }else{
			 $mailsignature = array(
				 'content' => $content,
				 'uid'=>$_USER->id
				 );
			 insert_db('mailsignature',$mailsignature);
		 }
		 show_msg('邮件签名操作成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
	}else{
		$row = $db->fetch_one_array("SELECT * FROM ".DB_TABLEPRE."mailsignature where uid='".$_USER->id."' ORDER BY id asc");
		include_once('template/mailsignature.php');
	}
}

?>