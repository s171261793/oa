<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<html>
	<style type="text/css">
	body {
    background-color: #E3DFDF;
    margin: 0;
    border:0px;
    font-size:12px;
    line-height:20px;
}
a
{
    color: #f00;
    text-decoration: none;
}
table
{
    width="800px";
    font-size:12px;
    background-color:#F1F5F6;
}
input:focus
{
    border-color:red;
}
input
{
    border: 1px solid #a5b6d2;
    text-align: left;
    left: 0px;
    width: 225px;
    height: 20px;
}
.radio
{
    width:20px;
}
#SignFile
{
     width:410px;
}
.button
{
    border:1px outset #a5b6d2;
    padding:5px 2px;
    text-decoration:none;
    text-align:center;
    vertical-align:middle;
    color:#343333;
    cursor: pointer;
    background-color:#CAEAFF;
}
.style2
{
    width: 45%;
}
	</style>
<script language="JavaScript">

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
    alert("创建印章成功.您现在可以插入EKEY,并点击'保存印章到EKEY'将创建的印章保存到EKEY.");
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
    alert("创建印章成功.您现在可以插入EKEY,并点击'保存印章到EKEY'将创建的印章保存到EKEY.");
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
</script>
</head>
<body onLoad="init();">
<font color="red">提示：EKEY相关功能需要首先安装EKEY驱动程序。</font>
<br/>
    <span>创建新印章:
首先插入EKEY,然后输入印章名称,使用者,并选择印章文件之后,点击"创建新印章",如果显示成功,点击"保存印章到EKEY".<br/>
打开EKEY印章修改:首先插入EKEY,点击"打开EKEY印章修改",在下面的输入框中修改相关的信息,修改完毕点击"保存印章到EKEY"确认修改.
    </span>
<table>
<tr><td style="background-color:#666;font-size:14px; height:20px; color:#ccc;" colspan="2">印章操作部分:</td></tr>
<tr>
	<td valign="top" class="style2">
		<br>
		EKEY类型：<select id="EkeyTypeSelector" onChange="changeEkeyType(this.options[this.options.selectedIndex].value)"> 
		<option value="1">HT_EKEY</option>
		<option value="2">M&W_EKEY</option>
		<option value="4">FT_EKEY</option>
		<option value="6">九思泰达EKEY</option>
		<option value="7">FT2K_EKEY</option>
		</select><br><br>
		<!-- 以下为了适应微软新的ActiveX机制,将<object代阿放到外部,避免点击激活 -->
		<script type="text/javascript" src="ntkoGenOcxObj.js"></script><br>
		<script language="JScript" for="ntkosignctl" event="OnEkeyInserted()">
			//alert("EkeyInserted!");
			EnableEkeyButtons(true);
		</script>
		<script language="JScript" for="ntkosignctl" event="OnEkeyRemoved()">
			//alert("EkeyRemoved!");
			EnableEkeyButtons(false);
		</script>		
		<span id="infomes" style="color:red"></span>	
		<button class="button" onClick="ntkosignctl.IsShowStatus = !ntkosignctl.IsShowStatus;">显示/不显示状态</button>&nbsp;&nbsp;
		<button class="button" onClick="ntkosignctl.IsShowRect = !ntkosignctl.IsShowRect;">显示/不显示矩形</button>&nbsp;&nbsp;
	</td>
	<td valign="top">
		<font color=red>注意：创建新印章时,以下所有信息必须输入。</font><br/><br/>
		印章信息：宽度:<span id="SignWidth">0</span>&nbsp;&nbsp;高度:<span id="SignHeight">0</span><br/>
		印&nbsp; 章&nbsp; 名&nbsp; 称：&nbsp;&nbsp; <input id="SignName" value="<?=$_GET['cname']?>" 
            checked="checked" tabindex="1"><br/>
		印 章 使 用 者:&nbsp;&nbsp;&nbsp; <input id="SignUser" value="<?=$_GET['uname']?>" tabindex="2"><br/>
		印章口令[6-32位]:&nbsp; <input id="Password" value="" tabindex="3"><br/>
		印章序列号[只读]:&nbsp; <input id="SignSN" DISABLED value="" size=43><br/>
		请选择印章源文件(请选择bmp,gif,或者jpg)：<br><input size=50 type=file id="SignFile" tabindex="4"><br/><br/>
		1.新建印章:&nbsp;<button class="button" onClick="CreateNew();" tabindex="5">创建新印章</button>&nbsp;
		<button class="button" onClick="CreateNewWithDialog();" tabindex="6">创建新印章[使用对话框]</button>&nbsp;&nbsp;
		<hr width=100% align="left">
		2.编辑印章:&nbsp;<button class="button" onClick="OpenFromLocal()" tabindex="7">打开本地印章</button>&nbsp;
		<button class="button" onClick="alert(ntkosignctl.LocalFileName);">显示打开的印章文件名</button>&nbsp;	
		<button id="OpenFromEkey" DISABLED class="button" onClick="OpenFromEkey();" tabindex="8">打开EKEY印章修改</button><br/><br/>
		3.保存印章:&nbsp;<button class="button" onClick="SaveToLocal()" tabindex="9">保存印章到本地</button>&nbsp;
		<button id="SaveToEkey" DISABLED class="button" onClick="SaveToEkey();" tabindex="10">保存印章到EKEY</button>&nbsp;<br/><br/>
		4.删除印章:&nbsp;<button id="DeleteFromEkey" DISABLED class="button" onClick="ntkosignctl.DeleteFromEkey();">从EKEY删除印章</button>&nbsp;
		<button id="ResetEkey" DISABLED class="button" onClick="ResetEkeySigns()">初始化EKEY印章</button>&nbsp;
		<hr width=100% align="left">
		<button id="EkeyFreeSize" DISABLED  class="button" onClick="alert('剩余空间:'+ntkosignctl.EkeyFreeSize+'字节.');">显示EKEY剩余容量</button>&nbsp;
		<button class="button" onClick="document.all('SignSN').value = ntkosignctl.SignSN;alert(document.all('SignSN').value);">显示印章SN</button>&nbsp;
		<button id="EkeySN" DISABLED class="button" onClick="alert(ntkosignctl.EkeySN);">显示EKEY SN</button>&nbsp;		
		<hr width=100% align="left">
		EKEY用户名：<input id="EkeyUser" value="<?=$_GET['uname']?>"><br><br>
		<button id="SetEkeyUserName" DISABLED class="button" onClick="SetEkeyUserName()">写入EKEY用户名</button>&nbsp;&nbsp;
		<button id="GetEkeyUserName" DISABLED class="button" onClick="GetEkeyUserName()">读取EKEY用户名</button><br/><br/>
	</td>
