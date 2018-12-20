 <?php
 /*
	[Office 515158] (C) 2009-2016 天生创想 Inc.
	$Id: online.php 1209087 2015-02-08
*/
define('IN_ADMIN',True);
require_once('../include/common.php');
get_login($_USER->id);
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>在线聊天</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="../template/default/im/css/chatonline.css" />
<script type="text/javascript" src="../template/default/im/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../template/default/im/js/chatonline.js"></script>
<!--[if lt IE 7]>
<script src="../template/default/im/js/IE7.js" type="text/javascript"></script>
<![endif]-->
<!--[if IE 6]>
<script src="../template/default/im/js/iepng.js" type="text/javascript"></script>
<script type="text/javascript">
EvPNG.fix('body, div, ul, img, li, input, a, span ,label'); 
</script>
<![endif]-->
<script type="text/javascript">
online_count()
function online_count()
{
   jQuery.ajax({
      type: 'GET',
      url: 'user_online.php?date='+new Date(),
      success: function(data){
		  $('#user_online').html(data);
      }
   });

   window.setTimeout(online_count,50*10*1000);
}
</script>

</head>
<body>

 <div class="chatRight">
                <div class="chat03">
                    <div class="chat03_title">
                        <label class="chat03_title_t">
                         在线人员</label>
                    </div>
                    <div class="chat03_content" id="user_online">
                    </div>
                </div>
            </div>

</body>
</html>