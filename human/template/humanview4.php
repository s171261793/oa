<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script src="template/default/tree/js/admincp.js?SES" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="template/default/js/jquery.min.js"></script>
<script charset="utf-8" src="eweb/kindeditor.js"></script>
<script type="text/javascript"> 
function show_help()
{
   mytop=(screen.availHeight-430)/2;
   myleft=(screen.availWidth-800)/2;
   window.open("admin.php?ac=view&fileurl=help&helpid=<?php echo $fileurl?>","","height=470,width=800,status=0,toolbar=no,menubar=no,location=no,scrollbars=yes,top="+mytop+",left="+myleft+",resizable=yes");
}
filenumber_show()
function filenumber_show()
{
   jQuery.ajax({
      type: 'GET',
      url: 'admin.php?ac=file&fileurl=public&filenumber=<?php echo $filenumber?>&officetype=4&'+new Date(),
      success: function(data){
		  if(data!=''){
			  $("#filenumber").html(data);
		  }else{
		  	  <? if($blog['id']==''){?>
			  $("#filenumber").html('还没有附件!');
			  <? }?>
		  }
      }
   });
}
</script>
<title>Office 515158 2011 OA办公系统</title>
 
</head>
<body class="bodycolor">
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 查询<?php echo $human_type_name?>信息</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right;margin-right:20px;">
	
	<a href="admin.php?ac=humanlist&fileurl=<?php echo $fileurl?>&type=<?php echo $type?>" style="font-size:12px;"><<返回列表页</a></span>
    </td>
  </tr>
</table>

<form name="save" method="post" action="#">
<table class="TableBlock" width="80%" align="center">
   <tr>
      <td nowrap class="TableContent">单位员工：</td>
      <td class="TableData">
      <?php echo $blog['username']?>
      </td>
      <td nowrap class="TableContent">担任职务：</td>
      <td class="TableData"><?php echo get_human_db($blog['id'],"toa_4_POST_OF_JOB")?></td>
    </tr>
    <tr>
    	 <td nowrap class="TableContent">所在部门：    	 	</td><td class="TableData"><?php echo get_human_db($blog['id'],"toa_4_WORK_BRANCH")?></td>
    	<td nowrap class="TableContent">证明人：</td>
      <td class="TableData"><?php echo get_human_db($blog['id'],"toa_4_WITNESS")?></td>
    </tr>
    <tr>
      <td nowrap class="TableContent">开始日期：</td>
      <td class="TableData"><?php echo get_human_db($blog['id'],"toa_4_START_DATE")?></td>
      <td nowrap class="TableContent">结束日期：</td>
      <td class="TableData"><?php echo get_human_db($blog['id'],"toa_4_END_DATE")?></td>
    </tr>
    <tr>
    	<td nowrap class="TableContent">行业类别：</td>
      <td class="TableData" colspan=3><?php echo get_human_db($blog['id'],"toa_4_MOBILE")?></td>
    </tr>
    <tr>
      <td nowrap class="TableContent">工作单位：</td>
      <td class="TableData" colspan=3><?php echo get_human_db($blog['id'],"toa_4_WORK_UNIT")?></td>
    </tr>
    <tr>
      <td nowrap class="TableContent">工作内容：</td>
      <td class="TableData" colspan=3><?php echo get_human_db($blog['id'],"toa_4_WORK_CONTENT")?></td>
    </tr>
    <tr>
      <td nowrap class="TableContent">离职原因：</td>
      <td class="TableData" colspan=3><?php echo get_human_db($blog['id'],"toa_4_REASON_FOR_LEAVING")?></td>
    </tr>
	<tr>
      <td nowrap class="TableContent">主要业绩：</td>
      <td class="TableData" colspan=3><?php echo get_human_db($blog['id'],"toa_4_KEY_PERFORMANCE")?></td>
    </tr> 
    <tr>
      <td nowrap class="TableContent">备注：</td>
      <td class="TableData" colspan=3><?php echo get_human_db($blog['id'],"toa_4_REMARK")?></td>
    </tr> 
    <tr class="TableData" id="attachment2">
      <td nowrap class="TableContent">附件文档：</td>
      <td nowrap colspan=3 >  
	  <?php
	global $db;
	$sql = "SELECT * FROM ".DB_TABLEPRE."fileoffice WHERE officeid='".$blog['id']."' and officetype='4' and filetype='2' ORDER BY id desc";
	$result = $db->query($sql);
	while ($row = $db->fetch_array($result)) {	
		echo '<a href="down.php?urls='.$row['fileaddr'].'">'.$row['filename'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;上传人：'.get_realname($row['uid']).'&nbsp;&nbsp;&nbsp;&nbsp;上传时间：'.$row['date'].'<br>';
	}
	
	?>    
      </td>
   </tr>  
	
  </table>

	
	
	
	


</form>

 
</body>
</html>
