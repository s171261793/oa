<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../../template/default/content/css/style2015.css"><title>Office 515158 2011 OA办公系统</title>
<SCRIPT LANGUAGE="JavaScript">
function refreshParentss() {
  window.opener.location.href = window.opener.location.href;
  window.close();  
 } 
  //如果成功状态，显示当前印章信息
function ShowSignInfo()
{
    
    document.all("SignName").value = ntkosignctl.SignName;
    document.all("SignUser").value = ntkosignctl.SignUser;
    document.all("Password").value = ntkosignctl.Password;
    document.all("SignSN").value = ntkosignctl.SignSN;
    document.all("SignWidth").innerHTML = ntkosignctl.SignWidth;
    document.all("SignHeight").innerHTML = ntkosignctl.SignHeight;
}
//检查用户输入。参数IsNewSign标志是新建还是修改印章。新建的时候需要
//检查用户是否选择了印章原始文件。
function CheckInput(IsNewSign)
{
    var signname = document.all("SignName").value;
    if(( signname=='') ||( undefined == typeof(signname)))
    {
        alert('请输入印章名称');
        return false;
    }
        
    var signuser = document.all("SignUser").value;
    if(( signuser=='') ||( undefined == typeof(signuser)))
    {
        alert('请输入印章使用人');
        return false;
    }
        
    var password = document.all("Password").value;
    if(( password=='') ||( undefined == typeof(password)))
    {     
        alert('请输入印章口令');
        return false;
    }
    if( (password.length<6) || (password.length>32))
    {     
        alert('印章口令必须是6-32位.');
        return false;
    } 
    if(IsNewSign == true) //如果是创建印章，需要用户选择原始印章文件
    {
	    var signfile = document.all("SignFile").value;
	    if(( signfile=='') ||( undefined == typeof(signfile)))
	    {
	        alert('请选择用来创建印章的原始文件(bmp,gif,jpg.');
	        return false;
	    }
	    if( (-1 == signfile.toUpperCase().lastIndexOf("BMP")) &&
	    	(-1 == signfile.toUpperCase().lastIndexOf("GIF")) &&
	    	(-1 == signfile.toUpperCase().lastIndexOf("JPG")) )
	   	{
	        alert('请选择一个正确的印章原始文件(bmp,gif,jpg.');
	        return false;
	    }    
    }
    ntkosignctl.SignName = document.all("SignName").value;
    if(0 != ntkosignctl.StatusCode)
    {
    	alert("设置印章名称错误");
    	return false;
    }
    ntkosignctl.SignUser = document.all("SignUser").value;
    if(0 != ntkosignctl.StatusCode)
    {
    	alert("设置印章使用者错误");
    	return false;
    }
    ntkosignctl.Password = document.all("Password").value;
    if(0 != ntkosignctl.StatusCode)
    {
    	alert("设置印章口令错误");
    	return false;
    }
    return true;
}
//生成新印章文件
function CreateNew()
{
	if(!CheckInput(true))return;
    ntkosignctl.CreateNew(
    			document.all("SignName").value,
    			document.all("SignUser").value,
    			document.all("Password").value,
    			document.all("SignFile").value
    );
    if(0 != ntkosignctl.StatusCode)
    {
	    alert("创建印章文件错误.");
	    return;
    }
    alert("创建印章成功,请通过‘保存印章’按钮将印章保存到本地！");
}
//对话框方式生成新的印章文件
function CreateNewWithDialog()
{
    ntkosignctl.CreateNew();
    if(0 != ntkosignctl.StatusCode)
    {
	    alert("创建印章文件错误.");
	    return;
    }
    //正确，显示印章信息
    ShowSignInfo();
    alert("创建印章成功,请通过‘保存印章’按钮将印章保存到本地!");
}
function OpenFromEkey(pass)
{
	var ifCont = window.confirm("请插入EKEY到您的计算机.然后继续。");
	if(!ifCont)return;
    ntkosignctl.OpenFromEkey(pass);
    if(0 != ntkosignctl.StatusCode)
    {
	    alert("从EKEY打开印章错误.");
	    return;
    }
    //正确，显示印章信息
    ShowSignInfo();
    alert("从EKEY打开印章成功！您现在可以修改印章的相关信息并重新保存到EKEY.此时选择印章原始文件无效.");
}

