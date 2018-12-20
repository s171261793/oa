<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>信息操作页面</title>
<link type="text/css" media="screen" charset="utf-8" rel="stylesheet" href="template/default/content/css/style.account-1.1.css" />
<link charset="utf-8" rel="stylesheet" href="template/default/content/css/personal.record-1.0.css" media="all" />
<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">

<style type="text/css"> 
.tip-faq{
	clear:both;
	margin-top:0px;
}
#J-table-consume{
	margin-bottom:40px;
}
.ui-form-tips .m-cue{
	 background-position: -27px -506px;
	 *background-position: -27px -505px;
}
#J-set-date a{
	font-family:宋体;
}
</style>
<script type="text/javascript" charset="utf-8" src="template/default/content/js/arale.js"></script>
<script charset="utf-8" src="template/default/content/js/recordIndex.js?t=20110523"></script>
<script language="javascript" type="text/javascript" src="template/default/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="template/default/content/js/common.js"></script>
<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>
<script type="text/javascript"> 
E.onDOMReady(function() {

	record = new AP.widget.Record({
		dom: {
			queryForm : "queryForm",
			searchForm : "topSearchForm",
			keyword : "J-keyword",
			keywordType : "J-keyword-type"
		}
	});

	//切换高级筛选状态
	E.on('J-filter-link', 'click', record.switchFilter);
});

</script>
</head>
<!--[if lt IE 7]><body class="ie6"><![endif]--><!--[if IE 7]><body class="ie7"><![endif]--><!--[if IE 8]><body class="ie8"><![endif]--><!--[if !IE]><!--><body><!--<![endif]-->
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 产品列表</span>
	<span style="font-size:12px; float:right; margin-right:20px;"><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>"><<返回上一级
	</a></span>    </td>
  </tr>
</table>

 <!-- 过滤表单 -->
<form method="get" action="admin.php" name="save" >
		<input type="hidden" name="ac" value="<?php echo $ac?>" />
		<input type="hidden" name="do" value="add" />
		<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
		<div class="ui-grid-21 ui-grid-right record-search">

			<div id="J-advanced-filter-option" class="">
				<div class="record-search-time fn-clear">
					<div class="ui-form-item ui-form-item-time">
					
					<label class="ui-form-label" for="keyword">产品编号：</label>
							<div id="J-keyword-type-select" class="ui-form-select-shell">
								<input type="text" value="<?php echo urldecode($number)?>" name="number" class="ui-input search-keyword" id="J-keyword">
							</div>
					
						<label class="ui-form-label" for="J-start">产品名称：</label>
						<div class="ui-form-content">
							<input type="text" value="<?php echo urldecode($title)?>" name="title" class="ui-input search-keyword" id="J-keyword">
						</div>
						<label class="ui-form-label" for="J-start">产品类别：</label>
						<div class="ui-form-content">
							<select class="SelectStyle" style="height:25px;" name="type">
										<option value="" >请选择分类</option>
										<?php echo prod_type(0,$type,0,0);?>
										</select>
						</div>
						<div class="submit-time-container ">
							<div class="submit-time ui-button ui-button-sorange">
								<input type="submit" class="ui-button-text"id="J-submit-time" value="查 找"/>
							</div>
						</div>
					
					</div>
				
									</div>
				

			
			</div>
		</div><!-- .record-search -->
		</form>

	<form method="get" action="admin.php" name="update" >
		<input type="hidden" name="ac" value="<?php echo $ac?>" />
		<input type="hidden" name="do" value="add" />
		<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
		<input type="hidden" name="prod" value="2" />
<table class="TableBlock" border="0" width="100%" align="center">
 
   
	<tr>
      <td width="30" align="center" nowrap class="TableHeader">选项</td>
      <td width="130" align="center" class="TableHeader">产品编号</td>
      <td align="left" class="TableHeader">产品名称</td>
      <td width="120" align="center" class="TableHeader">产品分类</td>
      <td width="80" align="center" class="TableHeader">产品价格</td>
      <td width="80" align="center" class="TableHeader">发布人</td>
      <td width="90" align="center" class="TableHeader">发布时间</td>
      <td width="90" align="center" class="TableHeader">操作</td>
    </tr>
<?php foreach ($result as $row) {?>
	<tr>
      <td nowrap class="TableContent">
	<input type="checkbox" name="id[]" value="<?php echo $row['id']?>" class="checkbox" /></td>
      <td class="TableData" ><?php echo $row['number']?></td>
      <td align="left" class="TableData"><a href="admin.php?ac=prod&fileurl=<?php echo $fileurl;?>&do=view&id=<?php echo $row['id']?>" target="_blank"><?php echo $row['title']?></a></td>
      <td align="center" class="TableData"><?php echo public_value('title','crm_pord_type','id='.$row['type'])?></td>
      <td align="center" class="TableData"><?php echo $row['price']?></td>
      
      <td align="center" class="TableData">
	  <?php echo get_realname($row['uid'])?></td>
      <td align="center" class="TableData">
	  <?php echo str_replace(' ','<br>',$row['date'])?></td>
      <td align="center" class="TableData"><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=add&pid=<?php echo $row['id']?>&prod=1">生成产品单</a></td>
    </tr>
	
<?php }?>	

	
    <tr align="center" class="TableControl">
      <td height="35" colspan="8" align="left" nowrap>
        <input type="checkbox" class="checkbox" value="1" name="chkall" onClick="check_all(this)" />全选&nbsp;&nbsp;
						 
						  <a href="javascript:document:update.submit();"><img class="v-al-middle" src="template/default/images/newfolder.gif" />&nbsp;批量生成产品单</a>
						  
</td>
    </tr>
  </table>
</form>


                            

</body>
</html>
 

