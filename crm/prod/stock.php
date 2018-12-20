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
    <td class="Big"><img src="template/default/content/images/notify_new.gif" align="absmiddle"><span class="big3"> 库存信息列表</span>
	
    </td>
  </tr>
</table>

 <!-- 过滤表单 -->
<form method="get" action="admin.php" name="save" >
		<input type="hidden" name="ac" value="<?php echo $ac?>" />
		<input type="hidden" name="do" value="list" />
		<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
		<div class="ui-grid-21 ui-grid-right record-search">

			<div id="J-advanced-filter-option" class="">
				<div class="record-search-time fn-clear">
					<div class="ui-form-item ui-form-item-time">
					
					<label class="ui-form-label" for="keyword">产品编号：</label>
							<div id="J-keyword-type-select" class="ui-form-select-shell">
								<input type="text" value="<?php echo urldecode($number)?>" name="number" class="ui-input search-keyword" id="J-keyword">
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
						
							<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&ischeck=1&userkeytype=<?php echo $userkeytype?>" seed="CR-today" id="J-today" >今天</a>
							<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&ischeck=2&userkeytype=<?php echo $userkeytype?>" seed="CR-sevenday" id="J-seven-day">3天以内</a>
							<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&ischeck=3&userkeytype=<?php echo $userkeytype?>" seed="CR-month" id="J-a-month" >7天以内</a>
							<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&ischeck=4&userkeytype=<?php echo $userkeytype?>" seed="CR-month" id="J-a-month" >1个月内</a>
							<a href="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&ischeck=5&userkeytype=<?php echo $userkeytype?>" seed="CR-month" id="J-a-month" >6个月内</a>
						</div>
					</div>
					<a href="javascript:;"  seed="CR-AdvancedFilter" id="J-filter-link" class="ui-btn-white-mini-more">更多选项</a>
									</div>
				
				<div class="record-search-option fn-clear">
					<div class="record-search-option-keyword  fn-hide  fn-clear">
						<div class="ui-form-item fn-left"  id="J-keyword-type-outer" style="width:100%;">



<label class="ui-form-label" for="keyword">产品名称：</label>
							<div id="J-keyword-type-select" class="ui-form-select-shell">
								<input type="text" value="<?php echo urldecode($title)?>" name="title" class="ui-input search-keyword" id="J-keyword">
							</div>
<label class="ui-form-label" for="keyword">产品价格：</label>
							<div id="J-keyword-type-select" class="ui-form-select-shell">
								<input type="text" value="<?php echo urldecode($price)?>" name="price" class="ui-input search-keyword" id="J-keyword">
							</div>
<label class="ui-form-label" for="keyword">产品分类：</label>
							<div id="J-keyword-type-select" class="ui-form-select-shell">
								<select class="SelectStyle" style="height:25px;" name="type">
										<option value="" >请选择分类</option>
										<?php echo prod_type(0,$type,0,0);?>
										</select>
							</div>
</div>


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
		<input type="hidden" name="number" value="<?php echo $number?>" />
		<input type="hidden" name="title" value="<?php echo $title?>" />
		<input type="hidden" name="price" value="<?php echo $price?>" />
		<input type="hidden" name="type" value="<?php echo $type?>" />
		<?foreach ($companylist as $row) {?>
		<input type="hidden" name="kinputname[]" value="<?php echo $row["inputname"]?>" />
		<input type="hidden" name="fromkeyword[<?php echo $row["inputname"]?>]" value="<?php echo $fromkeyword[$row["inputname"]]?>" />
		<?}?>
		</form>
	<form name="update" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>">
		<input type="hidden" name="do" value="update" />
<table class="TableBlock" border="0" width="100%" align="center">
 
   
	<tr>
      <td width="30" align="center" nowrap class="TableHeader">选项</td>
      <td width="130" align="center" class="TableHeader">产品编号</td>
      <td align="left" class="TableHeader">产品名称</td>
      <td width="120" align="center" class="TableHeader">产品分类</td>
      <td width="80" align="center" class="TableHeader">产品价格</td>
      <td width="80" align="center" class="TableHeader">剩余库存</td>
      <td width="90" align="center" class="TableHeader">出库数量</td>
	  <td width="90" align="center" class="TableHeader">入库数量</td>
      <td width="160" align="center" class="TableHeader">操作</td>
    </tr>
<?php
foreach ($result as $row) {
$type1 = $db->fetch_one_array("SELECT sum(stocknum) as stocknum FROM ".DB_TABLEPRE."crm_stock WHERE pid='".$row["id"]."' and (type=1 or type=2) ");
$type2 = $db->fetch_one_array("SELECT sum(stocknum) as stocknum FROM ".DB_TABLEPRE."crm_stock WHERE pid='".$row["id"]."' and type=3");
$number=$type1['stocknum']-$type2['stocknum'];
?>
	<tr>
      <td nowrap class="TableContent">
	<input type="checkbox" name="id[]" value="<?php echo $row['id']?>" disabled="disabled" /></td>
      <td class="TableData" ><?php echo $row['number']?></td>
      <td align="left" class="TableData"><a href="admin.php?ac=prod&fileurl=<?php echo $fileurl;?>&do=view&id=<?php echo $row['id']?>"><?php echo $row['title']?></a></td>
      <td align="center" class="TableData">
	  <?php
	  if($row['type']!=''){
		  echo public_value('title','crm_pord_type','id='.$row['type']);
	  }
	  ?></td>
      <td align="center" class="TableData"><?php echo $row['price']?></td>
      
      <td align="center" class="TableData">
	  <span style="font-size:18px; color:#FF0000; font-weight:900;"><?php echo $number;?></span></td>
      <td align="center" class="TableData">
	  <span style="font-size:18px; color:#000000;text-decoration:line-through;font-weight:900;"><?php echo $type2['stocknum'];?></span></td>
	  <td align="center" class="TableData">
	  <span style="font-size:18px; color:#006600; font-weight:900;"><?php echo $type1['stocknum'];?></span></td>
      <td align="center" class="TableData"><a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=stock&id=<?php echo $row['id']?>&type=1">入库管理</a> | <a href="admin.php?ac=<?php echo $ac;?>&fileurl=<?php echo $fileurl;?>&do=stock&id=<?php echo $row['id']?>&type=3">出库管理</a></td>
    </tr>
	
<?php }?>	

	
    <tr align="center" class="TableControl">
      <td height="35" colspan="<?php echo 8+$fromnum;?>" align="left" nowrap>
        &nbsp;&nbsp;
						  
						  <a href="javascript:document:excel.submit();" seed="CR-download-top" id="J-download"><img class="v-al-middle" src="template/default/images/2EC5tZlqdV.gif" />下载查询结果</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo showpage($num,$pagesize,$page,$url)?>
</td>
    </tr>
  </table>
</form>


                            

</body>
</html>
 

