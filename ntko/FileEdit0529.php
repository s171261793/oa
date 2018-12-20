<?php
require 'connectionInfo.php';
?>
<?php
if($_GET['uid']!=''){
	$user = $db->fetch_one_array("SELECT name FROM ".DB_TABLEPRE."user_view where uid='".$_GET['uid']."'  ORDER BY uid desc");
	$username=$user['name'];
}
$isNewFile="";
$filetype="";
$fileId="";
$fileName="";
$fileUrl="";
$isppt=false;
$attachFileName="";
$attachFileDescribe="";
$attachFileUrl="";
$templateFileUrl="templateFile/";//新建文档模板url
$otherData="";
//判断是否是编辑文件传过来的请求。
if($_GET['FileId']!='51515800000'){
	$fileId=trim($_GET['FileId']);
}
//$fileId = $_GET['FileId']==null?'':trim($_GET['FileId']);//判断是否指定了文件
//如果有请求则编辑文件否则创建
 if($fileId==''){
    $isNewFile = true;
}else{
    $isNewFile = false;
}
//如果是创建文件
if($isNewFile){
    $filetype =$_GET['fileType']==null?"":trim($_GET['fileType']);//如果filetype参数为空,默认为word文档.
    
    if(strnatcasecmp($filetype,"ppt")==0){
        $fileName=$_GET['filenumber'].".ppt";
        $templateFileUrl=$templateFileUrl."newPPTTemplate.ppt";
    }else if(strnatcasecmp($filetype,"word")==0){
        $fileName=$_GET['filenumber'].".doc";
        $templateFileUrl=$templateFileUrl."newWordTemplate.doc";
    }else if(strnatcasecmp($filetype,"excel")==0){
        $fileName=$_GET['filenumber'].".xls";
        $templateFileUrl = $templateFileUrl."newExcelTemplate.xls";
    }
    $fileUrl = $templateFileUrl;    //如果是新文档，控件打开新建模板文档
}else{
    //如果是编辑文件
	$row = $db->fetch_one_array("SELECT * FROM toa_".$officeFileInfoTableName."  WHERE id = '$fileId'");
        $fileName = $row['filename'];
//        $fileUrl = iconv( "UTF-8", "gb2312//IGNORE" , $relativeOfficeFileUrl.$row['filenamedisk']);//转换格式
        $fileUrl = $relativeOfficeFileUrl.$row['filenamedisk'];
        if($row['filetype']=='PowerPoint.Show'){
            $isppt=true;
        }
        $otherData = $row['otherdata'];
        $attachFileDescribe = $row['attachfiledescribe']==''?'':trim($row['attachfiledescribe']);
        $attachFileName = $row['attachfilenamedisk']==''?'':trim($row['attachfilenamedisk']);
        $attachFileUrl = $attachFileName==''?'':($relativeAttachFileUrl.$attachFileName);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<link rel="stylesheet" type="text/css" href="../template/default/content/css/style.css">
<SCRIPT LANGUAGE="JavaScript">
var OFFICE_CONTROL_OBJ;//控件对象
var IsFileOpened;      //控件是否打开文档
var fileType;
function intializePage(fileUrl)
{
	OFFICE_CONTROL_OBJ=document.all("TANGER_OCX");
	//alert(fileUrl);
	TANGER_OCX_OpenDoc(fileUrl);
	if(!OFFICE_CONTROL_OBJ.IsNTKOSecSignInstalled())
	{
		document.all("addSecSignFromUrl").disabled = true;
		document.all("addSecSignFromLocal").disabled = true;
		document.all("addSecSignFromEkey").disabled = true;
		document.all("handSecSign").disabled = true;
	}
	if(!OFFICE_CONTROL_OBJ.IsPDFCreatorInstalled())
	{
		document.all("savePdfTOUrl").disabled = true;
	}
}
function onPageClose()
{
	if(!OFFICE_CONTROL_OBJ.activeDocument.saved)
	{
		if(confirm( "文档修改过,还没有保存,是否需要保存?"))
		{
			saveFileToUrl();
		}
	}
}
function TANGER_OCX_OpenDoc(fileUrl)
{
	OFFICE_CONTROL_OBJ.BeginOpenFromURL(fileUrl);
}
function setFileOpenedOrClosed(bool)
{
	IsFileOpened = bool;
	fileType = OFFICE_CONTROL_OBJ.DocType ;
}
function trim(str)
{ //删除左右两端的空格
　　return str.replace(/(^\s*)|(\s*$)/g, "");
}
function saveFileToUrl()
{
	var myUrl =document.forms[0].action ;
	var fileName = document.all("fileName").value;
	var result  ;
	if(IsFileOpened)
	{
		switch (OFFICE_CONTROL_OBJ.doctype)
		{
			case 1:
				fileType = "Word.Document";
				break;
			case 2:
				fileType = "Excel.Sheet";
				break;
			case 3:
				fileType = "PowerPoint.Show";
				break;
			case 4:
				fileType = "Visio.Drawing";
				break;
			case 5:
				fileType = "MSProject.Project";
				break;
			case 6:
				fileType = "WPS Doc";
				break;
			case 7:
				fileType = "Kingsoft Sheet";
				break;
			default :
				fileType = "unkownfiletype";
		}
		result = OFFICE_CONTROL_OBJ.saveToURL(myUrl,//提交到的url地址
		"upLoadFile",//文件域的id，类似<input type=file id=upLoadFile 中的id
		"fileType="+fileType,          //与控件一起提交的参数如："p1=a&p2=b&p3=c"
		fileName,    //上传文件的名称，类似<input type=file 的value
		"myfrom1"    //与控件一起提交的表单id，也可以是form的序列号，这里应该是0.
		);
		//result=trim(result);
		//document.all("statusBar").innerHTML="服务器返回信息:"+result;
		//alert(result);
		window.opener.document.save.fileofficeid.value='fdsfds';
		window.close();
	}
}

function saveFileAsHtmlToUrl()
{
	var myUrl = "upLoadHtmlFile.php"	;
	var htmlFileName = document.all("fileName").value+".html";
	var result;
	if(IsFileOpened)
	{
		result=OFFICE_CONTROL_OBJ.PublishAsHTMLToURL("upLoadHtmlFile.php","uploadHtml","htmlFileName="+htmlFileName,htmlFileName);
		result=trim(result);
		document.all("statusBar").innerHTML="服务器返回信息:"+result;
		alert(result);
		window.close();
	}
}
function saveFileAsPdfToUrl()
{
	//alert('进来了');
	var myUrl = "upLoadPdfFile.php"	;
	var pdfFileName = document.all("fileName").value+".pdf";
	if(IsFileOpened)
	{
		OFFICE_CONTROL_OBJ.PublishAsPdfToURL(myUrl,"uploadPdf","PdfFileName="+pdfFileName,pdfFileName,"","",true,false);
	}
}
function testFunction()
{
	alert(IsFileOpened);
}
function addServerSecSign()
{
	var signUrl=document.all("secSignFileUrl").options[document.all("secSignFileUrl").selectedIndex].value;
	if(IsFileOpened)
	{
		if(OFFICE_CONTROL_OBJ.doctype==1||OFFICE_CONTROL_OBJ.doctype==2)
		{
			try
			{OFFICE_CONTROL_OBJ.AddSecSignFromURL("ntko",signUrl);}
			catch(error){}
		}
		else
		{alert("不能在该类型文档中使用安全签名印章.");}
	}
}
function addLocalSecSign()
{
	if(IsFileOpened)
	{
		if(OFFICE_CONTROL_OBJ.doctype==1||OFFICE_CONTROL_OBJ.doctype==2)
		{
			try
			{OFFICE_CONTROL_OBJ.AddSecSignFromLocal("ntko","");}
			catch(error){}
		}
		else
		{alert("不能在该类型文档中使用安全签名印章.");}
	}
}
function addEkeySecSign()
{
	if(IsFileOpened)
	{
		if(OFFICE_CONTROL_OBJ.doctype==1||OFFICE_CONTROL_OBJ.doctype==2)
		{
			try
			{OFFICE_CONTROL_OBJ.AddSecSignFromEkey("ntko");}
			catch(error){}
		}
		else
		{alert("不能在该类型文档中使用安全签名印章.");}
	}
}
function addHandSecSign()
{
	if(IsFileOpened)
	{
		if(OFFICE_CONTROL_OBJ.doctype==1||OFFICE_CONTROL_OBJ.doctype==2)
		{
			try
			{OFFICE_CONTROL_OBJ.AddSecHandSign("ntko");}
			catch(error){}
		}
		else
		{alert("不能在该类型文档中使用安全签名印章.");}
	}
}

function addServerSign(signUrl)
{
	if(IsFileOpened)
	{
			try
			{
				OFFICE_CONTROL_OBJ.AddSignFromURL("<?=$username?>",//印章的用户名
				signUrl,//印章所在服务器相对url
				100,//左边距
				100,//上边距 根据Relative的设定选择不同参照对象
				"ntko",//调用DoCheckSign函数签名印章信息,用来验证印章的字符串
				3,  //Relative,取值1-4。设置左边距和上边距相对以下对象所在的位置 1：光标位置；2：页边距；3：页面距离 4：默认设置栏，段落
				100,//缩放印章,默认100%
				1);   //0印章位于文字下方,1位于上方

			}
			catch(error){}
	}
}

function addLocalSign()
{
	if(IsFileOpened)
	{
			try
			{
				OFFICE_CONTROL_OBJ.AddSignFromLocal("<?=$username?>",//印章的用户名
					"",//缺省文件名
					true,//是否提示选择
					100,//左边距
					100,//上边距 根据Relative的设定选择不同参照对象
					"ntko",//调用DoCheckSign函数签名印章信息,用来验证印章的字符串
					3,  //Relative,取值1-4。设置左边距和上边距相对以下对象所在的位置 1：光标位置；2：页边距；3：页面距离 4：默认设置栏，段落
					100,//缩放印章,默认100%
					1);   //0印章位于文字下方,1位于上方
			}
			catch(error){}
	}
}
function addPicFromUrl(picURL)
{
	if(IsFileOpened)
	{
		if(OFFICE_CONTROL_OBJ.doctype==1||OFFICE_CONTROL_OBJ.doctype==2)
		{
			try
			{
				OFFICE_CONTROL_OBJ.AddPicFromURL(picURL,//图片的url地址可以时相对或者绝对地址
				false,//是否浮动,此参数设置为false时,top和left无效
				100,//left 左边距
				100,//top 上边距 根据Relative的设定选择不同参照对象
				1,  //Relative,取值1-4。设置左边距和上边距相对以下对象所在的位置 1：光标位置；2：页边距；3：页面距离 4：默认设置栏，段落
				100,//缩放印章,默认100%
				1);   //0印章位于文字下方,1位于上方

			}
			catch(error){}
		}
		else
		{alert("不能在该类型文档中使用安全签名印章.");}
	}
}
function addPicFromLocal()
{
	if(IsFileOpened)
	{
			try
			{
				OFFICE_CONTROL_OBJ.AddPicFromLocal("<?=$username?>",//印章的用户名
					true,//缺省文件名
					false,//是否提示选择
					100,//左边距
					100,//上边距 根据Relative的设定选择不同参照对象
					1,  //Relative,取值1-4。设置左边距和上边距相对以下对象所在的位置 1：光标位置；2：页边距；3：页面距离 4：默认设置栏，段落
					100,//缩放印章,默认100%
					1);   //0印章位于文字下方,1位于上方
			}
			catch(error){}
	}
}

function TANGER_OCX_AddDocHeader(strHeader)
{
	if(!IsFileOpened)
	{return;}
	var i,cNum = 30;
	var lineStr = "";
	try
	{
		for(i=0;i<cNum;i++) lineStr += "_";  //生成下划线
		with(OFFICE_CONTROL_OBJ.ActiveDocument.Application)
		{
			Selection.HomeKey(6,0); // go home
			Selection.TypeText(strHeader);
			Selection.TypeParagraph(); 	//换行
			Selection.TypeText(lineStr);  //插入下划线
			// Selection.InsertSymbol(95,"",true); //插入下划线
			Selection.TypeText("★");
			Selection.TypeText(lineStr);  //插入下划线
			Selection.TypeParagraph();
			//Selection.MoveUp(5, 2, 1); //上移两行，且按住Shift键，相当于选择两行
			Selection.HomeKey(6,1);  //选择到文件头部所有文本
			Selection.ParagraphFormat.Alignment = 1; //居中对齐
			with(Selection.Font)
			{
				NameFarEast = "宋体";
				Name = "宋体";
				Size = 12;
				Bold = false;
				Italic = false;
				Underline = 0;
				UnderlineColor = 0;
				StrikeThrough = false;
				DoubleStrikeThrough = false;
				Outline = false;
				Emboss = false;
				Shadow = false;
				Hidden = false;
				SmallCaps = false;
				AllCaps = false;
				Color = 255;
				Engrave = false;
				Superscript = false;
				Subscript = false;
				Spacing = 0;
				Scaling = 100;
				Position = 0;
				Kerning = 0;
				Animation = 0;
				DisableCharacterSpaceGrid = false;
				EmphasisMark = 0;
			}
			Selection.MoveDown(5, 3, 0); //下移3行
		}
	}
	catch(err){
		alert("错误：" + err.number + ":" + err.description);
	}
	finally{
	}
}

function insertRedHeadFromUrl(headFileURL)
{
	if(OFFICE_CONTROL_OBJ.doctype!=1)//OFFICE_CONTROL_OBJ.doctype=1为word文档
	{return;}
	OFFICE_CONTROL_OBJ.ActiveDocument.Application.Selection.HomeKey(6,0);//光标移动到文档开头
	OFFICE_CONTROL_OBJ.addtemplatefromurl(headFileURL);//在光标位置插入红头文档
}
function openTemplateFileFromUrl(templateUrl)
{
	OFFICE_CONTROL_OBJ.openFromUrl(templateUrl);
}
function doHandSign()
{
	/*if(OFFICE_CONTROL_OBJ.doctype==1||OFFICE_CONTROL_OBJ.doctype==2)//此处设置只允许在word和excel中盖章.doctype=1是"word"文档,doctype=2是"excel"文档
	{*/
		OFFICE_CONTROL_OBJ.DoHandSign2(
									"<?=$username?>",//手写签名用户名称
									"ntko",//signkey,DoCheckSign(检查印章函数)需要的验证密钥。
									0,//left
									0,//top
									1,//relative,设定签名位置的参照对象.0：表示按照屏幕位置插入，此时，Left,Top属性不起作用。1：光标位置；2：页边距；3：页面距离 4：默认设置栏，段落（为兼容以前版本默认方式）
									100);
	//}
}
function SetReviewMode(boolvalue)
{

	if(OFFICE_CONTROL_OBJ.doctype==1)
	{
		OFFICE_CONTROL_OBJ.ActiveDocument.TrackRevisions = boolvalue;//设置是否保留痕迹
	}
}

function setShowRevisions(boolevalue)
{
	if(OFFICE_CONTROL_OBJ.doctype==1)
	{
		OFFICE_CONTROL_OBJ.ActiveDocument.ShowRevisions =boolevalue;//设置是否显示痕迹
	}
}
function setFilePrint(boolvalue)
{
	OFFICE_CONTROL_OBJ.fileprint=boolvalue;//是否允许打印
}
function setFileNew(boolvalue)
{
	OFFICE_CONTROL_OBJ.FileNew=boolvalue;//是否允许新建
}
function setFileSaveAs(boolvalue)
{
	OFFICE_CONTROL_OBJ.FileSaveAs=boolvalue;//是否允许另存为
}

function setIsNoCopy(boolvalue)
{
	OFFICE_CONTROL_OBJ.IsNoCopy=boolvalue;//是否禁止粘贴
}
function DoCheckSign()
{
   if(IsFileOpened)
   {
			var ret = OFFICE_CONTROL_OBJ.DoCheckSign
			(
			false,/*可选参数 IsSilent 缺省为FAlSE，表示弹出验证对话框,否则，只是返回验证结果到返回值*/
			"ntko"//使用盖章时的signkey,这里为"ntko"
			);//返回值，验证结果字符串
			//alert(ret);
   }
}
function setToolBar()
{
	OFFICE_CONTROL_OBJ.ToolBars=!OFFICE_CONTROL_OBJ.ToolBars;
}
function setMenubar()
{
		OFFICE_CONTROL_OBJ.Menubar=!OFFICE_CONTROL_OBJ.Menubar;
}
function setInsertMemu()
{
		OFFICE_CONTROL_OBJ.IsShowInsertMenu=!OFFICE_CONTROL_OBJ.IsShowInsertMenu;
	}
function setEditMenu()
{
		OFFICE_CONTROL_OBJ.IsShowEditMenu=!OFFICE_CONTROL_OBJ.IsShowEditMenu;
	}
function setToolMenu()
{
	OFFICE_CONTROL_OBJ.IsShowToolMenu=!OFFICE_CONTROL_OBJ.IsShowToolMenu;
}

</SCRIPT>
<title>Office 515158 2011 OA办公系统</title>
</head>
<body onload='intializePage("<?php echo $fileUrl ?>");' onbeforeunload ="onPageClose()">

<form id="form1" name="myfrom1" action="upLoadOfficeFile.php" enctype="multipart/form-data" style="padding:0px;margin:0px;" >
	<input type="hidden" name="fileId" value="<?=$fileId?>" />
	<input type="hidden" name="fileName" value="<?=$fileName?>" />
	<input type="hidden" name="filenumber" class="BigInput" value="<?=$_GET['filenumber']?>" />
	<input type="hidden" name="officetype" class="BigInput" value="<?=$_GET['officetype']?>" />
	<input type="hidden" name="uid" class="BigInput" value="<?=$_GET['uid']?>" />
	<input type="hidden" name="date" class="BigInput" value="<?=$_GET['date']?>" />
	<input type="hidden" name="otherData" id="otherdata" value="<?=$otherData?>" />
	<input type="hidden" name="attachFile" value="" />
	<?php
                                            if($isNewFile||strnatcasecmp($attachFileUrl,'')==0){
                                                echo  '<input name="attachFileDescribe" class="textstyle" type=hidden id=attachFileDescribe>';
                                            }else{
                                            print '已经存在的附件' ;
                                                echo '文档附件：<a href="'.$attachFileUrl.'" target=uploadattachfile>点击下载</a>&nbsp;'.($attachFileDescribe==''?'没有备注':$attachFileDescribe).')<br>';
                                                echo '<input name="attachFileDescribe" value="'.$attachFileDescribe.'" class="textstyle" type=hidden id=attachFileDescribe>';
                                            }
?>
<table class="TableBlock" border="0" width="90%" align="center" style="margin-top:30px;">
  
	<tr>
      <td nowrap class="TableContent" width="12%">文件操作：</td>
      <td class="TableData"><input type="button" value="保存文件" class="BigButtonBHover" onclick="saveFileToUrl();">
	  <input type="button" value="历史版本" class="BigButtonBHover" onclick="ShowHistory()">
	  <input type="button" value="页面设置" class="BigButtonBHover" onclick="OFFICE_CONTROL_OBJ.showDialog(5);">
	  <input type="button" value="文件打印" class="BigButtonBHover" onclick="OFFICE_CONTROL_OBJ.PrintPreview();">
	  
	  </td>
    </tr>
	
	<tr>
      <td nowrap class="TableContent" width="12%">文件编辑：</td>
      <td class="TableData">
	   <a href="#" onclick="SetReviewMode(true)" style="font-size:14px;">保留痕迹</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	   <a href="#" onclick="SetReviewMode(false)" style="font-size:14px;">不留痕迹</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	   <a href="#" onclick="setShowRevisions(true)" style="font-size:14px;">显示痕迹</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	   <a href="#" onclick="setShowRevisions(false)" style="font-size:14px;">隐藏痕迹</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	   <a href="#" onclick="addPicFromLocal();" style="font-size:14px;">插入图片</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	   <font color="#FF0000">文件套红:</font>
	  <select id=redHeadTemplateFile onchange="var headFileURL=document.all('redHeadTemplateFile').options[document.all('redHeadTemplateFile').selectedIndex].value;insertRedHeadFromUrl(headFileURL);">
	<option value="" selected>选择红头文件</option>  
     <?php
	  $query = $db->query("SELECT * FROM ".DB_TABLEPRE."seal where uid='".$_GET['uid']."' and sealtype='2' ORDER BY id desc");
	while ($seal = $db->fetch_array($query)) {?>
<option value="../<?=$seal['sealurl']?>"><?=$seal['sealtitle']?></option>
<?php }?>
								</select>
	  
	  
	  
	  
	  </td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="12%">安全认证：(基础)</td>
      <td class="TableData">
	  <a href="#" onclick=DoCheckSign(); style="font-size:14px;">印章验证</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	  <a href="#" onclick=doHandSign(); style="font-size:14px;">手写签名</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	  <a href="#" onclick=addLocalSign(); style="font-size:14px;">电子印章(本地)</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	  <a href="#" style="font-size:14px;color:red;">电子印章(服务器)：</a><select id="SignFileUrl" onchange="var signUrl=document.all('SignFileUrl').options[document.all('SignFileUrl').selectedIndex].value;if(signUrl==''){};else addServerSign(signUrl);">
	  <option value="" selected></option>
	  <?php
	  $query = $db->query("SELECT * FROM ".DB_TABLEPRE."seal where uid='".$_GET['uid']."' and sealtype='1' ORDER BY id desc");
	while ($seal = $db->fetch_array($query)) {?>
<option value="../<?=$seal['sealurl']?>"><?=$seal['sealtitle']?></option>
<?php }?>
                                </select>&nbsp;&nbsp;|&nbsp;&nbsp;
	  <a href="#" onclick=OFFICE_CONTROL_OBJ.SetReadOnly(true,'',1); style="font-size:14px;">保护印章</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	  <a href="#" onclick=OFFICE_CONTROL_OBJ.SetReadOnly(false); style="font-size:14px;">取消保护</a>
	  
	  
	 
	  </td>
    </tr>
	<tr>
      <td nowrap class="TableContent" width="12%">安全认证：(安全)</td>
      <td class="TableData">
	   <a href="#" onclick="addLocalSecSign();" style="font-size:14px;">电子印章(本地)</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	    <select id="secSignFileUrl">
      <option value="" selected></option>
	  <?php
	  $query = $db->query("SELECT * FROM ".DB_TABLEPRE."seal where uid='".$_GET['uid']."' and sealtype='1'  ORDER BY id desc");
	while ($seal = $db->fetch_array($query)) {?>
<option value="../<?=$seal['sealurl']?>"><?=$seal['sealtitle']?></option>
<?php }?>
                            </select><a href="#" onclick="addServerSecSign();" style="font-size:14px;">电子印章(服务器)</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	   <a href="#" onclick="addHandSecSign();" style="font-size:14px;">手写签名</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	   <a href="#" onclick="addEkeySecSign();" style="font-size:14px;">EKEY盖章</a>
	    </td>
    </tr>
<!--	<tr>
      <td nowrap class="TableHeader" colspan="2"><b>&nbsp;正文</b></td>
    </tr> -->
	
	<tr>
      <td colspan="2" height="800">
	   <div id="officecontrol" height="800">
	  <!--引用NTKO OFFICE文档控件-->
<script type="text/javascript">
document.write('<!-- 用来产生编辑状态的ActiveX控件的JS脚本-->   ');
document.write('<!-- 因为微软的ActiveX新机制，需要一个外部引入的js-->   ');
document.write('<object id="TANGER_OCX" classid="clsid:A39F1330-3322-4a1d-9BF0-0BA2BB90E970"    ');
document.write('codebase="officecontrol/OfficeControl.cab#version=5,0,1,2" width="100%" height="800">   ');
document.write('<param name="IsUseUTF8URL" value="-1">   ');
document.write('<param name="IsUseUTF8Data" value="-1">   ');
document.write('<param name="BorderStyle" value="1">   ');
document.write('<param name="BorderColor" value="14402205">   ');
document.write('<param name="TitlebarColor" value="15658734">   ');
document.write('<param name="TitlebarTextColor" value="0">   ');
document.write('<param name="MenubarColor" value="14402205">   ');
document.write('<param name="MenuButtonColor" VALUE="16180947">   ');
document.write('<param name="MenuBarStyle" value="3">   ');
document.write('<param name="MenuButtonStyle" value="7">   ');
document.write('<param name="WebUserName" value="fdsfds">   ');
document.write('<param name="Caption" value="NTKO OFFICE文档控件示例演示">   ');
document.write('<SPAN STYLE="color:red">不能装载文档控件。请在检查浏览器的选项中检查浏览器的安全设置。</SPAN>   ');
document.write('</object>');
</script>
                           <!--<div id=statusBar></div> -->
	<script language="JScript" for=TANGER_OCX event="OnFileCommand(cmd,canceled)">
		alert(cmd);
		CancelLastCommand=true;
	</script>
	<script language="JScript" for=TANGER_OCX event="OnDocumentClosed()">
		setFileOpenedOrClosed(false);
	</script>
	<script language="JScript" for=TANGER_OCX event="OnDocumentOpened(TANGER_OCX_str,TANGER_OCX_obj)">
		OFFICE_CONTROL_OBJ.ActiveDocument.Saved = true;//saved属性用来判断文档是否被修改过,文档打开的时候设置成ture,当文档被修改,自动被设置为false,该属性由office提供.
		setFileOpenedOrClosed(true);
	</script>
		<script language="JScript" for=TANGER_OCX event="BeforeOriginalMenuCommand(TANGER_OCX_str,TANGER_OCX_obj)">
		alert("BeforeOriginalMenuCommand事件被触发");
	</script>
	<script language="JScript" for=TANGER_OCX event="OnFileCommand(TANGER_OCX_str,TANGER_OCX_obj)">
		if (TANGER_OCX_str == 3)
		{
			alert("不能保存！");
			CancelLastCommand = true;
		}
	</script>
	<script language="JScript" for=TANGER_OCX event="AfterPublishAsPDFToURL(result,code)">
		result=trim(result);
		document.all("statusBar").innerHTML="服务器返回信息:"+result;
		if(result=="succeed")
		{window.close();}
	</script>
	</div>
	  </td>
	</tr>


  </table>
</form>
 
</body>
</html>
