var publicFile = {};
var publicForm = {};
var DeleteFile = {};
publicFile.initRight = function() {
    publicFile.getIds();  //grid视图获得选中数据
    $("[action-type='renameFile']").live('click', publicFile.renameFile);  //重命名事件
	//$("[action-type='updateFile']").live('click', publicFile.updateFile);  //移动事件
	//$("[action-type='moveFile']").live('click', publicFile.moveFile);  //共享事件
	$("[action-type='document_type']").live('click', publicFile.document_type);  //文件夹事件
    $("#uploadFile").live('click', publicFile.showUpload);  //上传按钮触发事件
    $("#folder-grid tbody").live("mouseleave", publicFile.hideMore); 
    $("#folder-grid tr").live('mouseenter', publicFile.showMore);  
    $("#selectAll").live('click', publicFile.selectAll);  //全选操作
};
publicFile.showUpload = function() {
    if ($("#append").length > 0) {
        $("#append").remove();
    }
    $("#upload").modal({
        "backdrop": "static",
        "show": true
    });
};
publicFile.selectAll = function() {
    if (viewType == "kanban") {
        if ($(this).find("i").hasClass("icon-checkbox-unchecked")) {
            $(this).find("i").attr("class", "icon-checkbox-checked");
            $(this).addClass("active");
            if ($("#folder-kanban .kanban-ul li").length > 0) {
                $("#folder-kanban .kanban-ul").children().each(function() {
                    $(this).addClass("selected");
                    $(this).find(".kanban-card").append('<div class="check-wrap"><b class="td-checkbox"></b></div>');
                    $(this).find(".check-wrap").addClass("selected");
                    $(this).find(".td-checkbox").addClass("selected");
                });
            }
        } else {
            $(this).find("i").attr("class", "icon-checkbox-unchecked");
            $(this).removeClass("active");
            if ($("#folder-kanban .kanban-ul").find("li").length > 0) {
                $("#folder-kanban .kanban-ul").children().each(function() {
                    $(this).removeClass("selected");
                    $(this).find(".check-wrap").remove();
                });
            }
        }
    } else {
        if ($(this).find("i").hasClass("icon-checkbox-unchecked")) {
            $('#folder-grid thead input[type=checkbox]').attr('checked', 'checked');
            $(this).find("i").attr("class", "icon-checkbox-checked");
            $(this).addClass("active");
            $('#folder-grid tbody input[name="ids[]"]').each(function() {
                $(this).attr('checked', 'checked');
            });
        } else {
            $(this).find("i").attr("class", "icon-checkbox-unchecked");
            $(this).removeClass("active");
            $('#folder-grid thead input[type=checkbox]').removeAttr('checked');
            $('#folder-grid tbody input[name="ids[]"]').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }
};

publicFile.getIds = function() {
    var ids = new Array();
    $('input[name="ids[]"]').each(function() {
        if ($(this).attr('checked'))
            ids.push($(this).val());
    });
    return ids;
}


publicFile.hideMore = function() {
    $(this).find(".more").children().css({
        "visibility": "hidden"
    });
}
publicFile.showMore = function() {
    $(this).parents("tbody").find(".more").children().css({
        "visibility": "hidden"
    });
    $(this).parents("tbody").find("tr").removeClass("selected");
    $(this).find(".more").children().css({
        "visibility": "visible"
    });
    if ($(this).find(".more").children().hasClass("open")) {
        $(this).find(".more").children().trigger("click");
    }
}
//移动文件夹
publicFile.updateFile = function(fileid,type) {
    $("#updateFile").modal({
        "backdrop": "static",
        "show": true
    });
	if(type==1){
		$("#updateFile #fileid").val(fileid);
	}else{
		$("#updateFile #fileid").val(publicFile.getIds());
	}
}
publicForm.updateFile = function(event) {
	if($("#updateFile #fileid").val()==''){
		$("#updateFile #message-info").text("请至少选中一个文件！");
		$("#updateFile #message-info").fadeIn("slow");
		setTimeout('$("#updateFile #message-info").hide();',2000);
		return (false);
	}
	if($("#typeid").val()==''){
		$("#updateFile #message-info").text("目标文件夹不能为空，请输入！");
		$("#updateFile #message-info").fadeIn("slow");
		setTimeout('$("#updateFile #message-info").hide();',2000);
		return (false);
	}
	jQuery.ajax({
		  type: 'GET',
		  url:  'admin.php?ac=document&fileurl=knowledge&type='+$("#type").val()+'&do=updateFile&typeid='+$("#typeid").val()+'&fileid='+$("#updateFile #fileid").val()+'&date='+new Date(),
		  success: function(data){
			  if(data=='false'){
				  $("#updateFile #message-info").text("文件移动失败，请重新输入！");
				  $("#updateFile #message-info").fadeIn("slow");
				  setTimeout('$("#updateFile #message-info").hide();',2000);
				  return (false);
			  }else if(data=='true'){
				  $('#updateFile').modal("hide");
				  location.reload(true);
			  }
		  }
	   });
}


//文件共享
publicFile.moveFile = function(fileid,type) {
    $("#moveFile").modal({
        "backdrop": "static",
        "show": true
    });
	if(type==1){
		$("#moveFile #fileid").val(fileid);
	}else{
		$("#moveFile #fileid").val(publicFile.getIds());
	}
}
publicForm.movedocument = function(event) {
	if($("#moveFile #fileid").val()==''){
		$("#moveFile #message-info").text("请至少选中一个文件！");
		$("#moveFile #message-info").fadeIn("slow");
		setTimeout('$("#moveFile #message-info").hide();',2000);
		return (false);
	}
	if($("#publicuser").val()==''){
		$("#moveFile #message-info").text("共享人员不能为空，请输入！");
		$("#moveFile #message-info").fadeIn("slow");
		setTimeout('$("#moveFile #message-info").hide();',2000);
		return (false);
	}
	jQuery.ajax({
		  type: 'GET',
		  url:  'admin.php?ac=document&fileurl=knowledge&type='+$("#type").val()+'&do=moveFile&publicuser='+escape($("#publicuser").val())+'&fileid='+$("#moveFile #fileid").val()+'&date='+new Date(),
		  success: function(data){
			  if(data=='false'){
				  $("#moveFile #message-info").text("文件共享失败，请重新输入！");
				  $("#moveFile #message-info").fadeIn("slow");
				  setTimeout('$("#moveFile #message-info").hide();',2000);
				  return (false);
			  }else if(data=='true'){
				  $('#moveFile').modal("hide");
				  location.reload(true);
			  }
		  }
	   });
}

//文件操作
publicFile.renameFile = function(event) {
    $("#renameFile").modal({
        "backdrop": "static",
        "show": true
    });
	$("#renameFile #filename").val($(this).attr("title"));
	$("#renameFile #fileid").val($(this).attr("id"));
	$("#renameFile #filetype").val($(this).attr("filetype"));
}
publicForm.documents = function(event) {
	if($("#renameFile #filename").val()==''){
		$("#renameFile #message-info").text("文件名称不能为空，请输入！");
		$("#renameFile #message-info").fadeIn("slow");
		setTimeout('$("#renameFile #message-info").hide();',2000);
		return (false);
	}
	jQuery.ajax({
		  type: 'GET',
		  url:  'admin.php?ac=document&fileurl=knowledge&type='+$("#type").val()+'&do=add&view=save&title='+escape($("#renameFile #filename").val())+'&id='+$("#renameFile #fileid").val()+'&filetype='+$("#renameFile #filetype").val()+'&date='+new Date(),
		  success: function(data){
			  if(data=='false'){
				  $("#renameFile #message-info").text("文件己经存在，请重新输入！");
				  $("#renameFile #message-info").fadeIn("slow");
				  setTimeout('$("#renameFile #message-info").hide();',2000);
				  return (false);
			  }else if(data=='true'){
				  $('#documents').modal("hide");
				  location.reload(true);
			  }else{
				  $("#renameFile #message-info").text("对不起，您没有权限操作！");
				  $("#renameFile #message-info").fadeIn("slow");
				  setTimeout('$("#renameFile #message-info").hide();',2000);
				  return (false);
			  }
		  }
	   });
}
DeleteFile.documents = function(fileid) {
	if(fileid=='0'){
		var fileid=publicFile.getIds();
	}
	if (fileid!='') {
		if(window.confirm('确定要删除文件吗？删除后将不可还原！')){
			jQuery.ajax({
				  type: 'GET',
				  url:  'admin.php?ac=document&fileurl=knowledge&type='+$("#type").val()+'&do=add&view=del&fileid='+fileid+'&date='+new Date(),
				  success: function(data){
					  if(data=='false'){
						  return (false);
					  }else if(data=='true'){
						  location.reload(true);
					  }else{
						  alert('对不起，您没有权限操作！');
					  }
				  }
			});
		}
	}else{
		alert('请至少选中一个文件!');
	}
}


//文件夹操作
publicFile.document_type = function(event) {
    $("#document_type").modal({
        "backdrop": "static",
        "show": true
    });
	$("#title").val($(this).attr("title"));
	$("#did").val($(this).attr("did"));
}
publicForm.document_type = function(event) {
	if($("#title").val()==''){
		$("#document_type #message-info").text("文件夹名称不能为空，请输入！");
		$("#document_type #message-info").fadeIn("slow");
		setTimeout('$("#document_type #message-info").hide();',2000);
		return (false);
	}
	jQuery.ajax({
		  type: 'GET',
		  url: 'admin.php?ac=document&fileurl=knowledge&type='+$("#type").val()+'&do=documenttype&view=save&title='+escape($("#title").val())+'&did='+$("#did").val()+'&father='+$("#father").val()+'&'+new Date(),
		  success: function(data){
			  if(data=='false'){
				  $("#document_type #message-info").text("文件夹己经存在，请重新输入！");
				  $("#document_type #message-info").fadeIn("slow");
				  setTimeout('$("#document_type #message-info").hide();',2000);
				  return (false);
			  }else if(data=='true'){
				  $('#document_type').modal("hide");
				  location.reload(true);
			  }else{
				  $("#document_type #message-info").text("对不起，您没有权限操作！");
				  $("#document_type #message-info").fadeIn("slow");
				  setTimeout('$("#document_type #message-info").hide();',2000);
				  return (false);
			  }
		  }
	   });
}
DeleteFile.document_type = function(did) {
	if(window.confirm('确定要删除文件夹及里面的文件吗？删除后将不可还原！')){
		jQuery.ajax({
			  type: 'GET',
			  url: 'admin.php?ac=document&fileurl=knowledge&type='+$("#type").val()+'&do=documenttype&view=del&did='+did+'&'+new Date(),
			  success: function(data){
				  if(data=='false'){
					  return (false);
				  }else if(data=='true'){
					  location.reload(true);
				  }else{
					  alert('对不起，您没有权限操作！');
				  }
			  }
		});
	}
}
