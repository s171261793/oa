<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<title>信息添加编辑</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="template/default/js/jquery.min.js"></script>
<script charset="utf-8" src="eweb/kindeditor.js"></script>
</head>
<body class="bodycolor" <?php if($row['ccuser']!='' && $type==4){?>onLoad="checkbox(1);"<?php }?> <?php if($row['bssuser']!='' && $type==4){?>onLoad="checkbox(2);"<?php }?>  <?php if($row['webuser']!='' && $type==4){?>onLoad="checkbox(3);"<?php }?>>
<table width="80%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 发送邮件</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right;margin-right:20px;">
	
	<a href="javascript:;" onClick="checkbox(1);" style="font-size:12px;">添加抄送</a>
	&nbsp;&nbsp;-&nbsp;&nbsp;
	<a href="javascript:;" onClick="checkbox(2);" style="font-size:12px;">添加密送</a>
	<!--&nbsp;&nbsp;-&nbsp;&nbsp;
	<a href="javascript:;" onClick="checkbox(3);" style="font-size:12px;">添加外部收件人</a> -->
	</span>
    </td>
  </tr>
</table>

<script Language="JavaScript">
filenumber_show()
function filenumber_show()
{
   jQuery.ajax({
      type: 'GET',
      url: 'admin.php?ac=file&fileurl=public&filenumber=<?php echo $filenumber?>&officetype=10&'+new Date(),
      success: function(data){
		  if(data!=''){
			  $("#filenumber").html(data);
		  }else{
			  $("#filenumber").html('还没有附件!');
		  }
      }
   });
} 
function CheckForm()
{
   if(document.save.subject.value=="")
   { alert("邮件主题不能为空！");
     document.save.subject.focus();
     return (false);
   }
   if(document.save.receuser.value=="")
   { alert("收件人不能为空！");
     document.save.receuser.focus();
     return (false);
   }
   if(document.save.content.value=="")
   { alert("内容不能为空！");
     document.save.content.focus();
     return (false);
   }
   
   return true;
}
function sendForm(type)
{
   if(type==1){
	  document.getElementById("type").value='1';
   }
   if(CheckForm())
      document.save.submit();
}
function checkbox(value){
	if(value==1){
		div1.style.display="block";
	}else if(value==2){
		div2.style.display="block";
	}else if(value==3){
		div3.style.display="block";
	}else if(value==4){
		div1.style.display="none";
	}else if(value==5){
		div2.style.display="none";
	}else if(value==6){
		div3.style.display="none";
	}
}
</script>
<style type="text/css"> 
#div1{
display:none;}
#div2{
display:none;}
#div3{
display:none;}
</style>
<form name="save" method="post" action="?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=add">
	<input type="hidden" name="view" value="edit" />
	<input type="hidden" name="type" value="0" />
	<input type="hidden" name="sendid" value="<?php echo $sendid?>" />
	<input type="hidden" name="filenumber" value="<?php echo $filenumber?>" />
	 <table class="TableBlock" border="0" width="80%" align="center" style="border-bottom:#4686c6 solid 0px;">
	 
	 <tr>
			<td nowrap class="TableContent" width="90">收件人：<? get_helps()?></td>
			  <td class="TableData">
			 <?php
			 if($type==1 || $type==2){
			 	$receuser=get_realname($row['user']);
			 }else{
			 	$receuser='';
			 }
			 get_pubuser(2,"receuser",$receuser,"+选择收件人",60,2)
			 ?>
				</td>  	  	
		</tr>
		</table>
		<div id="div1">
		<table class="TableBlock" border="0" width="80%" align="center" style="border-bottom:0px;border-top:0px;">
		<tr>
			<td nowrap class="TableContent" width="90">抄送人：<? get_helps()?></td>
			  <td class="TableData">
			 <?php
			 if($type==4){
			 	$ccuser=$row['ccuser'];
			 }
			  get_pubuser(2,"ccuser",$ccuser,"+选择抄送人",60,2)
			  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onClick="checkbox(4);" style="font-size:12px;">隐藏</a>
				</td>  	  	
		</tr>
		</table>
		</div>
		<div id="div2">
		<table class="TableBlock" border="0" width="80%" align="center" style="border-bottom:0px;border-top:0px;">
		<tr>
			<td nowrap class="TableContent" width="90">密送人：<? get_helps()?></td>
			  <td class="TableData">
			 <?php
			 if($type==4){
			 	$bssuser=$row['bssuser'];
			 }
			  get_pubuser(2,"bssuser",$bssuser,"+选择密送人",60,2)
			  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onClick="checkbox(5);" style="font-size:12px;">隐藏</a>
				</td>  	  	
		</tr>
		</table>
		</div>
		<div id="div3">
		<table class="TableBlock" border="0" width="80%" align="center" style="border-bottom:0px;border-top:0px;">
		<tr>
		
			<td nowrap class="TableContent" width="90">外部收件人：<? get_helps()?></td>
		  <td class="TableData">
		  <?php
		  if($type==4){
			 	$webuser=$row['webuser'];
			 }
		  ?>
			 <input type="text" class="BigInput" name="webuser" value="<?php echo $webuser;?>" style="width:300px;">
			&nbsp;&nbsp;
			<select name="popmail">
			  <option value="0" selected="selected">选择发件邮箱</option>
			  <?php
				$sql = "SELECT mail,id FROM ".DB_TABLEPRE."popmail where uid='".$_USER->id."' ORDER BY id asc";
				$result = $db->query($sql);
				while ($rows = $db->fetch_array($result)) {
				?>
			  <option value="<?php echo $rows['id']?>"><?php echo $rows['mail']?></option>
			  <?php }?>
		    </select>			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onClick="checkbox(6);" style="font-size:12px;">隐藏</a></td>  	  	
		</tr>
		</table>
		</div>
		<table class="TableBlock" border="0" width="80%" align="center" style="border-bottom:0px;border-top:0px;">
		<tr>
			<td nowrap class="TableContent" width="90">邮件主题：<? get_helps()?></td>
			  <td class="TableData">
			  <?php
			  if($sendid!=''){
			  	$subject='回复:'.$row['subject'];
			  }
			  ?>
					<input type="text" class="BigInput" name="subject" value="<?php echo $subject;?>" style="width:400px;" >
				</td>  	  	
		</tr>
	</table>	
	<table  width="80%" style="border-left:#4686c6 solid 1px;border-right:#4686c6 solid 1px;" align="center">	
		<tr>
			<td nowrap class="TableContent" width="94" style="border-right:#cccccc solid 1px;">邮件内容：</td>
			  <td class="TableData" style="padding-top:10px; padding-bottom:10px; padding-left:3px;">
			  
			  <script>
        KE.show({
                id : 'content'
        });
