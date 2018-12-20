<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<title>信息添加编辑</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script charset="utf-8" src="eweb/kindeditor.js"></script>
</head>
<body class="bodycolor" <? if($user['type']=='1'){?>onLoad="toggle('div1');"<?php }?>>
<table width="80%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3">工作日志<?php echo $_title['name']?></span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right;margin-right:20px;">
	
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>" style="font-size:12px;"><<返回列表页</a></span>
    </td>
  </tr>
</table>
<script Language="JavaScript"> 
function CheckForm()
{	<? if($user['id']==''){?>
   if(document.save.date.value=="")
   { alert("日期不能为空！");
     document.save.date.focus();
     return (false);
   }
   <? }?>
   if(document.save.title.value=="")
   { alert("主题不能为空！");
     document.save.title.focus();
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
function toggle(targetid){
     if (document.getElementById){
         target=document.getElementById(targetid);
             if (target.style.display=="block"){
                 target.style.display="none";
             } else {
                 target.style.display="none";
             }
     }
}
function toggle2(targetid){
     if (document.getElementById){
         target=document.getElementById(targetid);
             if (target.style.display=="none"){
                 target.style.display="block";
             } else {
                 target.style.display="block";
             }
     }
}
</script>
<style type="text/css"> 
#div1{
display:block;}
</style>
<form name="save" method="post" action="?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=add">
	<input type="hidden" name="view" value="edit" />
	<input type="hidden" name="id" value="<?php echo $user['id']?>" />
	 <table class="TableBlock" border="0" width="80%" align="center" style="border-bottom:#4686c6 solid 0px;">
	 
    
	
		<tr>
			<td nowrap class="TableContent" width="100">日志主题：<? get_helps()?></td>
			  <td class="TableData">
					<input type="text" class="BigInput" name="title" value="<?php echo $user['title']?>" size=50 >
				</td>  	  	
		</tr>
	
		<tr>
      <td nowrap class="TableContent"> 日志设置：</td>
      <td class="TableData">
	  <input name="type" type="radio" style="border:0;" value="1" <? if($user['type']=='1'){?>checked="checked"<? }?> onClick="toggle('div1')"/>
      个人日志
			<input name="type" type="radio" style="border:0;" value="2" <? if($user['type']=='2'){?>checked="checked"<? }?>  onClick="toggle2('div1')" />
			工作日志	
      </td>
    </tr>
	</table>	
	<table class="TableBlock" border="0" width="80%" align="center"  id="div1" style="border-top:0px;border-bottom:0px;">
	<tr>
			<td nowrap class="TableContent" width="100">共享人员：</td>
			  <td class="TableData">
					<?php
					if($user['user']==''){
						$user['user']='全部人员';
					}
					get_pubuser(2,'user',$user['user'],"+选择人员",60,4);
					
					?>
				</td> 	  	
		</tr>
	</table>	
	<table class="TableBlock" border="0" width="80%" align="center" style="border-top:0px;border-bottom:0px;">	
	<? if($user['id']==''){?>
	<tr>
			<td nowrap class="TableContent" width="100">日志日期：<? get_helps()?></td>
			  <td class="TableData">
					<input type="text" name="date" class="BigInput" size="15" value="<?php echo $date?>" onClick="WdatePicker();"/> 
				</td>  	  	
		</tr>
	<? }?>
	</table>	
	<table  width="80%" style="border-left:#4686c6 solid 1px;border-right:#4686c6 solid 1px;" align="center">	
		<tr>
			<td nowrap class="TableContent" width="104" style="border-right:#cccccc solid 1px;">内容：<? get_helps()?></td>
			  <td class="TableData" style="padding-top:10px; padding-bottom:10px; padding-left:3px;">
			  
			  <script>
        KE.show({
                id : 'content'
        });
</script>
				<textarea name="content" rows="5" cols="60" style="width:600px;height:300px;"><?php echo $user['content']?></textarea>
			</td>
		</tr>
		</table>
  <table class="TableBlock" border="0" width="80%" align="center" style="border-top:#4686c6 solid 0px;">

		<tr align="center" class="TableControl">
			<td colspan="2" nowrap>
			<input type="button" value="保存" class="BigButtonBHover" onClick="sendForm();">&nbsp;	    </td>
	  </tr>
	 </table>
  
</form>

 
</body>
</html>
