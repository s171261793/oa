<!DOCTYPE html>
<!--[if IE 6 ]> <html class="ie6 lte_ie6 lte_ie7 lte_ie8 lte_ie9"> <![endif]--> 
<!--[if lte IE 6 ]> <html class="lte_ie6 lte_ie7 lte_ie8 lte_ie9"> <![endif]--> 
<!--[if lte IE 7 ]> <html class="lte_ie7 lte_ie8 lte_ie9"> <![endif]--> 
<!--[if lte IE 8 ]> <html class="lte_ie8 lte_ie9"> <![endif]--> 
<!--[if lte IE 9 ]> <html class="lte_ie9"> <![endif]--> 
<!--[if (gte IE 10)|!(IE)]><!--><html><!--<![endif]-->
 <head>
    <title>邮件系统</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1" />
</head>
<link rel="stylesheet" type="text/css" href="template/default/email/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="template/default/email/css/style.css" />
<script type="text/javascript" src="template/default/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="template/default/js/bootstrap.min.js"></script>
<script type="text/javascript">
function getContext()
{
    return jQuery('#mail_main')[0].contentWindow;
}

jQuery.noConflict();
(function($){
window.EmailNav = {
        init: function()
        {
            this.$el = $('#email-navbar');
            this.bindEvent();
        },
        bindEvent: function()
        {
            var self = this;
            this.$el.on('click', '[data-cmd]', function(){
                var cmd = this.getAttribute('data-cmd');
                if($(this).hasClass('disabled'))
                {
                    return false;
                }                
                switch(cmd){
                    case 'move_to':
                    	self.trigger(cmd, this.getAttribute('data-bid'));
                        break;
                    default:
                        self.trigger(cmd);
                }                  
            })
        }
        
		
    };

   $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
        $('#email-top-container').on('click', '.email-accordion-list [data-email-accordion]', function(){
            $(this).parents('dl').first().toggleClass('in');
        });
        $('#email-top-container').on('click', 'dd a', function(){
            $('#email-top-container .email-accordion-list dd').removeClass('active');
            $(this).parents('dd').first().addClass('active');
        });        
        $('#write-mail-btn').on('click', function(){
            $('#center iframe').attr('src', 'admin.php?ac=email&fileurl=email&do=add');
        }); 
       $('#unread-mail-btn').on('click', function(){        
            $('#email-top-container .email-accordion-list dd').removeClass('active');
            $('#email-top-container .email-accordion-list dd[data-box="inbox"]').addClass('active');
            $('#center iframe').attr('src', 'admin.php?ac=email&fileurl=email&do=email&type=0');
        });
        
        EmailNav.init();       
        var $active = $('#email-top-container .email-accordion-list dd[data-box="inbox"] a').click();
        $('#center iframe')[0].src = $active.attr('href');
        $('.email-right-handle').click(function(){
            $('#west').toggleClass('west-active');
            
            if($('#west').hasClass('west-active')){
                var today = new Date();
                var expires = new Date();
                expires.setTime(today.getTime() + 1000*60*60*24*365);
                $('#west').width(9);
                $("#center").css("left","9px");
            }
            else{
                var today = new Date();
                var expires = new Date();
                expires.setTime(today.getTime() + 1000*60*60*24*365);
                $('#west').width(220);
                $("#center").css("left","230px");
            }
        });
   });
})(jQuery);



