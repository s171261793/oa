<html>
<head>
<title>项目基本信息</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
</head>
<body class="bodycolor">
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 产品授权</span>
    </td>
  </tr>
</table>
<script Language="JavaScript"> 
function CheckForm()
{
<?php
if($_CONFIG->config_data('com_number')==''){
	for($i=1;$i<=16;$i++){
	?>
	   if(document.save.t<?php echo $i?>.value=="")
	   { alert("第<?php echo $i?>位号码不能为空！");
		 document.save.t<?php echo $i?>.focus();
		 return (false);
	   }
	<?php
	}
}else{
?>
	   if(document.save.com_number.value=="")
	   { alert("序列号不能为空！");
		 document.save.com_number.focus();
		 return (false);
	   }
<?php
}
?>
   return true;
}
function sendForm()
{
   if(CheckForm())
      document.save.submit();
}
</script>
<form name="save" method="post" action="?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=save">
<input type="hidden" name="savetype" value="edit" />
<? if($_CONFIG->config_data('com_number')!=''){?>
	<input type="hidden" name="com_number" value="<?php echo $_CONFIG->config_data('com_number')?>" />
	<input type="hidden" name="nums" value="1" />
<table class="TableBlock" border="0" width="90%" align="center">
  	<tr>
  		<td nowrap class="TableContent" width="90">授权ID：</td>
  	  <td class="TableData">
  	  	<?php echo $_CONFIG->config_data('com_userid')?></td>  	  	
  		<td nowrap class="TableContent" width="90">序列号：</td>
  	  <td class="TableData"><?php echo $_CONFIG->config_data('com_number')?></td>  	  	
  	</tr>
    
    <tr align="center" class="TableControl">
    	<td colspan="4" nowrap>
    	<input type="button" value="同步授权" class="BigButtonBHover" onClick="sendForm();">&nbsp;	    </td>
  </tr>
 </table>
<? }else{?>
<script ID="clientEventHandlersJS" LANGUAGE="javascript">
<!--
<?php
for($i=1;$i<=16;$i++){
	$nexti=$i+1;
	?>
		function t<?php echo $i?>_onkeyup() {
			if(document.save.t<?php echo $i?>.value.length==1){
				<?php if($nexti!=17){?>
				document.save.t<?php echo $nexti?>.focus();
				<?php }?>
			}
		}
<?php
}
?>
//-->
</script>
<table class="TableBlock" border="0" width="90%" align="center">
  	<tr>
	  <td nowrap class="TableHeader" width="150">请输入16位产品序列号：</td>
  	  <td class="TableData">
	  <?php 
	  for($i=1;$i<=16;$i++){
		if($i%4==0 && $i<16){
			$strs='－';
		}else{
			$strs='&nbsp;';
		}
		echo '<input name="t'.$i.'" style="width:30px;height:25px;font-size:22px;" type="text" class="BigInput" maxlength="1" LANGUAGE="javascript" onkeyup="return t'.$i.'_onkeyup()"/>'.$strs;
	  }
	  ?>
	  <br>
	  <font color=red><?php echo $_GET['error']?></font>
	  </td>  	  	
  	</tr>
    
    <tr align="center" class="TableControl">
    	<td colspan="2" nowrap>
    	<input type="button" value="验证授权" class="BigButtonBHover" onClick="sendForm();">
    	&nbsp;<input type="reset" name="Submit2" class="BigButtonBHover" value="清除屏幕" /> </td>
  </tr>
 </table>
<? }?>
 <table class="TableBlock" border="0" width="90%" align="center" style="margin-top:10px;">
 <tr align="center" class="TableHeader">
    	<td colspan="4" align="left" nowrap>
    	<b>企业信息</b></td>
  </tr>
  	<tr>
  		<td nowrap class="TableContent" width="90">授权企业：</td>
  	  <td class="TableData">
  	  <?php echo $_CONFIG->config_data('com_name')?></td>  	  	
  		<td nowrap class="TableContent" width="90">联系人：</td>
  	  <td class="TableData"><?php echo $_CONFIG->config_data('com_person')?></td>  	  	
  	</tr>
    <tr>
  		<td nowrap class="TableContent" width="90">联系电话：</td>
  	  <td class="TableData"><?php echo $_CONFIG->config_data('com_tel')?></td>  	  	
  		<td nowrap class="TableContent" width="90">手机号码：</td>
  	  <td class="TableData"><?php echo $_CONFIG->config_data('com_phone')?></td>  	  	
  	</tr>
	<tr>
  		<td nowrap class="TableContent" width="90">公司地址：</td>
  	  <td class="TableData"><?php echo $_CONFIG->config_data('com_address')?></td>  	  	
  		<td nowrap class="TableContent" width="90">qq：</td>
  	  <td class="TableData"><?php echo $_CONFIG->config_data('qq')?></td>  	  	
  	</tr>
	<tr>
  		<td nowrap class="TableContent" width="90">email：</td>
  	  <td class="TableData"><?php echo $_CONFIG->config_data('email')?></td>  	  	
  		<td nowrap class="TableContent" width="90">授权OA网址：</td>
  	  <td class="TableData"><?php echo $_CONFIG->config_data('com_url')?></td>  	  	
  	</tr>
    
    
 </table>
  
</form>

 
</body>
</html>
