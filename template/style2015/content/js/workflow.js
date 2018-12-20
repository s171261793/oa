function check_all(ck) {
	if ($(ck).attr('checked')) {
		$('#folder-grid tbody input[name="ids[]"]').each(function() {
			$(this).attr('checked','checked');
			$(this).parent().parent().addClass('highlight');
		});
	} else {
		$('#folder-grid tbody input[name="ids[]"]').each(function() {
			$(this).removeAttr('checked');
			$(this).parent().parent().removeClass('highlight');
		});
	}
}
function checked_view(name){
	var chk_value =[]; 
	$('input[name="'+name+'"]:checked').each(function(){ 
		chk_value.push($(this).val()); 
	});
	return chk_value;
}
function DeleteFile(url){
	var ids = new Array();
	$('#folder-grid tbody input[name="ids[]"]').each(function() {
	if ($(this).attr('checked'))
		ids.push($(this).val());
	});
	if(ids!=''){
		DeleteForm(ids,url);
	}else{
		$("#MsgShow").modal({
			"backdrop": "static",
			"show": true
		});
		$("#MsgShowContent").text('请至少选择一项可删除的内容！');
		
		//asetTimeout('$("#MsgShow").hide();location.reload(true);',4000);
	}
}
function DeleteForm(ids,url) {
	var urladd=url+'&id='+ids;
	if(window.confirm('确定要删除文件吗？删除后将不可还原！')){
		jQuery.ajax({
			type: 'GET',
			url: urladd,
			success: function(data){
				if(data!=''){
					location.reload(true);
				}
			}
		});
	}
}
function _MSG(message,content){
	$("#"+message).text(content);
	$("#"+message).fadeIn("slow");
	setTimeout('$("#'+message+'").hide();',2000);
}
function entrustadd() {
	if($('input[name="user"]').val()==''){
		_MSG("message-info","被委托人不能为空，请输入！");
		return (false);
	}
	var chk_value =[]; 
	$('input[name="period"]:checked').each(function(){ 
		chk_value.push($(this).val()); 
	}); 
	if(chk_value!=1){
		if($("#startdata").val()=='' || $("#enddate").val()==''){
			_MSG("message-info","有效起止日期不能为空，请输入！");
			return (false);
		}
	}
	var urladd='admin.php?ac=entrust&fileurl=workclass&do=add&id='+$("#id").val()+'&tplid='+$("#tplid").val()+'';
	urladd+="&user="+$('input[name="userid"]').val();
	urladd+="&username="+escape($('input[name="user"]').val());
	urladd+='&period='+chk_value+'&startdata='+$("#startdata").val()+'&enddate='+$("#enddate").val()+'';
	urladd+='&box_content_user='+escape($("#box_content_user").val())+'&sms_box_user='+checked_view("sms_box_user")+'&sms_phone_user='+checked_view("sms_phone_user")+'&date='+new Date();
	jQuery.ajax({
		type: 'GET',
		url: urladd,
		success: function(data){
			if(data=='false'){
				_MSG("message-info","您添加的被委托人己经存在，请重新选择！");
				return (false);
			}else if(data=='true'){
				$('#entrust').modal("hide");
				location.reload(true);
			}else{
				//alert(data);
				_MSG("message-info","意外错误，请刷新浏览器重新操作！");
				return (false);
			}
		}
	});
}
function entrustui(id) {
	var urladd='admin.php?ac=entrust&fileurl=workclass&do=ajax&id='+id;
	jQuery.ajax({
		type: 'GET',
		url: urladd,
		success: function(data){
			if(data!=''){
				$("#modal-bodys").html(data); 
				$("#message-info").hide();
				var chk_value =[]; 
				$('input[name="period"]:checked').each(function(){ 
					chk_value.push($(this).val()); 
				}); 
				if(chk_value==1){
					$("#startdatas").hide();
					$("#enddates").hide();
				}else{
					$("#startdatas").fadeIn("slow");
					$("#enddates").fadeIn("slow");
				}
			}
		}
	});
}
function _MsgShow(msg){
	$("#MsgShow").modal({
		"backdrop": "static",
		"show": true
		});
	$("#MsgShowContent").text(msg);
}
//打开指定的DIV层
function _DIV(ID){
	$(ID).modal({
		"backdrop": "static",
		"show": true
	});
}
function _D(type){
	if(type==1){
		_DIV("#_D");
		$("#d_msg").hide();
	}else{
		if($('input[name="entrust"]').val()==''){
			_MSG("d_msg","被委托人不能为空，请输入！");
			return (false);
		}
		jQuery.ajax({
			type: 'GET',
			url: 'admin.php?ac=workadd&fileurl=workclass&do=actd&perid='+$('input[name="perid"]').val()+'&workid='+$('input[name="workid"]').val()+'&entrust='+$('input[name="entrustid"]').val()+'',
			success: function(data){
				if(data=='true'){
					$('#_D').modal("hide");
					location.reload(true);
				}else if(data=='user'){
					_MSG("d_msg","此用户为主办人或者会签人员，不能委托！");
					return (false);
				}else{
					//alert(data);
					_MSG("d_msg","意外错误，请刷新浏览器重新操作！");
					return (false);
				}
			}
		});
	}
}
function _DT(perid,workid){
   if(window.confirm('确定要取消委托人吗？取消后流程将由您进行办理!')){
      jQuery.ajax({
		  type: 'GET',
		  url: 'admin.php?ac=workadd&fileurl=workclass&do=actd&perid='+perid+'&workid='+workid+'',
		  success: function(data){
			  if(data!=''){
				  location.reload(true);
			  }
		  }
	   });
   }
}
//流程挂起
function _E(type){
	if(type==1){
		_DIV("#_E");
		$("#e_msg").hide();
	}else{
		if($('input[name="hangdate"]').val()==''){
			_MSG("e_msg","挂起时间不能为空，请输入！");
			return (false);
		}
		jQuery.ajax({
			type: 'GET',
			url: 'admin.php?ac=workadd&fileurl=workclass&do=acte&perid='+$('input[name="perid"]').val()+'&workid='+$('input[name="workid"]').val()+'&hangdate='+$('input[name="hangdate"]').val()+'',
			success: function(data){
				if(data=='true'){
					$('#_E').modal("hide");
					location.reload(true);
				}else{
					_MSG("e_msg","意外错误，请刷新浏览器重新操作！");
					return (false);
				}
			}
		});
	}
}
function _ET(perid,workid){
   if(window.confirm('确定要取消挂起吗？取消后流程可开启办理!')){
      jQuery.ajax({
		  type: 'GET',
		  url: 'admin.php?ac=workadd&fileurl=workclass&do=acte&perid='+perid+'&workid='+workid+'',
		  success: function(data){
			  if(data!=''){
				  location.reload(true);
			  }
		  }
	   });
   }
}
//会签
function _F(type){
	if(type==1){
		_DIV("#_F");
		$("#f_msg").hide();
	}else{
		if($('input[name="countersign"]').val()==''){
			_MSG("f_msg","会签人员不能为空，请输入！");
			return (false);
		}
		jQuery.ajax({
			type: 'GET',
			url: 'admin.php?ac=workadd&fileurl=workclass&do=actf&perid='+$('input[name="perid"]').val()+'&workid='+$('input[name="workid"]').val()+'&typeid='+$('input[name="_typeid"]').val()+'&countersign='+$('input[name="countersignid"]').val()+'',
			success: function(data){
				if(data=='true'){
					$('#_F').modal("hide");
					location.reload(true);
				}else if(data=='user1'){
					_MSG("f_msg","您选择的人员己经存在，请重新选择！");
					return (false);
				}else if(data=='user2'){
					_MSG("f_msg","您选择的人员在主办人中存在，请重新选择！");
					return (false);
				}else if(data=='user3'){
					_MSG("f_msg","您选择的人员委托人中己经存在，请重新选择！");
					return (false);
				}else{
					alert(data);
					_MSG("f_msg","意外错误，请刷新浏览器重新操作！");
					return (false);
				}
			}
		});
	}
}
//自动选人
function FlowNextUser(fid,uid){
	if(fid!=''){
		document.getElementById(fid).className = 'active'; 
		jQuery.ajax({
			type: 'GET',
			url: 'admin.php?ac=workflow&fileurl=workclass&do=flow&fid='+fid+'&uid='+uid+'&date='+new Date(),
			success: function(data){
				$("#FlowNextUser").html(data);
			}
		});
	}
}