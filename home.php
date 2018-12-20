<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: home.php 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/
define('IN_ADMIN',True);
require_once('include/common.php');
require_once('include/function_home.php');
require_once('include/function_charts.php');
get_login($_USER->id);
$sql = "SELECT homemana,homebg,pic,sex,home_txt,hometype FROM ".DB_TABLEPRE."user_view  WHERE uid='".$_USER->id."'";
$bguser = $db->fetch_one_array($sql);

	if($bguser['homebg']!=''){
		$bg=''.$bguser['homebg'];
	}else{
		$bg='template/default/home/images/wallpaper.jpg';
	}
	if($_GET['mid']==3){
		$bguser['home_txt']='home_workdate,home_duty,home_blog,home_conference,home_plan,home_document_1,home_news_34,home_news_1,home_news_6,home_news_5,';
		include_once template.'home_text.php';
		//header('Location: admin.php?ac=workdate&fileurl=workbench');
	}elseif($_GET['mid']==4){
		include_once template.'home_text_work.php';
		//header('Location: admin.php?ac=list&fileurl=workclass');
	}elseif($_GET['mid']==7){
		$bguser['home_txt']='home_company|46,home_care|158,home_service|172,home_complaints|159,home_offer|160,home_program|161,home_contract|173,home_order|162,home_price|290,home_payment|291,home_supplier|165,home_purchase|166,home_business|288,';
		$home_key='1';
		include_once template.'home_text.php';
	}elseif($_GET['mid']==10){
		if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'toa_book'"))==1 && mysql_num_rows(mysql_query("SHOW TABLES LIKE 'toa_office_goods'"))==1) {
			$bguser['home_txt']='home_book,home_goods,home_conference,home_app1,home_news_34,home_news_1,home_news_5,';
		}else{
			$bguser['home_txt']='home_conference,home_news_34,home_news_1,home_news_5,';
		}
		include_once template.'home_text.php';
	}elseif($_GET['mid']==11){
		header('Location: admin.php?ac=registration&fileurl=human');
	}elseif($_GET['mid']==5){
		header('Location: admin.php?ac=attachment&fileurl=app');
	}elseif($_GET['mid']==6){
		header('Location: admin.php?ac=index&fileurl=file');
	}elseif($_GET['mid']==8){
		header('Location: admin.php?ac=list&fileurl=project');
	}elseif($_GET['mid']==9){
		$bguser['home_txt']='home_document_2,home_bbs,home_document_3,home_document_4,home_document_5,home_document_6,home_knowledge,';
		include_once template.'home_text.php';
	}elseif($_GET['mid']==58){
		header('Location: admin.php?ac=config&fileurl=mana');
	}else{
		include_once template.'home_text.php';
	}
?>