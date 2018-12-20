<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>正在与<?php echo $name;?>聊天</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="template/default/im/css/chat.css" />
<!--[if lt IE 7]>
<script src="template/default/im/js/IE7.js" type="text/javascript"></script>
<![endif]-->
<!--[if IE 6]>
<script src="template/default/im/js/iepng.js" type="text/javascript"></script>
<script type="text/javascript">
EvPNG.fix('body, div, ul, img, li, input, a, span ,label'); 
</script>
<![endif]-->
<script type="text/javascript" src="template/default/im/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="template/default/im/js/chat.js"></script>
<script type="text/javascript">
sms_lists();
function sms_lists(){
	jQuery.ajax({
		type: 'GET',
		url: 'admin.php?ac=sms_online&fileurl=sms&do=ajax&receiveperson=<?php echo $uid;?>',
		success: function(data){
			$('#sms_note').html(data);
		}
	});
	window.setTimeout(sms_lists,10*2*1000);
}
</script>
</head>
<body>
<form name="save">
<div class="chatBox">
            <div class="chatLeft">
                <div class="chat01">
                    <div class="chat01_title">
                        <ul class="talkTo">
                            <li><?php echo $name;?> <span style="font-size:14px; color:#999999;"><?php echo get_realdepaname($user['departmentid']);?></span></li></ul>
                        <a class="close_btn" href="javascript:;"></a>
                    </div>
                    <div class="chat01_content">
                        <div class="message_box" >
						<div id="sms_note"></div>
	                    </div>
                        
                    </div>
                </div>
                <div class="chat02">
                    <div class="chat02_title">
                        <a class="chat02_title_btn ctb01" href="javascript:;"></a><!--<a class="chat02_title_btn ctb02"
                            href="javascript:;" onClick="window.open ('admin.php?ac=uploadadd&fileurl=public&name=textarea', 'newwindow', 'height=200, width=480, top=0, left=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')" title="选择文件">
                            
                        </a><a class="chat02_title_btn ctb03" href="javascript:;" title="选择附件">
                            
                        </a> -->
                        <label class="chat02_title_t">
                            <a href="javascript:;"  onClick="window.open ('admin.php?ac=sms_online&fileurl=sms&do=view&receiveperson=<?php echo $uid;?>&test=&modid=&tplid=8891', 'newwindow', 'height=550, width=900, top=6, right=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')">聊天记录</a></label>
                        <div class="wl_faces_box">
                            <div class="wl_faces_content">
                                <div class="title">
                                    <ul>
                                        <li class="title_name">常用表情</li><li class="wl_faces_close"><span>&nbsp;</span></li></ul>
                                </div>
                                <div class="wl_faces_main">
                                    <ul>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_01.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_02.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_03.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_04.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_05.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_06.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_07.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_08.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_09.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_10.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_11.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_12.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_13.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_14.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_15.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_16.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_17.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_18.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_19.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_20.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_21.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_22.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_23.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_24.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_25.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_26.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_27.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_28.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_29.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_30.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_31.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_32.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_33.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_34.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_35.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_36.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_37.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_38.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_39.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_40.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_41.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_42.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_43.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_44.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_45.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_46.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_47.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_48.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_49.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_50.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_51.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_52.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_53.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_54.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_55.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_56.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_57.gif" /></a></li>
                                        <li><a href="javascript:;">
                                            <img src="template/default/im/img/emo_58.gif" /></a></li><li><a href="javascript:;">
                                                <img src="template/default/im/img/emo_59.gif" /></a></li><li><a href="javascript:;">
                                                    <img src="template/default/im/img/emo_60.gif" /></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="wlf_icon">
                            </div>
                        </div>
                    </div>
                    <div class="chat02_content">
                        <textarea id="textarea" name="textarea"></textarea>
						<input type="hidden" id="uid" value="<?php echo $uid;?>" />
						<input type="hidden" id="name" value="<?php echo $name;?>" />
                    </div>
                    <div class="chat02_bar">
                        <ul>
                            
                            <li style="right: 5px; top: 5px;"><a href="javascript:;">
                                <img src="template/default/im/img/send_btn.jpg"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div style="clear: both;">
            </div>
        </div>
</form>
</body>
</html>