window.onclose = function(){
   var iframe = window.frames['mail_main'];
   if(iframe && typeof(iframe.onclose) == 'function')
	   return iframe.onclose();
	
	return true;
};
</script>
<body>
<style>
html,body{
    overflow: hidden;
    height: 100%;
    margin:0;
    padding: 0;
}
#north{
    position: absolute;
    top:0;
    left:0;
    right:0;
    height:40px;
    min-width: 1218px;
    z-index:5;
}
#center{
    position: absolute;
    top: 41px;
    bottom:0;
    left:230px;
    right:0;
    overflow: hidden;
    border-left: 1px solid #ddd;
}
#west{
    width: 220px;
    position: absolute;
    top:41px;
    left:0;
    bottom:0;
    background: #F0F4F7;
}
#center iframe{
    width: 100%;
    height: 100%;
    display: block;
    position: absolute;
    top:0;
    bottom:0;
    left:0;
    right:0;
}
/* for ie6 */
* html{
    padding-top: 30px;
}
* html #center{
    position: relative;
}
</style>
    <div id="north"> 
        <div id="email-navbar" class="navbar">
            <div class="navbar-inner clearfix">
                <ul id="email-action-list-main" class="email-action-group-main inline pull-left">
                    <li> 
                        <div class="btn-group">
                            <button type="button" id="write-mail-btn" class="btn"> <i class="write-mail-icon"></i>发邮件</button>
                            <button type="button" id="unread-mail-btn" class="btn" title="点击查看新邮件"><i class="unread-mail-icon"></i>未读(<?php echo $num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."recemail WHERE type='0' and receuser='".$_USER->id."'");?>)</button>
                        </div>
                    </li>
                </ul>                 
                <!--<ul  class="email-action-group inline pull-right">
                    <li> 
                        <div class="btn-group">
                          <button type="button" data-cmd="prev" class="btn">上一封</button>
                          <button type="button" data-cmd="next" class="btn">下一封</button>
                        </div>
                    </li>                    
                </ul> -->              
            </div>
        </div>
    </div>
    <div id="west"> 
        <div id="email-top-container">
            <dl class="email-accordion-list in">
                <dt data-email-accordion>邮件管理 <i class="email-accordion-icon-arrow"></i></dt>
                <dd class="active" data-box="inbox">
                    <a href="admin.php?ac=email&fileurl=email&do=email&type=1" target="mail_main" id="inbox_box" class="active"> 
                        <i class="email-accordion-icon-inbox"></i> 
                        收件箱 
                        <span id="inbox0"><?php echo $num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."recemail WHERE (type='0' or type='1') and receuser='".$_USER->id."'");?></span>
                    </a>
                </dd>
                <!--<dd data-box="outbox">
                    <a href="admin.php?ac=email&do=send&fileurl=email&type=1" target="mail_main"> <i class="email-accordion-icon-outbox"></i> 草稿箱 <span id="outbox"><?php echo $num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."sendmail WHERE type='1' and user='".$_USER->id."'");?></span></a>        
                </dd> -->
                <dd data-box="sentbox">           
                    <a href="admin.php?ac=email&do=send&fileurl=email&type=0" target="mail_main"> <i class="email-accordion-icon-sentbox"></i> 发件箱 <span id="sentbox"><?php echo $num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."sendmail WHERE type='0' and user='".$_USER->id."'");?></span></a>        
                </dd>
                <dd data-box="delbox">           
                    <a href="admin.php?ac=email&fileurl=email&do=email&type=2" target="mail_main"> <i class="email-accordion-icon-delbox"></i> 己删除邮件 <span id="delbox"><?php echo $num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."recemail WHERE type='2' and receuser='".$_USER->id."'");?></span></a>         
                </dd>
				<?php
				$sql = "SELECT * FROM ".DB_TABLEPRE."emailtype where uid='".$_USER->id."' ORDER BY number asc";
				$result = $db->query($sql);
				while ($row = $db->fetch_array($result)) {
				?>
				<dd data-box="delbox">           
                    <a href="admin.php?ac=email&fileurl=email&do=email&typeid=<?php echo $row['id']?>&type=1" target="mail_main"> <i class="email-accordion-icon-tags"></i> <?php echo $row['title']?> <span id="delbox"><?php echo $num = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."recemail WHERE typeid='".$row['id']."' and (type='0' or type='1')");?></span></a>         
                </dd>
				<?php }?>
              </dl>
                     
            <dl id="email-tags" class="email-accordion-list">
                <dt data-email-accordion>
                    邮箱设置 <i class="email-accordion-icon-arrow"></i>
                </dt>
                
                <dd>
                    <a href="admin.php?ac=type&fileurl=email" target="mail_main"><i class="email-accordion-icon-tags"></i>邮件类别设置</a>
                </dd>
                <dd><a href="admin.php?ac=pop3&fileurl=email" target="mail_main"> <i class="email-accordion-icon-tags"></i>邮箱账号设置</a></dd>
                <dd><a href="admin.php?ac=mailsignature&fileurl=email" target="mail_main"> <i class="email-accordion-icon-tags"></i>签名设置</a></dd>
                
                            </dl>       
        </div>

        <div class="email-handle-wrap">
            <div class="email-right-handle"></div>
        </div>
    </div>
    <div id="center">   
        <iframe name="mail_main" src="about:blank" border="0" frameborder="0" framespacing="0" marginheight="0" marginwidth="0"></iframe>
    </div>
    <div id="sorth"></div>
 

</html>