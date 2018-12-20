<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<title>信息添加编辑</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
</head>
<body class="bodycolor">
<table width="550" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3">日程信息<?php echo $_title['name']?></span>&nbsp;&nbsp;&nbsp;&nbsp;
	<!--<span style="font-size:12px;">
	
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>" style="font-size:12px;">返回列表页</a><img src="template/default/content/images/f_ico.png" align="absmiddle"></span> -->
    </td>
  </tr>
</table>
<script Language="JavaScript"> 
function CheckForm()
{
   if(document.save.workdate.value=="")
   { alert("日期不能为空！");
     document.save.workdate.focus();
     return (false);
   }
   if(document.save.content.value=="")
   { alert("内容不能为空！");
     document.save.content.focus();
     return (false);
   }
   
   return true;
}
function sendForm()
{
   if(CheckForm())
      document.save.submit();
}
function checkbox(){
	var val=document.getElementById("otype").value;
	if(val==1){
		startdate.style.display="block";
		document.getElementById("otype").value=2;
	}else{
		startdate.style.display="none";
		document.getElementById("otype").value=1;
	}
}
</script>
<form name="save" method="post" action="?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=add">
	<input type="hidden" name="view" value="edit" />
	<input type="hidden" name="id" value="<?php echo $user['id']?>" />
	 <table class="TableBlock" border="0" width="550" align="center" style="border-bottom:#4686c6 solid 0px;">
	 <tr>
      <td nowrap class="TableContent"> 开始时间：</td>
      <td class="TableData">
	  <table class="TableBlock" border="0" style="border:0px;">
	  <tr>
	  <td style="border:0px;"><input name="otype" id="otype" onClick="checkbox()" type="checkbox" value="1" checked>
        全天&nbsp;&nbsp;
	  <input type="text" name="workdate" class="BigInput" size="15" value="<?php echo $startdate[0]?>" onClick="WdatePicker();"/></td>
	  <td  id="startdate" style="display:none;border:0px;">
	  时间：<select name="startdate1">
			    <option value="0" selected="selected"></option>
			    <?php
				for($i=1;$i<=23;$i++){
				if (strlen($i)<2){
				$j="0".$i;
				}else{
				$j=$i;
				}
				?>
				<option value="<?php echo $j?>" <?php if($starttime[0]==$j){?>selected="selected"<?php }?>><?php echo $j?></option>
				<?php } ?>
				</select>
				点
				：<select name="startdate2">
			    <option value="0" selected="selected"></option>
			    <?php
				for($i=1;$i<=59;$i++){
				if (strlen($i)<2){
				$j="0".$i;
				}else{
				$j=$i;
				}
				?>
				<option value="<?php echo $j?>" <?php if($starttime[1]==$j){?>selected="selected"<?php }?>><?php echo $j?></option>
				<?php } ?>
				</select>分
				</td></tr></table>	
      </td>
    </tr>	
	
	<tr>
      <td nowrap class="TableContent" width="100"> 内容：<? get_helps()?></td>
      <td class="TableData"><textarea name="content" class="BigInput" style="width:420px; height:100px;"><?php echo $user['content']?></textarea> </td>
    </tr>
		
	
	
		
		<tr align="center" class="TableControl">
			<td colspan="2" nowrap>
			<input type="button" value="保存" class="BigButtonBHover" onClick="sendForm();">&nbsp;	    </td>
	  </tr>
	 </table>
  
</form>

 
</body>
</html>
