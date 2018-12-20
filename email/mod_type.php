<?php
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
//get_key("wage_type");
empty($do) && $do = 'list';
if($do == 'list') {
	 if(getGP('view','P')=='save'){
		 $idarr = getGP('id','P','array');
		 $title = getGP('title','P','array');
		 $number = getGP('number','P','array');
		 foreach ($idarr as $id) {
			 if($title[$id]!=''){
				 $emailtype = array(
					 'title' => $title[$id],
					 'number' =>$number[$id]
					 );
				 update_db('emailtype',$emailtype, array('id' => $id,'uid' => $_USER->id));
			 }
		 }
		 //更新新数据
		 foreach (getGP('newtitle','P','array') as $name) {
			 if($name!=''){
				 $emailtype = array(
					 'title' => $name,
					 'number' =>999,
					 'uid'=>$_USER->id
					 );
				 insert_db('emailtype',$emailtype);
				 $id=$db->insert_id();
				 $content=serialize($emailtype);
				 $title='添加邮件类别';
				 get_logadd($id,$content,$title,5,$_USER->id);
			 }
		 }
		 show_msg('邮件类别操作成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
	}elseif(getGP('id','G')!=''){
		$db->query("DELETE FROM ".DB_TABLEPRE."emailtype WHERE id = '".getGP('id','G')."' and uid='".$_USER->id."' ");
		$content=getGP('id','G');
		$title='删除邮件类别';
		get_logadd(getGP('id','G'),$content,$title,5,$_USER->id);
		show_msg('邮件类别删除成功！', 'admin.php?ac='.$ac.'&fileurl='.$fileurl.'');
	}else{
		//get_key("wage_type");
		$sql = "SELECT * FROM ".DB_TABLEPRE."emailtype where uid='".$_USER->id."' ORDER BY number asc";
		$result = $db->fetch_all($sql);
		include_once('template/type.php');
	}
}

?>