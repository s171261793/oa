<?php
/*
	[Office 515158] (C) 2009-2012 天生创想 Inc.
	$Id: oa 1209087 2012-01-08 08:58:28Z baiwei.jiang $
*/
(!defined('IN_TOA') || !defined('IN_ADMIN')) && exit('Access Denied!');
empty($do) && $do = 'list';
if ($do == 'list') {
	if($_GET['officeid']!=''){
		$sql = "SELECT * FROM ".DB_TABLEPRE."fileoffice WHERE officeid='".$_GET['officeid']."' and officetype='".$_GET['officetype']."' and filetype='2' ORDER BY id desc";
	}else{
		$sql = "SELECT * FROM ".DB_TABLEPRE."fileoffice WHERE number='".$_GET['filenumber']."' and officetype='".$_GET['officetype']."' and filetype='2' ORDER BY id desc";
	}
	
	$result = $db->query($sql);
	while ($row = $db->fetch_array($result)) {	
		echo '<a href="downurl.php?urls='.$row['fileaddr'].'&filename='.urlencode($row['filename']).'">'.$row['filename'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;上传人：'.get_realname($row['uid']).'&nbsp;&nbsp;&nbsp;&nbsp;上传时间：'.$row['date'].'<br>';
	}
}elseif($do=='del'){
	$db->query("DELETE FROM ".DB_TABLEPRE."fileoffice WHERE id='".getGP('id','G','int')."' and uid = '".$_USER->id."' ");
	echo 'ok';
}elseif($do=='newfile'){
	$sql = "SELECT * FROM ".DB_TABLEPRE."fileoffice WHERE number='".getGP('filenumber','G','int')."' and officetype='".getGP('officetype','G','int')."' and filetype='2' ORDER BY id desc";
	$result = $db->query($sql);
	while ($row = $db->fetch_array($result)) {
		$extention=preg_replace('/.*\.(.*[^\.].*)*/iU','\\1',$row['filename']);
		echo '<tr class="TableData" style="line-height:30px;">';
		echo '<td style="padding-left:35px;" align="left">';
		echo '<span class="attach_link attach_link_block" style="white-space: inherit;">';
		if(strtolower($extention)=='doc' || strtolower($extention)=='docx'){
			echo '<img src="template/default/images/doc.gif" align="absmiddle"> ';
			$add='<a href="ntko/fileviews.php?fileType=word&number='.$row['number'].'&fileaddr='.$row['fileaddr'].'&title='.urldecode($row['filename']).'&date='.$row['date'].'" target="_blank">打开</a> ';
		}elseif(strtolower($extention)=='xls' || strtolower($extention)=='xlsx'){
			echo '<img src="template/default/images/xls.gif" align="absmiddle"> ';
			$add='<a href="ntko/fileviews.php?fileType=excel&number='.$row['number'].'&fileaddr='.$row['fileaddr'].'&title='.urldecode($row['filename']).'&date='.$row['date'].'" target="_blank">打开</a> ';
		}elseif(strtolower($extention)=='ppt'){
			echo '<img src="template/default/images/ppt.gif" align="absmiddle"> ';
			$add='<a href="ntko/fileviews.php?fileType=ppt&number='.$row['number'].'&fileaddr='.$row['fileaddr'].'&title='.urldecode($row['filename']).'&date='.$row['date'].'" target="_blank">打开</a> ';
		}elseif(strtolower($extention)=='pdf' || strtolower($extention)=='tif'){
			echo '<img src="template/default/images/pdf.gif" align="absmiddle"> ';
			$add='<a href="ntko/fileviews.php?fileType=pdf&number='.$row['number'].'&fileaddr='.$row['fileaddr'].'&title='.urldecode($row['filename']).'&date='.$row['date'].'" target="_blank">打开</a> ';
		}elseif($extention=='jpg' || $extention=='gif' || $extention=='png' || $extention=='bmp'){
			echo '<img src="template/default/images/thumb.gif" align="absmiddle"> ';
			$add='<a href="ntko/pic.php?fileaddr='.$row['fileaddr'].'&title='.urldecode($row['filename']).'&date='.$row['date'].'" target="_blank">查看</a> ';
		}else{
			echo '<img src="template/default/images/page.gif" align="absmiddle"> ';
			$add='';
		}
		echo '<a class="attach_name" href="downurl.php?urls='.$row['fileaddr'].'&filename='.urlencode($row['filename']).'">'.$row['filename'].'</a>';
		echo '</span>';
		//echo '<div class="attach_div"><a href="down.php?urls='.$row['fileaddr'].'">下载</a> ';
		echo '<div class="attach_div"><a href="downurl.php?urls='.$row['fileaddr'].'&filename='.urlencode($row['filename']).'">下载</a> ';
		//echo '<a href="javascript:;" data-group="4dad7796">播放</a> ';
		echo $add;
		//echo '<a href="javascript:;" onClick="#">转存</a> ';
		if($row['uid']==$_USER->id && getGP('view','G','int')!=1){
			echo '<a href="javascript:;" onClick="delfiles('.$row['id'].');">删除</a>';
		}
		echo '</div></td>';
		echo '<td align="center">'.sprintf("%.2f", (filesize($row['fileaddr'])*0.001)).'KB</td>';
		echo '<td align="center">'.get_realname($row['uid']).'</td>';
		echo '<td align="center">'.$row['date'].'</td>';
		echo '</tr>';
	}
}elseif($do=='office'){
	if($_GET['officeid']!=''){
		$sql = "SELECT * FROM ".DB_TABLEPRE."fileoffice WHERE officeid='".$_GET['officeid']."' and officetype='".$_GET['officetype']."' and filetype='1' ORDER BY id desc";
	}else{
		$sql = "SELECT * FROM ".DB_TABLEPRE."fileoffice WHERE number='".$_GET['filenumber']."' and officetype='".$_GET['officetype']."' and filetype='1' ORDER BY id desc";
	}
	$result = $db->query($sql);
	while ($row = $db->fetch_array($result)) {
		if($_GET['viewtype']==5){
			echo '<a target="_blank" href="ntko/Fileview.php?id='.$row['id'].'&uid='.$_USER->id.'&filenumber='.$row['number'].'&officetype='.$row['officetype'].'&date='.$row['date'].'">'.$row['filename'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;上传人：'.get_realname($row['uid']).'&nbsp;&nbsp;&nbsp;&nbsp;上传时间：'.$row['date'].'<br>';
		}else{
			echo '<a target="_blank" href="ntko/FileEdit.php?FileId='.$row['fileid'].'&uid='.$_USER->id.'&filenumber='.$row['number'].'&officetype='.$row['officetype'].'&date='.$row['date'].'">'.$row['filename'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;上传人：'.get_realname($row['uid']).'&nbsp;&nbsp;&nbsp;&nbsp;上传时间：'.$row['date'].'<br>';
		}
	}
}
?>