</tr>
<tr><td style="background-color:#666;font-size:14px; height:20px; color:#ccc;" colspan="2">EKEY操作部分:</td></tr>
<tr><td  colspan="2">说明:EKEY有2个口令,用户和管理员口令。知道管理员口令可以重新设定用户口令。<br />
		在这儿，用户可以修改EKEY的用户口令，管理员也可以修改EKEY的管理员口令。管理员也可以重新设定
		EKEY的用户口令。</td></tr>
<tr>
<td valign="top">
        <br />
		<font color=red>EKEY用户和管理员口令管理：[用户和管理员使用]</font><br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		旧 口 令：<input id="oldPassword" value=""><br/>
		新口令[4-16位]：<input id="newPassword1" value=""><br/>
		&nbsp;&nbsp;&nbsp;
		确认新口令：<input id="newPassword2" value=""><br/>
		修改EKEY用户口令还是管理员口令:<input type="radio" name="forWho" class="radio" value="0" checked="checked">用户
		<input type="radio" name="forWho" class="radio"  value="1">管理员 <br/>
		&nbsp;&nbsp;&nbsp;&nbsp;<button id="ChangeEkeyPin" DISABLED class="button" onClick="ChangeEkeyPin()">修改EKEY口令</button>&nbsp;&nbsp;<br /><br />
        <span style="color:red">注意:请务必牢记管理员访问口令!如果丢失只能报废EKEY!</span>
		<br /><br />
</td>
<td valign="top">
        <br />
		<font color="red">重新设定EKEY用户口令：[管理员使用]</font><BR>		
		&nbsp;&nbsp;&nbsp;		
		管 理 员 口 令：<input id="adminPassword" value=""><br>
		新用户口令[4-16位]：<input id="newUserPassword1" value=""><br>
		&nbsp;&nbsp;&nbsp;
		确认新用户口令：<input id="newUserPassword2" value=""><br />
        <br/>
		&nbsp;&nbsp;&nbsp;&nbsp;<button id="ResetEkeyUserPin" DISABLED class="button" onClick="ResetEkeyUserPin()">重新设定EKEY用户口令</button>&nbsp;&nbsp;	
</td>
</tr>
</table>
</body>
</html>
