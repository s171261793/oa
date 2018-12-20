<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<title>部门添加</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">

</head>
<body class="bodycolor" <?php if($user['keytype']=='1'){?>onLoad="toggle2('div1');"<?php }?>>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 添加部门信息</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right;margin-right:20px;">
	
	<a href="admin.php?ac=department&fileurl=mana" style="font-size:12px;"><<返回列表页</a></span>
    </td>
  </tr>
</table>
<script Language="JavaScript"> 
function CheckForm()
{
   if(document.save.name.value=="")
   { alert("部门名称不能为空！");
     document.save.username.focus();
     return (false);
   }
 
   if(document.save.positionid.value=="")
   { alert("岗位不能为空！");
     document.save.positionid.focus();
     return (false);
   }

    if(document.save.department_code.value=="")
   { alert("部门代码不能为空！");
     document.save.positionid.focus();
     return (false);
   }
  
   var New=document.getElementsByName("keytype");
   var strNew;
   for(var i=0;i<New.length;i++)
   {
     if(New.item(i).checked){
		 strNew=New.item(i).getAttribute("value");  
		 break;
	  }else{
		 continue;
	  }
   }
   if(strNew=="1" && document.save.keytypeuser.value=="")
   { alert("下属成员不能为空！");
     document.save.keytypeuser.focus();
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
#div1{display:none;}
#div2{display:block;}
</style>
<form name="save" method="post" action="?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=add&method=post">
<input type="hidden" name="view" value="edit" />
	<input type="hidden" name="id" value="<?php echo $_USER->id?>" />
	<input type="hidden" name="father" value="<?php echo $_GET['departemntids']?>" />
 <table class="TableBlock" border="0" width="90%" align="center">
 	<tr>
 		<td nowrap class="TableContent" width="90">父级部门：</td>
 		<td nowrap class="TableContent" width="90" colspan="3"><?php echo get_realdepaname($_GET['departemntids']);?></td>
 	</tr>
  	<tr>
  		<td nowrap class="TableContent" width="90">部门名称：<? get_helps()?></td>
  	  <td class="TableData">
  	  	<input type="text" class="BigInput" name="name" value="">
  	  </td>  	  	
  		<td nowrap class="TableContent" width="90">部门代码：<?php if($id==''){?><? get_helps()?><?php }?></td>
  	  <td class="TableData"><input type="text" class="BigInput" name="department_code" value="">  </td>  	  	
  	</tr>

    <tr>
      <td nowrap class="TableContent" width="90">主管岗位：<? get_helps()?></td>
      <td class="TableData">
        <?php
	  get_positionbox(2,'position',get_postname($user['positionid']),'选择岗位',$width=30,$height=3);
	  ?>
      </td>       
      <td nowrap class="TableContent" width="90">单位名称：</td>
      <td class="TableData"><input type="text" class="BigInput" name="department_company" value=""></td>        
    </tr>
	
    <tr align="center" class="TableControl">
    	<td colspan="4" nowrap>
    	<input type="button" value="提交" class="BigButtonBHover" onClick="sendForm();">&nbsp;
 
	    </td>
  </tr>
 </table>
  
</form>

 
</body>
</html>