function SaveToEkey()
{
	if(!CheckInput(false))return;
	var ifCont = window.confirm("请插入EKEY到您的计算机.然后继续。");
	if(!ifCont)return;
	var index = ntkosignctl.SaveToEkey();
	if(0 == ntkosignctl.StatusCode)
	{
		alert("保存印章到EKEY成功!保存位置:" + index);
	}
	else
	{
		alert("保存印章到EKEY失败！！");
	}
}
function OpenFromLocal()
{
    ntkosignctl.OpenFromLocal('',true);
    ShowSignInfo();
}
function SaveToLocal()
{
	if(!CheckInput(false))return;
	ntkosignctl.SaveToLocal('',true);
	if(0 == ntkosignctl.StatusCode)
	{
		alert("保存印章到本地文件成功!");
	}
	else
	{
		alert("保存印章到本地文件失败！！");
	}
}
function SetEkeyUserName()
{
	var EkeyUser = "";
	EkeyUser = document.all("EkeyUser").value;
    if(( EkeyUser=="") ||( undefined == typeof(EkeyUser)))
    {     
        alert('请输入EKEY用户名称!');
        return false;
    }
    if( (EkeyUser.length>24))
    {     
        alert('KEY用户名称不能超过24个字符.');
        return false;
    } 
	ntkosignctl.SetEkeyUser(EkeyUser);
	if(0 == ntkosignctl.StatusCode)
	{
		alert("设定EKEY用户:"+EkeyUser+"成功!");
	}
	else
	{
		alert("设定EKEY用户:"+EkeyUser+"失败！！");
	}	
}
function GetEkeyUserName()
{
	var EkeyUser = "";
	EkeyUser = ntkosignctl.GetEkeyUser();
	if(0 == ntkosignctl.StatusCode)
	{
		document.all("EkeyUser").value = EkeyUser;
		alert("读取EKEY用户成功！此EKEY用户是："+EkeyUser);
	}
	else
	{
		alert("读取EKEY用户失败！！");
	} 
}

function ChangeEkeyPin()
{
	var flags = document.all("forWho");
	var oldpass = document.all("oldPassword").value;
	var newpass1 = document.all("newPassword1").value;
	var newpass2 = document.all("newPassword2").value;
	if( (newpass1.length<4) || (newpass1.length>16) )
	{
        alert('EKEY访问口令必须是4-16位.');
        return false;	
	}
	if( newpass1 != newpass2)
	{
		alert('两次新口令不符合，请重新输入.');
        return false;
	}
    var isAdmin = true;
    if(flags[0].checked)
    {
    	isAdmin = false;
    }
    else
    {
    	isAdmin = true;
    }
    ntkosignctl.ChangeEkeyPassword(oldpass,newpass1,isAdmin);
    if(0 == ntkosignctl.StatusCode)
	{
		if(isAdmin)
		{
			alert("改变EKEY管理员口令成功!");
		}
		else
		{
			alert("改变EKEY用户口令成功!");
		}
	}
	else
	{
		if(isAdmin)
		{
			alert("改变EKEY管理员口令失败!");
		}
		else
		{
			alert("改变EKEY用户口令失败!");
		}
	}
}
function ResetEkeyUserPin()
{
	var adminPassword = document.all("adminPassword").value;
	var newUserPassword1 = document.all("newUserPassword1").value;
	var newUserPassword2 = document.all("newUserPassword2").value;
	if( (newUserPassword1.length<4) || (newUserPassword1.length>16) )
	{
        alert('EKEY访问口令必须是4-16位.');
        return false;	
	}
	if( newUserPassword1 != newUserPassword2)
	{
		alert('两次新口令不符合，请重新输入.');
        return false;
	}
    ntkosignctl.ResetEkeyUserPassword(adminPassword,newUserPassword1);
    if(0 == ntkosignctl.StatusCode)
	{
		alert("重设EKEY用户口令成功!");
	}
	else
	{
		alert("重设EKEY用户口令失败!");
	}
}
function ResetEkeySigns()
{
    ntkosignctl.ResetEkeySigns();
    if(0 == ntkosignctl.StatusCode)
	{
		alert("重设EKEY所有印章成功!");
	}
	else
	{
		alert("用户取消,或者重设EKEY所有印章失败!");
	}
}
function EnableEkeyButtons(isEnabled)
{
	var isDisable =  !isEnabled;
	document.all("OpenFromEkey").disabled = isDisable;
	document.all("SaveToEkey").disabled = isDisable;
	document.all("DeleteFromEkey").disabled = isDisable;
	document.all("ResetEkey").disabled = isDisable;
	document.all("EkeyFreeSize").disabled = isDisable;
	document.all("EkeySN").disabled = isDisable;
	document.all("SetEkeyUserName").disabled = isDisable;
	document.all("GetEkeyUserName").disabled = isDisable;
	document.all("ChangeEkeyPin").disabled = isDisable;
	document.all("ResetEkeyUserPin").disabled = isDisable;
}
//定位整个页面距中
function init()
{
	document.body.style.marginLeft=document.body.clientWidth/2-400;
		
	if(ntkosignctl.IsEkeyConnected)
	{
		EnableEkeyButtons(true);
	}
	
	initKeyType();
}