</script>
				<textarea name="content" rows="5" cols="60" style="width:535px;height:300px;"><?php
if($type!='1'){
echo '<br><br><br>'.$mailsignature['content'].'<br><br><br>'.$row['content'];
}				

?></textarea>
			</td>
		</tr>
		</table>
		<table class="TableBlock" border="0" width="80%" align="center" >
<tr>
      <td nowrap class="TableHeader" colspan="2" id="m2"><b>&nbsp;附件设置</b></td>
    </tr>  
	<tr>
      <td nowrap class="TableContent" width="15%">己上传附件：</td>
      <td class="TableData" id="filenumber">
	  
	  </td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%">附件操作：</td>
      <td class="TableData">
	  <input type="hidden" name="annexurlid" class="BigInput"  onpropertychange="filenumber_show();" />
	  <a href="#m2" onClick="window.open ('admin.php?ac=uploadadd&fileurl=public&name=annexurlid&filenumber=<?php echo $filenumber?>&officetype=10', 'newwindow', 'height=200, width=480, top=0, left=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')">+上传附件</a></td>
    </tr>
</table>
  <table class="TableBlock" border="0" width="80%" align="center" style="border-top:#4686c6 solid 0px;">
		
		<tr align="center" class="TableControl">
			<td colspan="2" nowrap>
			<input type="button" value="发送邮件" class="BigButtonBHover" onClick="sendForm();">&nbsp;&nbsp;&nbsp;&nbsp;
			<!--<input type="button" value="保存草稿" class="BigButtonBHover" onClick="sendForm(1);">&nbsp;	     --></td>
	  </tr>
	 </table>
  
</form>

 
</body>
</html>
