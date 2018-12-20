<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<title>信息添加编辑</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
</head>
<body class="bodycolor" <?php if($user['flowkey2']=='1'){?>onLoad="toggle2('div1');"<?php }?> >
<table width="70%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3">审批流程<?php echo $_title['name']?></span>&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="font-size:12px; float:right; margin-right:20px;">
	<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&modid=<?php echo $modid?>" style="font-size:12px;"><<返回列表页</a></span>
    </td>
  </tr>
</table>
<script Language="JavaScript"> 
function CheckForm()
{	
   if(document.save.flowname.value=="")
   { alert("流程名称不能为空！");
     document.save.flowname.focus();
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
display:none;
margin-top:5px;}
</style>
<form name="save" method="post" action="?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=add&modid=<?php echo $modid?>">
	<input type="hidden" name="view" value="edit" />
	<input type="hidden" name="fid" value="<?php echo $user['fid']?>" />
	 <table class="TableBlock" border="0" width="70%" align="center" style="border-bottom:#4686c6 solid 0px;">
	 
    
	
		<tr>
			<td nowrap class="TableContent" width="100">流程名称：<? get_helps()?></td>
			  <td class="TableData">
					<input type="text" class="BigInput" name="flowname" value="<?php echo $user['flowname']?>" size=30 >
		  </td>  	  	
		</tr>
		
		<tr>
			<td nowrap class="TableContent" width="100">流程步骤：</td>
			  <td class="TableData">
			  <?php
			  
			  echo '第<span style="font-size:18px; font-weight:bold; color:#FF0000;">'.$flownum.'</span>步';
			  ?>
			  <input type="hidden" name="flownum" value="<?php echo $flownum?>" />
		  </td>  	  	
		</tr>
		<tr>
			<td nowrap class="TableContent" width="100">流程类型：</td>
		  <td class="TableData">
			<!--<input name="flowkey" type="radio" style="border:0;" value="1" <? if($user['flowkey']=='1'){?>checked="checked"<? }?> />
      可退回 -->
			<input name="flowkey" type="radio" style="border:0;" value="1" <? if($user['flowkey']=='1'){?>checked="checked"<? }?> />
			顺序直行
			<input name="flowkey" type="radio" style="border:0;" value="2" <? if($user['flowkey']=='2'){?>checked="checked"<? }?> />
			流程结束
		<br><font color="#868788">
		<!--可退回：指在审批中如果经审人不同意，可退回前面的流程进行重新处理；<br> -->
		顺序直行：指流程正常按步骤执行；<br>
		流程结束：指该节点审批完成后，流程自动结束；
		</font>	
		  </td>  	  	
		</tr>
	<tr>
			<td nowrap class="TableContent" width="100">审批状态：</td>
			  <td class="TableData">
	 <input name="flowkey2" type="radio" style="border:0;" onClick="toggle2('div1')" value="1" <? if($user['flowkey2']=='1'){?>checked="checked"<? }?> />
      多人审批
			<input name="flowkey2" type="radio" onClick="toggle('div1')" style="border:0;" value="2" <? if($user['flowkey2']=='2'){?>checked="checked"<? }?> />
			单人审批
			
	  </td>  	  	
	   </tr>
		<tr id="div1">
      <td nowrap class="TableContent"> 审批关系：</td>
      <td class="TableData">
	  <input name="flowkey3" type="radio" style="border:0;" value="1" <? if($user['flowkey3']=='1'){?>checked="checked"<? }?> />
      同时通过
			<input name="flowkey3" type="radio" style="border:0;" value="2" <? if($user['flowkey3']=='2'){?>checked="checked"<? }?> />
			一人通过
		<br><font color="#868788">
		同时通过：在多人审批时有效，选择此项表示多个同时同意后流程转到下一步<br>
		一人通过：只要其中一人通过，流程转向下一步；
		</font>
      </td>
    </tr>

	<tr>
			<td nowrap class="TableContent" width="100">审批人员：<? get_helps()?></td>
			  <td class="TableData">
	  <?php
	  get_pubuser(2,"flowuser",$user['flowuser'],"+选择审批人员",50,3)
	  ?><br><font color="#868788">注：在流程审批时，有权限操作该节点的工作人员，不设定时请留空</font>
	  </td>  	  	
	   </tr>
		<tr>
      <td nowrap class="TableContent"> 状态：</td>
      <td class="TableData">
	  <input name="flowkey1" type="radio" style="border:0;" value="1" <? if($user['flowkey1']=='1'){?>checked="checked"<? }?> />
      可选
			<input name="flowkey1" type="radio" style="border:0;" value="2" <? if($user['flowkey1']=='2'){?>checked="checked"<? }?> />
			不可选
		<br><font color="#868788">注：可选指在提交流程时可以再次设定审批人员</font>	
      </td>
    </tr>
	

		
		<tr align="center" class="TableControl">
			<td colspan="2" nowrap>
			<input type="button" value="保存" class="BigButtonBHover" onClick="sendForm();">&nbsp;	    </td>
	  </tr>
	 </table>
  
</form>

 
</body>
</html>
