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
function sendForm()
{
   document.save.submit();
}
</script>
</head>
<!--[if lt IE 7]><body class="ie6"><![endif]--><!--[if IE 7]><body class="ie7"><![endif]--><!--[if IE 8]><body class="ie8"><![endif]--><!--[if !IE]><!--><body><!--<![endif]-->
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="0" class="small">
  <tr>
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 联系人信息列表</span>
	<span style="font-size:12px; float:right; margin-right:20px;"><input type="button" value="新增信息" class="BigButtonBHover" onClick="javascript:window.location='admin.php?ac=<?php echo $ac;?>&do=add&fileurl=<?php echo $fileurl;?>&cid=<?php echo $cid;?>&type=<?php echo $type;?>'">
	</span>
    </td>
  </tr>
</table>

 <!-- 过滤表单 -->
<form method="get" action="admin.php" name="save" >
		<input type="hidden" name="ac" value="<?php echo $ac?>" />
		<input type="hidden" name="do" value="list" />
		<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
		<input type="hidden" name="cid" value="<?php echo $cid?>" />
		<input type="hidden" name="type" value="<?php echo $type?>" />
		<div class="ui-grid-21 ui-grid-right record-search">

			<div id="J-advanced-filter-option" class="">
				<div class="record-search-time fn-clear">
					<div class="ui-form-item ui-form-item-time">
					<?php echo get_keyuser($ui,$un);?>
					<label class="ui-form-label" for="keyword">联系人：</label>
							<div id="J-keyword-type-select" class="ui-form-select-shell">
								<input type="text" value="<?php echo urldecode($name)?>" name="name" class="ui-input search-keyword" id="J-keyword">
							</div>
					
						<label class="ui-form-label" for="J-start">起止日期：</label>
						<div class="ui-form-content">
							<input type="text" value="<?php echo $vstartdate?>"  class="ui-input i-date" readonly="readonly"  onClick="WdatePicker();" name='vstartdate' > - <input type="text" value="<?php echo $venddate?>"  class="ui-input i-date" readonly="readonly"  onClick="WdatePicker();" name='venddate' >
						</div>
						<div class="submit-time-container ">
							<div class="submit-time ui-button ui-button-sorange">
								<input type="submit" class="ui-button-text"id="J-submit-time" value="查 找"/>
							</div>
						</div>
						<div id="J-set-date" class="quick-link-date  blue-links  ">
						
							<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&ischeck=1&ui=<?php echo $ui?>&un=<?php echo $un?>&cid=<?php echo $cid?>&type=<?php echo $type?>" seed="CR-today" id="J-today" >今天</a>
							<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&ischeck=2&ui=<?php echo $ui?>&un=<?php echo $un?>&cid=<?php echo $cid?>&type=<?php echo $type?>" seed="CR-sevenday" id="J-seven-day">3天以内</a>
							<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&ischeck=3&ui=<?php echo $ui?>&un=<?php echo $un?>&cid=<?php echo $cid?>&type=<?php echo $type?>" seed="CR-month" id="J-a-month" >7天以内</a>
							<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&ischeck=4&ui=<?php echo $ui?>&un=<?php echo $un?>&cid=<?php echo $cid?>&type=<?php echo $type?>" seed="CR-month" id="J-a-month" >1个月内</a>
							<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&ischeck=5&ui=<?php echo $ui?>&un=<?php echo $un?>&cid=<?php echo $cid?>&type=<?php echo $type?>" seed="CR-month" id="J-a-month" >6个月内</a>
						</div>
					</div>
					<a href="javascript:;"  seed="CR-AdvancedFilter" id="J-filter-link" class="ui-btn-white-mini-more">更多选项</a>
									</div>
				
				<div class="record-search-option fn-clear">
					<div class="record-search-option-keyword  fn-hide  fn-clear">



