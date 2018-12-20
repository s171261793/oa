<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
        <link rel="stylesheet" type="text/css" href="template/default/content/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="template/default/content/css/bootstrap-modal.css" />
		<link rel="stylesheet" type="text/css" href="template/default/content/css/main.css" />
		<link rel="stylesheet" type="text/css" href="template/default/content/css/jquery.fileupload-ui.css" />
		<link rel="stylesheet" type="text/css" href="template/default/content/css/search.css" />
		<script type="text/javascript" src="template/default/content/js/jquery.min.js"></script>
		<script type="text/javascript" src="template/default/content/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="template/default/content/js/bootstrap-modal.js"></script>
		<script type="text/javascript" src="template/default/content/js/bootstrap-modalmanager.js"></script>
		<script type="text/javascript" src="template/default/content/js/jquery.fancybox-1.3.1.pack.js"></script>
		<script type="text/javascript">
		/*<![CDATA[*/
					var winType = 'modal';
					if (window.ActiveXObject){
						var ua = navigator.userAgent.toLowerCase();
						var ieVersion = ua.match(/msie ([\d.]+)/)[1];
						if(ieVersion === '8.0'){
							winType = '';
						}
					}
					function selectoropen(url){
						TUtil.openUrl(url, winType, "selectorwindow", "600", "400")
					}
						
					function selectorclear(fid, fname){
						$("#"+fid) && $("#"+fid).val("");
						$("#"+fname) && $("#"+fname).val("");
					}
		/*]]>*/
		</script>
		<title>公共文件柜</title>
        <link rel="stylesheet" type="text/css" href="template/default/content/css/bootstrap.css"> 
        <link rel="stylesheet" type="text/css" href="template/default/content/css/base.css">
		<!--<link rel="stylesheet" href="template/default/upload/css/bootstrap.min.css"> -->
   </head>
	<body ><!--style="overflow: hidden;"> -->
		<div id="yw13" class="td-nav">
			<table class="td-nav-table"><tr>
			<td>
				<span class='ellipsis' style='display:inline-block;width:18px;'>
					<img src="template/default/content/images/folder.gif"/>
				</span>
				<span class='ellipsis folder_name' style='display:inline-block;padding-right: 30px;width: 300px;'>
					<?php
					if($father!=0){
						echo $_title['title'].' - '.public_value('title','document_type','id='.$father);
					}else{
						echo $_title['title'];
					}
					?>
				</span>
			
				<div class="pull-right">
				<form method="get" action="admin.php" name="topSearchForm" >
				<input type="hidden" name="ac" value="<?php echo $ac?>" />
				<input type="hidden" name="type" value="<?php echo $type;?>" />
				<input type="hidden" name="do" value="list" />
				<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
					<div class="smartsearch">
					<input name='title'  style="margin-top:4px; height:22px;" value="<?php echo urldecode($title)?>"  placeholder='根据文件名搜索......'/>
						<a href="javascript:document:topSearchForm.submit();" style="margin-right:5px; margin-bottom:5px;" class="btn btn-primary">
							<i class="icon-upload-6"></i> 查询
						</a> 
	
					</div>
				</form>
				</div>
			
			</td>
			</tr>
			</table>
		</div>
	<div class="content" >
		<div style="padding-top:5px;">
			<style>
				#upload  .move-bottom{position: absolute;bottom:-86px;left:auto;right:16px;z-index:1200;}
				#upload  .move-right{position: absolute;bottom:-50px;right:16px;z-index:1200;}
				#message-info {
					width: 500px;
					text-align:center;
					height: 30px;
					padding: 0;
					margin: 0;
					font-size: 16px;
					color:#FF0000;
				}.progressbar {
					width: 0px;
					height: 25px;
					margin - bottom: 20px;
					background:#006633;
				    color:#FFFFFF;
					font-size:14px;
					font-weight:bold;
				}
	</style>
			
			<!--上传文件开始-->
 			<div style="height:395px;min-width:700px !important;" id="upload" class="modal hide fade">
				<div class="modal-header">
					<a class="close" data-dismiss="modal"  onClick="locations();">×</a>
					<h4>上传文件</h4>
				</div>
				<div class="modal-body" style="overflow: visible !important;position: relative !important;">
					<div class="drop-box" style="overflow-x:hidden;overflow-y:auto;min-width:670px;height: 210px;text-align: center;border: 2px dashed #DCDCDC;border-radius: 5px;padding-top:2px;">
						<div class="fileupload-buttonbar">
								<div class="progressbar" id="progressbar">
									<div id="progress-bar"></div>
								</div>
								<h4 id="h4txt">可上传多个附件</h4>
								<div id="files" class="files"></div>
						
						</div>
						<div class="fileupload-loading"></div>
					</div>
				</div>
				
				<div class="modal-footer" style="position: relative;">
					<div style="float:left;width: 600px;height:60px;" id="remindBox">
						<div style="float:left;width: 600px;height:30px;text-align:right;">
							  <span class="btn btn-success fileinput-button" style="margin-left:40px;">
									<i class="icon-plus icon-white"></i> 
									<span>添加文件</span>
									<input id="fileupload" type="file" name="files[]" multiple>
							  </span>
							  <button style="margin-left:40px;" data-dismiss="modal" onClick="locations();" class="btn" id="yw2" name="yt0" type="button">关闭</button>
						  </div>
						
				   </div>
				</div>
			</div>
			<!--上传文件结束-->
			<!--重命名开始-->
			<div style="height:210px;min-width:500px !important;" id="renameFile" class="modal hide fade">
				<div class="modal-header">
					<a class="close" data-dismiss="modal">×</a>
					<h4>文件编辑</h4>
				</div>
				<div class="modal-body" style="overflow: visible !important;position: relative !important; height:60px;">
					<div class="modal-body" style="text-align:center">
						<form style="margin-bottom:0">
						<input type="hidden" name="fileid" id="fileid" value="" />
						<input type="hidden" name="filetype" id="filetype" value="" />
							<table width="96%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td width="17%" align="center" valign="middle">文件名称</td>
								<td width="83%" align="left"><input name="filename" id="filename" type="text" maxlength="64" style="width:300px;" /></td>
							  </tr>
							</table>
							<div id="message-info" style="display:none;"></div>
						 </form>
						 
					 </div>
					
				</div>
				<div class="modal-footer" style="text-align:center">
    <button onClick="publicForm.documents();" class="btn btn-danger" id="yw11" name="yt9" type="button">保存</button>&nbsp;&nbsp;&nbsp;&nbsp;<button data-dismiss="modal" class="btn" id="yw12" name="yt10" type="button">取消</button></div>
			</div>
			<!--重命名结束-->
			
			<!--移动开始-->
			<div style="height:283px;min-width:500px !important;" id="updateFile" class="modal hide fade">
				<div class="modal-header">
					<a class="close" data-dismiss="modal">×</a>
					<h4>文件移动</h4>
				</div>
				<div class="modal-body" style="overflow: visible !important;position: relative !important; height:133px;">
					<div class="modal-body" style="text-align:center">
						<form style="margin-bottom:0">
						<input type="hidden" name="fileid" id="fileid" value="" />
							<table width="96%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td width="17%" align="center" valign="middle">选择文件夹</td>
								<td width="83%" align="left">
							  <select name="typeid" id="typeid">
								  <option value="0" selected="selected">根目录</option>
								 <?php echo get_documenttype(0,0,0,$type)?>
							  </select>
						  </td>
							  </tr>
							</table>
							<div id="message-info" style="display:none;"></div>
						 </form>
					 </div>
					
				</div>
				<div class="modal-footer" style="text-align:center">
    <button onClick="publicForm.updateFile();" class="btn btn-danger" id="yw11" name="yt9" type="button">保存</button>&nbsp;&nbsp;&nbsp;&nbsp;<button data-dismiss="modal" class="btn" id="yw12" name="yt10" type="button">取消</button></div>
			</div>
			<!--移动结束-->
			
			<!--共享开始-->
			<div style="height:283px;min-width:500px !important;" id="moveFile" class="modal hide fade">
				<div class="modal-header">
					<a class="close" data-dismiss="modal" onClick="js:$('#FileFolderPublic-form .files').empty();">×</a>
					<h4>文件共享</h4>
				</div>
				<div class="modal-body" style="overflow: visible !important;position: relative !important; height:133px;">
					<div class="modal-body" style="text-align:center">
						<form style="margin-bottom:0" name="save">
						<input type="hidden" name="fileid" id="fileid" value="" />
							<table width="96%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td width="17%" align="center" valign="middle">共享人员</td>
								<td width="83%" align="left">
								<input type="hidden" name="publicuserid" id="publicuserid" value="" />
								<input type="hidden" name="publicuserphone" id="publicuserphone" value="" />
									<textarea name='publicuser' cols='80' rows='4' readonly style='background-color:#F5F5F5;color:#006600; width:360px;' id='publicuser'></textarea><br>   <script type="text/javascript"> 
   function show_publicuser(){
	   	   var uservalue = document.getElementById('publicuser').value;
	   window.open ('admin.php?ac=user_checkbox&fileurl=public&inputname=publicuser&user='+uservalue, 'newwindow', 'height=500, width=500, top=50, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');
	   	}
