<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link href="uploadflash/css/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="uploadflash/swfupload/swfupload.js"></script>
<script type="text/javascript" src="uploadflash/js/swfupload.queue.js"></script>
<script type="text/javascript" src="uploadflash/js/fileprogress.js"></script>
<script type="text/javascript" src="uploadflash/js/handlers.js"></script>
<script type="text/javascript">
		var swfu;

		window.onload = function() {
			var settings = {
				flash_url : "uploadflash/swfupload/swfupload.swf",
				upload_url: "uploadflash.php?name=<?php echo $_GET[name]?>&filenumber=<?php echo $_GET[filenumber]?>&officetype=<?php echo $_GET[officetype]?>",	// Relative to the SWF file
				post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
				file_size_limit : "1000 MB",
				file_types : "*.*",
				file_types_description : "All Files",
				file_upload_limit : 1000,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: "uploadflash/images/TestImageNoText_65x29.png",	// Relative to the Flash file
				button_width: "65",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '<span class="theFont">浏览</span>',
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,
				
				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};

			swfu = new SWFUpload(settings);
	     };
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
	<form action="uploadflash.php?name=<?php echo $_GET[name]?>&filenumber=<?php echo $_GET[filenumber]?>&officetype=<?php echo $_GET[officetype]?>" method="post" enctype="multipart/form-data">
    <div class="fieldset flash" id="fsUploadProgress">
			<span class="legend">快速上传</span>
	  </div>
		<div id="divStatus">0 个文件已上传</div>
			<div>
				<span id="spanButtonPlaceHolder"></span>
				<input id="btnCancel" type="button" value="取消所有上传" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
			</div>
	 </form>
</div>
</body>
</html>