<div class="ui-form-item fn-left"  id="J-keyword-type-outer" style="width:100%;">
						<?php
						$numsss=0;
						foreach ($companylist as $row) {
						$numsss++
						?>
						<input type="hidden" name="kinputname[]" value="<?php echo $row["inputname"]?>" />
							<label class="ui-form-label" for="keyword"><?php echo $row["formname"]?>：</label>
							<div id="J-keyword-type-select" class="ui-form-select-shell">
							<?php
							if($row["type"]=='3'){
								echo '<input type="text" value="'.$fromkeyword[$row["inputname"]].'"  class="ui-input i-date" readonly="readonly"  onClick="WdatePicker();" name="fromkeyword['.$row["inputname"].']" >';
							}elseif($row["inputtype"]=='3' || $row["inputtype"]=='5'){
								echo crm_select('fromkeyword['.$row["inputname"].']',$row["inputvaluenum"],$fromkeyword[$row["inputname"]],170,30);	
							}else{
								echo '<input type="text" value="'.$fromkeyword[$row["inputname"]].'" name="fromkeyword['.$row["inputname"].']" class="ui-input search-keyword" id="J-keyword">';
							}
							
							?>
							
								
							</div>
						<?php
						if($numsss%4==0){
							echo '</div><div class="ui-form-item fn-left" id="J-keyword-type-outer" style="width:100%;">';
						}
						}
						?>
			
	
						</div>

					</div>
					
				</div>
				
				
				
				<div id="J-submit-form" class="record-search-submit  fn-hide ">
					<div class="ui-button ui-button-sorange">
				<input type="submit" class="ui-button-text"id="J-submit-time" value="查 找"/>
				</div>
					<input type="hidden" value="1" id="J-filter" />
					<input type="hidden" name="record-type" id="J-record-type" value="0" />

				</div>
			
			</div>
		</div><!-- .record-search -->
		</form>


<form name="excel" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
		<input type="hidden" name="do" value="excel" />
		<input type="hidden" name="ischeck" value="<?php echo $ischeck?>" />
		<input type="hidden" name="vstartdate" value="<?php echo $vstartdate?>" />
		<input type="hidden" name="venddate" value="<?php echo $venddate?>" />
		<input type="hidden" name="name" value="<?php echo $name?>" />
		<input type="hidden" name="cid" value="<?php echo $cid?>" />
		<input type="hidden" name="un" value="<?php echo $un?>" />
		<input type="hidden" name="ui" value="<?php echo $ui?>" />
		<input type="hidden" name="type" value="<?php echo $type?>" />
		<?foreach ($companylist as $row) {?>
		<input type="hidden" name="kinputname[]" value="<?php echo $row["inputname"]?>" />
		<input type="hidden" name="fromkeyword[<?php echo $row["inputname"]?>]" value="<?php echo $fromkeyword[$row["inputname"]]?>" />
		<?}?>
		</form>
	<form name="update" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
	<input type="hidden" name="do" value="update" />
	<input type="hidden" name="type" value="<?php echo $type?>" />
	<input type="hidden" name="cid" value="<?php echo $cid?>" />
<table class="TableBlock" border="0" width="100%" align="center">
 
   
	<tr>
      <td width="30" align="center" nowrap class="TableHeader">选项</td>
      <td align="left" class="TableHeader">联系人</td>
	  <?php form_list('crm_contact');?>
      <td width="90" align="center" class="TableHeader">发布人</td>
      <td width="100" align="center" class="TableHeader">发布时间</td>
      <td width="90" align="center" class="TableHeader">操作</td>
    </tr>
<?php foreach ($result as $row) {?>
	<tr>
      <td nowrap class="TableContent">
	<?php
	get_boxlistkey("id[]",$row['id'],$row['uid'],$_USER->id);
	?></td>
      <td class="TableData" ><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=view&id=<?php echo $row['id']?>&type=<?php echo $row['type']?>&cid=<?php echo $row['cid']?>"><?php echo $row['name']?></a></td>
      
	  <?php form_list_view('crm_contact',$row['id']);?>
      <td align="center" class="TableData">
	  <?php echo get_realname($row['uid'])?></td>
      <td align="center" class="TableData">
	  <?php echo str_replace(' ','<br>',$row['date'])?></td>
      <td align="center" class="TableData"><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=view&id=<?php echo $row['id']?>&type=<?php echo $row['type']?>&cid=<?php echo $row['cid']?>">查看</a> | <a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=edit&id=<?php echo $row['id']?>">编辑</a></td>
    </tr>
	
<?php }?>	

	
    <tr align="center" class="TableControl">
      <td height="35" colspan="<?php echo 8+$fromnum;?>" align="left" nowrap>
        <input type="checkbox" class="checkbox" value="1" name="chkall" onClick="check_all(this)" />全选&nbsp;&nbsp;
						  <a class="js-add-contact"><span></span></a>
						  <a href="javascript:document:update.submit();">清理数据</a>
						  <a href="javascript:document:excel.submit();" seed="CR-download-top" id="J-download"><img class="v-al-middle" src="template/default/images/2EC5tZlqdV.gif" />下载查询结果</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo showpage($num,$pagesize,$page,$url)?>
</td>
    </tr>
  </table>
</form>


                            

</body>
</html>
 

