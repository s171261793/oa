function sms_list(receiveperson){
	jQuery.ajax({
		type: 'GET',
		url: 'admin.php?ac=sms_online&fileurl=sms&do=ajax&receiveperson='+receiveperson+'&date='+new Date(),
		success: function(data){
			$('#sms_note').html(data);
		}
	});
	//window.setTimeout(sms_list(receiveperson),50*5*1000);
}
function sms_add(receiveperson,note){
	jQuery.ajax({
		type: 'GET',
		url: 'admin.php?ac=sms_online&fileurl=sms&do=add&receiveperson='+receiveperson+'&content='+escape(note),
		 success: function(data){
			 sms_list(receiveperson);
		 }
	});
}
$(document).ready(function() {
    function e() {
        function h() { - 1 != g.indexOf("*#emo_") && (g = g.replace("*#", "<img src='template/default/im/img/").replace("#*", ".gif'/>"), h())
        }
        var g = $("#textarea").val();
		var n = $("#name").val();
		var u = $("#uid").val();
        h();
        sms_add(u,g);
		document.getElementById("textarea").value='';
	}
	$(".close_btn").click(function() {
        window.close();
    }),
	$(".ctb01").mouseover(function() {
        $(".wl_faces_box").show()
    }).mouseout(function() {
        $(".wl_faces_box").hide()
    }),
    $(".wl_faces_box").mouseover(function() {
        $(".wl_faces_box").show()
    }).mouseout(function() {
        $(".wl_faces_box").hide()
    }),
    $(".wl_faces_close").click(function() {
        $(".wl_faces_box").hide()
    }),
    $(".wl_faces_main img").click(function() {
        var a = $(this).attr("src");
        $("#textarea").val($("#textarea").val() + "*#" + a.substr(a.indexOf("img/") + 4, 6) + "#*"),
        $("#textarea").focusEnd(),
        $(".wl_faces_box").hide()
    }),
    $(".chat02_bar img").click(function() {
        e();
    }),
    $.fn.setCursorPosition = function(a) {
        return 0 == this.lengh ? this: $(this).setSelection(a, a)
    },
    $.fn.setSelection = function(a, b) {
        if (0 == this.lengh) return this;
        if (input = this[0], input.createTextRange) {
            var c = input.createTextRange();
            c.collapse(!0),
            c.moveEnd("character", b),
            c.moveStart("character", a),
            c.select()
        } else input.setSelectionRange && (input.focus(), input.setSelectionRange(a, b));
        return this
    },
    $.fn.focusEnd = function() {
        this.setCursorPosition(this.val().length)
    }
}) (jQuery);