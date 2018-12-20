$(document).ready(function() {
    
    $(".chat03_content li").mouseover(function() {
        $(this).addClass("hover").siblings().removeClass("hover")
    }).mouseout(function() {
        $(this).removeClass("hover").siblings().removeClass("hover")
    }),
    $(".chat03_content li").dblclick(function() {
        var b = $(this).index() + 1;
        a = b,
        c = "img/head/20" + (12 + a) + ".jpg",
        d = $(this).find(".chat03_name").text(),
		i = $(this).find(".chat03_id").text(),
		uid = $(this).find(".chat03_uid").text(),
        $(".chat01_content").scrollTop(0),
        $(this).addClass("choosed").siblings().removeClass("choosed"),
        $(".talkTo a").text($(this).children(".chat03_name").text()),
        $(".mes" + b).show().siblings().hide();
		if(i==uid){
			alert('对不起，您不能与自己发起聊天！');
		}else{
			window.open ('../admin.php?ac=sms_online&fileurl=sms&user='+d+'&id='+i+'', 'newwindow'+i+'', 'height=580, width=600, top=70, left=400, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');
		}
    })
}) (jQuery);