</script>
   <a href="javascript:;" onClick="show_publicuser();">+选择人员</a>
								
								</td>
							  </tr>
							</table>
							<div id="message-info" style="display:none;"></div>
						 </form>
					 </div>
					
				</div>
				<div class="modal-footer" style="text-align:center">
    <button onClick="publicForm.movedocument();" class="btn btn-danger" id="yw11" name="yt9" type="button">保存</button>&nbsp;&nbsp;&nbsp;&nbsp;<button data-dismiss="modal" class="btn" id="yw12" name="yt10" type="button">取消</button></div>
			</div>
			<!--共享结束-->
			<!--文件夹开始-->
			<div style="height:283px;min-width:500px !important;" id="document_type" class="modal hide fade">
				<div class="modal-header">
					<a class="close" data-dismiss="modal" onClick="js:$('#FileFolderPublic-form .files').empty();">×</a>
					<h4>文件夹管理</h4>
				</div>
				<div class="modal-body" style="overflow: visible !important;position: relative !important; height:133px;">
					<div class="modal-body" style="text-align:center">
						<form style="margin-bottom:0">
						<input type="hidden" name="did" id="did" value="" />
							<table width="96%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td width="17%" align="center" valign="middle">文件夹名称</td>
								<td width="83%" align="left"><input name="title" id="title" type="text" maxlength="64" style="width:300px;" /></td>
							  </tr>
							</table>
							<div id="message-info" style="display:none;"></div>
						 </form>
					 </div>
					
				</div>
				<div class="modal-footer" style="text-align:center">
    <button onClick="publicForm.document_type();" class="btn btn-danger" id="yw11" name="yt9" type="button">保存</button>&nbsp;&nbsp;&nbsp;&nbsp;<button data-dismiss="modal" class="btn" id="yw12" name="yt10" type="button">取消</button></div>
			</div>
			<!--文件夹结束-->
			
			<div id="folder-grid" class="grid-view">
				<div class="toolbar"  style="margin-left:10px;">
						<?php
						if(!is_superadmin() && !check_purview('office_document_Increase_'.trim($type))){
						}else{
						?>
						<a id="uploadFile" style="margin-right:5px;" class="btn btn-primary">
							<i class="icon-upload-6"></i> 上传文件
						</a>
						<?php }?>
						<a id="selectAll" style="margin-right:5px;" class="btn">
							<i class="icon-checkbox-unchecked"></i>全选
						</a>
						<a class="btn btn-opts" onClick="DeleteFile.documents('0');" style="margin-right:5px;">
							<i class="icon-download-2"></i> 批量删除
						</a>
						<div class="btn-opts btn-group" style="margin-left:5px;">
							<a data-toggle="dropdown" class="btn dropdown-toggle" id="yw15" href="#">
								更多操作<span class="caret"></span>
							</a>
							<ul id="yw16" class="dropdown-menu">
								<li>
									<a onClick="publicFile.updateFile('',2);" tabindex="-1" href="javascript:;">移动</a>
								</li>
								<li>
									<a onClick="publicFile.moveFile('',2);" tabindex="-1" href="javascript:;">共享</a>
								</li>
							</ul>
						</div>
						<div class="btn-opts btn-group" style="margin-left:5px;">
							<a action-type="document_type"   class="btn btn-primary" href="javascript:;">新建文件夹</a>
							
						</div>
						<?php if($father!=0){
						$fathers = $db->fetch_one_array("SELECT father,id FROM ".DB_TABLEPRE."document_type  WHERE id = '".$father."'");
						?>
						<div class="btn-opts btn-group" style="margin-left:5px;">
							<a  class="btn btn-danger" href="javascript:;" onClick="javascript:window.location='admin.php?ac=document&fileurl=knowledge&type=<?php echo $type;?>&father=<?php echo $fathers['father'];?>'">返回上一级</a>
							
						</div>
						<?php }?>
				</div>
				<!--<div  style="height:80%; width:100%;overflow:auto;"> -->
				<input type="hidden" name="type" id="type" value="<?php echo $type;?>" />
				<input type="hidden" name="father"  id="father" value="<?php echo $father;?>" />
				<table class="items table table-striped">
					<thead>
						<tr>
							<th style="width:10px" id="folder-grid_c0">
							<!--<input type="checkbox" value="1" name="folder-grid_c0_all" id="selectAll" /> -->
							</th>
							<th style="width:100%;" id="folder-grid_c1">文件名称</th>
							<th style="width:80px;" id="folder-grid_c3">&nbsp;</th>
							<th style="width: 90px;" id="folder-grid_c6">文件大小</th>
							<th style="width: 180px;" id="folder-grid_c7">上传时间</th>
							<th style="width: 70px;" >上传人</th>
							<th style="width: 100px;text-align:center;" id="folder-grid_c8">操作</th>
						</tr>
					</thead>
				    <tbody>
					<?php foreach ($documenttype as $row) {
					$filenum = $db->result("SELECT COUNT(*) AS num FROM ".DB_TABLEPRE."document WHERE type = '".$type."' and documentid='".$row['id']."' ORDER BY id desc");
					?>
					<tr class="odd">
						<td class="notopen"></td>
						<td class="ellipsis"><a href="javascript:;" style=" margin-top:3px;" onClick="javascript:window.location='admin.php?ac=document&fileurl=knowledge&type=<?php echo $type;?>&father=<?php echo $row['id'];?>'"><img src="template/default/content/images/folder.gif" style="margin-right:4px; height:18px; width:18px;"><?php echo $row['title'];?></a></td>
						<td class="more notopen">
						
						</td>
						<td>
						<?php 
						if($filenum>0){
							echo $filenum.'个文件';
						}else{
							echo '空';
						}
						?>
						</td>
						<td><?php echo $row['date'];?></td>
						<td></td>
						<td style="text-align:center;" class="notopen">
						<?php
						if(!is_superadmin()){
							if($_USER->id==$row['uid']){
						?>
							<a class="icon-pencil td-link-icon" action-type="document_type" data-toggle="modal" title="<?php echo $row['title'];?>" did="<?php echo $row['id'];?>" style="cursor:pointer; margin-top:3px;" rel="tooltip">重命名</a>
							<a class="download td-link-icon icon-download-2" did="<?php echo $row['id'];?>" style=" margin-top:3px;" onClick="DeleteFile.document_type(<?php echo $row['id'];?>);" href="javascript:;">删除</a>
						<?php
							}
						}else{
						?>
						<a class="icon-pencil td-link-icon" action-type="document_type" data-toggle="modal" title="<?php echo $row['title'];?>" did="<?php echo $row['id'];?>" style="cursor:pointer; margin-top:3px;" rel="tooltip">重命名</a>
							<a class="download td-link-icon icon-download-2" did="<?php echo $row['id'];?>" style=" margin-top:3px;" onClick="DeleteFile.document_type(<?php echo $row['id'];?>);" href="javascript:;">删除</a>
							<?php }?>
						</td>
						</tr>
					<?php }?>
					<?php foreach ($result as $row) {
					$filetype=preg_replace('/.*\.(.*[^\.].*)*/iU','\\1',$row['title']);
					if(file_exists('template/default/content/ico/'.$filetype.'.gif')!=''){
						$ico=$filetype;
					}else{
						$ico='ini';
					}
					?>
						<tr class="odd">
						<td class="notopen">
						<?php
						if(!is_superadmin()){
							if($_USER->id==$row['uid']){
						?>
						<input value="<?php echo $row['id'];?>" id="folder-grid" type="checkbox" name="ids[]" />
						<?php 
							}
						}else{
						?>
						<input value="<?php echo $row['id'];?>" id="folder-grid" type="checkbox" name="ids[]" />
						<?php }?>
						</td>
						<td class="ellipsis"><img src="template/default/content/ico/<?php echo $ico;?>.gif" style="margin-right:4px; height:16px; width:16px;"><?php echo str_replace('.'.$filetype,'',$row['title']);?></td>
						<td class="more notopen">
						<div class="btn-group">
							<a data-toggle="dropdown" class="btn btn-small dropdown-toggle" id="yw24" href="#">
							更多操作</a>
							<ul id="yw25" class="dropdown-menu">
							<?php 
							if(trim($filetype)=='doc' || trim($filetype)=='docx'){
								echo '<li>';
								echo '<a tabindex="-1" href="ntko/fileviews.php?fileType=word';
								echo '&fileaddr='.urlencode(str_replace('../','',$row['annex'])).'&';
								echo 'title='.urlencode(str_replace('.'.$filetype,'',$row['title'])).'" ';
								echo 'target="_blank">查看</a>';
								echo '</li>';
							}elseif(trim($filetype)=='xls' || trim($filetype)=='xlsx'){
								echo '<li>';
								echo '<a tabindex="-1" href="ntko/fileviews.php?fileType=excel';
								echo '&fileaddr='.urlencode(str_replace('../','',$row['annex'])).'&';
								echo 'title='.urlencode(str_replace('.'.$filetype,'',$row['title'])).'" ';
								echo 'target="_blank">查看</a>';
								echo '</li>';
							}elseif(trim($filetype)=='ppt'){
								echo '<li>';
								echo '<a tabindex="-1" href="ntko/fileviews.php?fileType=ppt';
								echo '&fileaddr='.urlencode(str_replace('../','',$row['annex'])).'&';
								echo 'title='.urlencode(str_replace('.'.$filetype,'',$row['title'])).'" ';
								echo 'target="_blank">查看</a>';
								echo '</li>';
							}elseif(trim($filetype)=='pdf' || trim($filetype)=='tif'){
								echo '<li>';
								echo '<a tabindex="-1" href="ntko/fileviews.php?fileType=pdf';
								echo '&fileaddr='.urlencode(str_replace('../','',$row['annex'])).'&';
								echo 'title='.urlencode(str_replace('.'.$filetype,'',$row['title'])).'" ';
								echo 'target="_blank">查看</a>';
								echo '</li>';
							}elseif($filetype=='jpg' || $filetype=='gif' || $filetype=='png' || $filetype=='bmp'){
							echo '<li>';
								echo '<a tabindex="-1" href="ntko/pic.php?';
								echo '&fileaddr='.urlencode(str_replace('../','',$row['annex'])).'&';
								echo 'title='.urlencode(str_replace('.'.$filetype,'',$row['title'])).'" ';
								echo 'target="_blank">查看</a>';
								echo '</li>';
							}else{
								echo '<li>';
								echo '<a tabindex="-1" onClick="';
								echo "javascript:window.location='downurl.php?urls=". str_replace('../','',$row['annex'])."&filename=".urlencode($row['title'])."'";
								echo '" href="javascript:;">下载</a>';
								echo '</li>';
							}
								
						  ?>
						  <?php
						if(!is_superadmin()){
							if($_USER->id==$row['uid']){
						?>
								<li>
									<a onClick="publicFile.updateFile(<?php echo $row['id'];?>,1);" tabindex="-1" href="javascript:;">移动</a>
								</li>
								<li>
									<a onClick="publicFile.moveFile(<?php echo $row['id'];?>,1);" tabindex="-1" href="javascript:;">共享</a>
								</li>
								<li>
									<a onClick="DeleteFile.documents(<?php echo $row['id'];?>);" tabindex="-1" href="javascript:;">删除</a>
								</li>
							<?php 
								}
							}else{
							?>
							<li>
									<a onClick="publicFile.updateFile(<?php echo $row['id'];?>,1);" tabindex="-1" href="javascript:;">移动</a>
								</li>
								<li>
									<a onClick="publicFile.moveFile(<?php echo $row['id'];?>,1);" tabindex="-1" href="javascript:;">共享</a>
								</li>
								<li>
									<a onClick="DeleteFile.documents(<?php echo $row['id'];?>);" tabindex="-1" href="javascript:;">删除</a>
								</li>
							<?php }?>
							</ul>
						</div>
						</td>
						<td>
						<?php
						if($row['content']>=1000000000){
							echo sprintf("%.2f", ($row['content']*0.000000001)).'GB';
						}elseif($row['content']>=1000000){
							echo sprintf("%.2f", ($row['content']*0.000001)).'MB';
						}else{
							echo sprintf("%.2f", ($row['content']*0.001)).'KB';
						}
						?></td>
						<td><?php echo $row['date'];?></td>
						<td><?php echo get_realname($row['uid'])?></td>
						<td style="text-align:center;" class="notopen">
						<?php
						if(!is_superadmin()){
							if($_USER->id==$row['uid']){
						?>
						<a class="icon-pencil td-link-icon" action-type="renameFile" data-toggle="modal" title="<?php echo str_replace('.'.$filetype,'',$row['title']);?>" id="<?php echo $row['id'];?>" filetype="<?php echo $filetype;?>" style="cursor:pointer; margin-top:3px;" rel="tooltip">重命名</a>
						<?php 
							}
						}else{
						?>
						<a class="icon-pencil td-link-icon" action-type="renameFile" data-toggle="modal" title="<?php echo str_replace('.'.$filetype,'',$row['title']);?>" id="<?php echo $row['id'];?>" filetype="<?php echo $filetype;?>" style="cursor:pointer; margin-top:3px;" rel="tooltip">重命名</a>
						<?php }?>
						<a class="download td-link-icon icon-download-2" style=" margin-top:3px;" onClick="javascript:window.location='downurl.php?urls=<?php echo str_replace('../','',$row['annex']);?>&filename=<?php echo urlencode($row['title']);?>'" href="javascript:;">下载</a>
						<!--<a class="icon-pencil td-link-icon" action-type="renameFile" data-toggle="modal" title="重命1名" style="cursor:pointer; margin-top:3px;" rel="tooltip">重命名</a>
						<a class="download td-link-icon icon-download-2" style=" margin-top:3px;" title="下载" rel="tooltip" href="">下载</a> --></td>
						</tr>
						<?php }?>
						
					</tbody>
					
				</table>
				<!--</div> -->
			</div>
		</div>
	</div>
	<script>
				var viewType = "grid";
			</script>
			<script type="text/javascript" src="template/default/content/js/public.js"></script>
			<script>
				$(window).resize(function() {
					var height_padding = parseInt($(".sidebar").css("padding-top")) + parseInt($(".sidebar").css("padding-bottom"));
					var width_padding = parseInt($(".sidebar").css("padding-left")) + parseInt($(".sidebar").css("padding-right"));
					var nav_height = $(".td-nav").height();
					var left = parseInt($(".sidebar").width()) + parseInt(width_padding);
					var height = $(window).height() - height_padding - nav_height;
					$(".sidebar .tab-content").height(height);
					$(".content .td-nav").height(height);
					$(".content").css({"margin-left": left});
					$(".content .nav-tabs").height(nav_height);
					$("#setting-tabs .tab-content").niceScroll({cursorcolor: "#ccc"});
					$(".td-nav").parent().css({"margin-left": left});
				});
				$(document).ready(function() {
					publicFile.initRight();	
				});
				
			</script>
