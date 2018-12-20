<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<script src="template/default/js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script Language="JavaScript"> 
function sendForm(){
   $("#error").html('文件上传中,请不要关闭窗口...');
}
</script>
<title>文件上传</title>
<style type="text/css"> 
<!--
*{ padding:0; margin:0; font-size:12px}
a:link,a:visited{text-decoration:none;color:#0068a6}
a:hover,a:active{color:#ff6600;text-decoration: underline}
.showMsg{border: 1px solid #1e64c8; zoom:1; width:460px; height:198px;}
.showMsg h5{background-image: url(template/default/images/admin_img/msg.png);background-repeat: no-repeat; color:#fff; padding-left:35px; height:25px; line-height:26px;*line-height:28px; overflow:hidden; font-size:14px; text-align:left}
.showMsg .content{ padding:46px 12px 10px 45px; font-size:16px; height:44px; text-align:left}
.showMsg .bottom{  margin: 0 1px 1px 1px;line-height:26px; *line-height:30px; height:26px; text-align:center}
.showMsg .ok,.showMsg .guery{background: url(template/default/images/admin_img/msg_bg.png) no-repeat 0px -560px;}
.showMsg .guery{background-position: left -460px;}
-->
</style>
</head>
<body>
<div class="showMsg" style="text-align:center">
	<h5>文件上传</h5>
	<form action="upload.php?name=<?php echo $_GET[name]?>&filenumber=<?php echo $_GET[filenumber]?>&officetype=<?php echo $_GET[officetype]?>" method="post" enctype="multipart/form-data">
    <div class="content" style="line-height:30px;">文件来源: <input name="src" type="file" style=" width:300px; height:30px;line-height:30px;"/></div>
	<span id="error" style="margin-right:20px; color:#FF0000; font-size:14px;"></span>
    <div class="bottom">
    	<input type="submit"  value="上 传"  style="font-size:20px; width:120px; height:40px;background:#0099FF; border:0px; color:#FFFFFF; font-weight:900" onClick="sendForm();">
	 </div>
	 </form>
</div>
</body>
</html>