function initKeyType()
{
	curEkeyType = ntkosignctl.EkeyType;
	//alert("curekeytype=" + curEkeyType);
	selectObj = document.all("EkeyTypeSelector");
	for(i=0;i<selectObj.options.length;i++)
	{
		if(selectObj.options[i].value == curEkeyType)
		{
			selectObj.options[i].selected = true;
			break;
		}
	}
}

function changeEkeyType(ekeyType)
{
	ntkosignctl.EkeyType = ekeyType;
	EnableEkeyButtons(ntkosignctl.IsEkeyConnected);	
}
</SCRIPT>
</head>
<body  onLoad="init();">
		
<div class="search_area">
        <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td align="left" class="Big" style="font-size:16px; color:#009900; font-weight:bold;">
	<?php echo $_GET['uname'];?>
	</td>
	<td align="right" class="Big" style="font-size:16px; color:#009900; font-weight:bold;">
<button type="button" tabindex="5" class="btn btn-success" onClick="CreateNew();">创建印章</button>
<button type="button" action="new_work" class="btn btn-success" onClick="CreateNewWithDialog();">创建印章(对话框)</button>
	<button type="button" onclick="SaveToLocal();" action="cancel_concern" class="btn btn-danger">保存印章</button> <button id="do_search" type="button" onClick="refreshParentss();" class="btn btn-info">关闭</button>
	</td>
  </tr>
</table>
</div>
<style type="text/css">
body {
	text-align: center;
	background-color: #dcdcdc;
}
.text_table{
	background-color: #FFFFFF;
	
}
.table_bg{
	border-collapse: 1px;
    border-spacing: 1px;
	background-color:#DDDED5;
}
.table_bg1{
	border-collapse: 0px;
    border-spacing: 0px;
	border-left:1px solid #DDDED5;
	border-right:1px solid #DDDED5;
}
.title{
	font-family: "微软雅黑", "宋体";
	font-size: 32px;
	color: #069DD5;
	line-height: 60px;
	letter-spacing: 2px;
}
.text_td {
	font-family: Arial, "微软雅黑", "宋体";
	font-size: 14px;
	line-height: 35px;
	height:35px;
	color: #68584e;
	padding-right: 6px;
	padding-left: 6px;
}
.text_td_1 {
	width:110px;
	background-color:#F7F8EE;
}
.text_value {
	font-family: Arial, "微软雅黑", "宋体";
	font-size: 14px;
	line-height: 25px;
	height:35px;
	color: #069DD5;
	padding-right: 6px;
	padding-left: 6px;
	background-color:#FFFFFF;
	text-align:left;
}
.text_title {
	font-family: Arial, "微软雅黑", "宋体";
	font-size: 16px;
	line-height: 25px;
	height:40px;
	color: #68584e;
	padding-left: 20px;
	background-color:#E8E8E3;
	text-align:left;
}
.text_no {
	font-family: Arial, "微软雅黑", "宋体";
	font-size: 16px;
	line-height: 25px;
	height:35px;
	color: #68584e;
	padding-right: 6px;
	padding-left: 6px;
	background-color:#F7F8EE;
}
</style>
<table class="TableBlock" border="0" width="100%" align="center" style="margin-top:30px;">
	
	<tr>
      <td>
<table width="90%" border="0" align="center" class="table_bg">
  <tr><td class="text_td text_td_1">印章名称</td><td class="text_value"><input id="SignName" value="<?=$_GET['cname']?>"  tabindex="1"></td><td class="text_td text_td_1">使用人</td><td class="text_value"><input id="SignUser" value="<?=$_GET['uname']?>" tabindex="2"></td></tr><tr><td class="text_td text_td_1">印章口令</td><td class="text_value"><input id="Password" value="" tabindex="3"></td><td class="text_td text_td_1">印章序列号</td><td class="text_value"><input id="SignSN" DISABLED value="" size=43></td></tr><tr>
    <td class="text_td text_td_1">印章源文件(bmp,gif,jpg)</td>
    <td colspan="3" class="text_value"><input size=50 type=file id="SignFile" tabindex="4"></td></tr><tr>
		<td class="text_td text_td_1"></td>
		<td colspan="3" class="text_value" style="padding-top: 10px;padding-bottom: 10px;"><!-- 以下为了适应微软新的ActiveX机制,将<object代阿放到外部,避免点击激活 -->
		<script type="text/javascript" src="ntkoGenOcxObj.js"></script>
		<script language="JScript" for="ntkosignctl" event="OnEkeyInserted()">
			EnableEkeyButtons(true);
		</script>
		<script language="JScript" for="ntkosignctl" event="OnEkeyRemoved()">
			EnableEkeyButtons(false);
		</script></td>
	  </tr></table>  
	
	  </td>
	</tr>


  </table>

</body>
</html>
