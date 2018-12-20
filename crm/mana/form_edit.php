<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script charset="utf-8" src="eweb/kindeditor.js"></script>

<title>Office 515158 2011 OA办公系统</title>
 
</head>
<body   class="bodycolor" <?php if($blog['type']!='0'){?>onLoad="toggle('div2');"<?php }?> <?php if($blog['inputtype']=='3' || $blog['inputtype']=='4' || $blog['inputtype']=='5'){ ?> onLoad="toggle2('div1');"<?php }?>>
<table width="70%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 表单信息编辑</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right; margin-right:20px;">
	
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&type1=<?php echo $_GET['type1']?>" style="font-size:12px;"><<返回列表页</a></span>
    </td>
  </tr>
</table>
<script Language="JavaScript"> 
function CheckForm()
{
   if(document.save.formname.value=="")
   { alert("表单名称不能为空！");
     document.save.formname.focus();
     return (false);
   }
   if(document.save.type.value=="")
   { alert("表单类型不能为空！");
     document.save.type.focus();
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

	<form name="save" method="post" action="?ac=<?php echo $ac;?>&do=edit&fileurl=<?php echo $fileurl;?>">
	<input type="hidden" name="view" value="edit" />
	<input type="hidden" name="fid" value="<?php echo $blog['fid']?>" />
	<input type="hidden" name="type1" value="<?php echo $_GET["type1"]?>" />
<table class="TableBlock" border="0" width="70%" align="center">
   
	<tr>
      <td nowrap class="TableContent" width="15%"> 表单名称：<? get_helps()?></td>
      <td class="TableData">
	  <? if($blog["key1"]=='1'){?>
	  <input type="hidden" name="formname" value="<?php echo $blog['formname']?>" /><?php echo $blog['formname']?>
	  <? }else{?>
      <input type="text" name="formname" class="BigInput" style="width:268px;" size="20" value="<?php echo $blog['formname']?>" />
	  <? }?>
	  </td>
    </tr>
	
	<tr>
      <td nowrap class="TableContent" width="15%"> 默认值：</td>
      <td class="TableData">
      <input type="text" name="inputvalue" class="BigInput" style="width:268px;" size="20" value="<?php echo $blog['inputvalue']?>" />
	  </td>
    </tr>
	<? if($blog["key1"]=='1'){?>
	  <input type="hidden" name="type" value="<?php echo $blog['type']?>" />
	  <input type="hidden" name="inputtype" value="<?php echo $blog['inputtype']?>" />
	  <? }else{?>
	<tr>
      <td nowrap class="TableContent" width="15%"> 状态：</td>
      <td class="TableData">
	  <input name="type" type="radio" onclick="toggle2('div2')" value="0" <?php if($blog['type']=='0'){ ?> checked="checked"<?php }?>/>
	  正常
	  <input name="type" type="radio" value="1" onclick="toggle('div2')" <?php if($blog['type']=='1'){ ?> checked="checked"<?php }?>/>图片
      <input name="type" type="radio" value="2" onclick="toggle('div2')" <?php if($blog['type']=='2'){ ?> checked="checked"<?php }?>/>附件
	  <input name="type" type="radio" value="3" onclick="toggle('div2')" <?php if($blog['type']=='3'){ ?> checked="checked"<?php }?>/>日期
	  <input name="type" type="radio" value="4" onclick="toggle('div2')" <?php if($blog['type']=='4'){ ?> checked="checked"<?php }?>/>部门
	  <input name="type" type="radio" value="5" onclick="toggle('div2')" <?php if($blog['type']=='5'){ ?> checked="checked"<?php }?>/>成员
	  </td>
    </tr>
	
	
 <tbody width="90%" id="div2">
	
	
	<tr>
      <td nowrap class="TableContent" width="15%"> 表单类型：</td>
      <td class="TableData">
      <input name="inputtype" type="radio" value="1" <?php if($blog['inputtype']=='1'){ ?> checked="checked"<?php }?> onclick="toggle('div1')" />
      输入框
      <input name="inputtype" type="radio" value="2" <?php if($blog['inputtype']=='2'){ ?> checked="checked"<?php }?> onclick="toggle('div1')" />输入区
	  <input name="inputtype" type="radio" value="3" <?php if($blog['inputtype']=='3'){ ?> checked="checked"<?php }?> onclick="toggle2('div1')" />单选
	  <input name="inputtype" type="radio" value="4" <?php if($blog['inputtype']=='4'){ ?> checked="checked"<?php }?> onclick="toggle2('div1')" />复选
	  <input name="inputtype" type="radio" value="5" <?php if($blog['inputtype']=='5'){ ?> checked="checked"<?php }?> onclick="toggle2('div1')" />下拉
	  </td>
    </tr>
	<? }?>
	<tr id="div1">
      <td nowrap class="TableContent" width="15%"> 表单参数：<? get_helps()?></td>
      <td class="TableData">
        <textarea name="inputvaluenum" cols="60" rows="4" class="BigInput"><?php echo $blog['inputvaluenum']?></textarea>
		<br>参数格式："名称|名称|名称",注意多个名称之间用“|”分隔
	  
	  </td>
    </tr>
	
	</tbody>
	<tr>
      <td nowrap class="TableContent" width="15%"> 验证方式：</td>
      <td class="TableData">
	  <input name="confirmation" type="radio" value="1" <?php if($blog['confirmation']=='1'){ ?> checked="checked"<?php }?> />
	  是
      <input name="confirmation" type="radio" value="2" <?php if($blog['confirmation']=='2'){ ?> checked="checked"<?php }?> />否
	  <br>注：选择"是"表示该项为必填项
	      </td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 列表显示：</td>
      <td class="TableData">
	  <input name="type2" type="radio" value="1"  <?php if($blog['type2']=='1'){ ?> checked="checked"<?php }?>/>
	  是
      <input name="type2" type="radio" value="0" <?php if($blog['type2']=='0'){ ?> checked="checked"<?php }?> />否
	  <br>注：选择"是"表示该项的数据在内容的列表显示
	      </td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="15%"> 表单宽高：</td>
      <td class="TableData">
      宽:<input type="text" name="w" class="BigInput" style="width:40px;" onKeyUp="value=value.replace(/[^0-9]/g,'');" value="<?php echo $blog['w']?>"/>px;&nbsp;&nbsp;&nbsp;&nbsp;高:<input type="text" name="h" class="BigInput" style="width:40px;" onKeyUp="value=value.replace(/[^0-9]/g,'');"  value="<?php echo $blog['h']?>"/>px;
	  </td>
    </tr>
    <tr align="center" class="TableControl">
      <td colspan="2" nowrap height="35">

		<input type="button" name="Submit" value="保存信息" class="BigButton" onclick="sendForm();"> 
        
      </td>
    </tr>
  </table>
</form>
 
</body>
</html>