<!--		<script src="template/default/upload/js/jquery-1.10.2.min.js"></script>
 -->		

		<script src="template/default/upload/js/vendor/jquery.ui.widget.js"></script>
		<script src="template/default/upload/js/jquery.iframe-transport.js"></script>
		<script src="template/default/upload/js/jquery.fileupload.js"></script>
		<script>
		$(function () {
			'use strict';
			// Change this to the location of your server-side upload handler:
			var url = window.location.hostname === 'blueimp.github.io' ?
						'' : 'upload/index.php?userid=<?php echo $_USER->id;?>';
			$('#fileupload').fileupload({
				url: url,
				dataType: 'json',
				done: function (e, data) {
					$.each(data.result.files, function (index, file) {
						var html='';
						html='<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border-bottom:#CCCCCC solid 1px; height:40px;">';
						html+='<tr><td width="400" height="30" align="left" valign="middle" style="padding-left:20px;">'+file.name+'</td><td width="100" align="center">'+(file.size/1000)+'KB</td>';
						if(file.type==''){
							html+='<td width="100" align="center" style="color:#990000;">上传失败,'+file.error+'</td>';
						}else{
							html+='<td width="100" align="center"  style="color:#009900;">上传成功!</td>';
						}
						html+='</tr></table>';
						if(file.type!=''){
						documentadd(file.name,file.url,file.size,file.type);
						}
						$('<p/>').html(html).appendTo('#files');
					});
				},
				progressall: function (e, data) {
					var progress = parseInt(data.loaded / data.total * 100, 0);
					$('#progressbar').css(
						'width',
						progress + '%'
					);
					$("#h4txt").hide();
					$("#progress-bar").text(progress + '%');
					
				}
			}).prop('disabled', !$.support.fileInput)
				.parent().addClass($.support.fileInput ? undefined : 'disabled');
		});
		function documentadd(title,annex,content,type){
			if(type!=''){
				jQuery.ajax({
				  type: 'GET',
				  url: 'admin.php?ac=document&fileurl=knowledge&type=<?php echo $type;?>&do=add&view=save&title='+escape(title)+'&annex='+annex+'&content='+content+'&documentid=<?php echo $father;?>&'+new Date(),
				  success: function(data){
					  if(data=='false'){
						  //$("#message-info").text("文件己经存在，写入数据失败！");
						  //$("#message-info").fadeIn("slow");
						  //setTimeout('$("#message-info").hide();',2000);
						  return (false);
					  }else if(data=='true'){
						  return (true);
					  }
				  }
			   });
		   }
		}
		function locations(){
			location.reload(true);
		}
		</script>

	</body>
</html>