
<html>
<head>
	<title>周报日志列表页面</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="template/default/content/css/style.css">
	<link rel="stylesheet" type="text/css" href="template/default/content/css/style2014.css">
	<script language="javascript" type="text/javascript" src="DatePicker/WdatePicker.js"></script>

	<style type="text/css">
		.addData{
			display: inline-block;
			width:80px;
			height:34px;
			background:#98BBD6;
			border-radius: 12px;
			text-align: center;
			line-height: 34px;
		}
		.color-text:{
			color:red;
		}
		.greenText{
			color:green;
		}
		.showTag tr:hover{
					background-color:yellow;
		}

	</style>

<link type="text/css" media="screen" charset="utf-8" rel="stylesheet" href="template/default/content/css/style.account-1.1.css" />
<link charset="utf-8" rel="stylesheet" href="template/default/content/css/personal.record-1.0.css" media="all" />

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
.BigButtonBHovers{width:84px;height:30px;height:27px !important;padding-bottom:3px;color:#000000;background:url("template/default/content/images/big_btn_b.png") no-repeat;border:0px;cursor:pointer;font-size:12pt;background-position:0 -30px;}

</style>
<script type="text/javascript" charset="utf-8" src="template/default/content/js/arale.js"></script>
<script charset="utf-8" src="template/default/content/js/recordIndex.js?t=20110523"></script>
<script language="javascript" type="text/javascript" src="template/default/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="template/default/content/js/common.js"></script>
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

<div id="container" class="ui-container">

<body class="bodycolor">







<div id="content" class="ui-content fn-clear" coor="default" coor-rate="0.02">
	<div class="ui-grid-21" coor="content">
		<div class="ui-grid-21 ui-grid-right record-tit" coor="title">
			<h2 class="ui-tit-page">周报日志列表</h2>
			
			<div class="record-tit-amount">
				<p>总共有<span class="number"><?php echo public_number('user')?></span>条数据
              </p>
			</div>
		</div>

		
		<!-- 过滤表单 -->
		<form method="get" action="" name="topSearchForm" class="ui-grid-21 ui-grid-right ui-form">
		<input type="hidden" name="ischeck" value="<?php echo $ischeck?>" />
		<input type="hidden" name="ac" value="<?php echo $ac?>" />
		<input type="hidden" name="do" value="list" />
		<input type="hidden" name="fileurl" value="<?php echo $fileurl?>" />
		<div class="ui-grid-21 ui-grid-right record-search">
		
			<div id="J-advanced-filter-option" class="">
				<div class="record-search-time fn-clear">
					<div class="ui-form-item ui-form-item-time">
						<label class="ui-form-label" for="J-start">用户名：</label>
						<div class="ui-form-content">
							<input type="text" value="<?php echo urldecode($username)?>" name="username" class="ui-input i-date" id="J-start">
						</div>
						
						<label class="ui-form-label" for="J-start">姓名：</label>
						<div class="ui-form-content">
							<input type="text" value="<?php echo urldecode($name)?>" name="name" class="ui-input i-date" id="J-start">
						</div>
						
						<label class="ui-form-label" for="J-start">部门：</label>
						<div class="ui-form-content">
							<select name="department" class="BigStatic">
						  <option value="" selected="selected"></option>
						 <?php echo get_realdepalist(0,$department,0)?>
						  </select>
						</div>
						
						<label class="ui-form-label" for="J-start">开始时间：</label>
						<div class="ui-form-content">
							<input type="text" name="starttime" class="BigInput" style="width:168px;" size="20" value="<?php echo $starttime;?>" onClick="WdatePicker();" />
						</div>
	
						<label class="ui-form-label" for="J-start">结束时间：</label>
						<div class="ui-form-content">
							<input type="text" name="endtime" class="BigInput" style="width:168px;" size="20" value="<?php echo $endtime;?>" onClick="WdatePicker();" />
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


		<!-- 导出当前页面的信息 START-->
		<form name="excel" method="post" action="admin.php?ac=<?php echo $ac?>&fileurl=<?php echo $fileurl?>&do=excel">
			<input type="hidden" name="username" value="<?php echo urldecode($username)?>" />
			<input type="hidden" name="name" value="<?php echo urldecode($name)?>" />
	        <input type="hidden" name="department" value="<?php echo $_GET['department'];?>" />
	        <input type="hidden" name="starttime" value="<?php echo $_GET['starttime'];?>" />
			<input type="hidden" name="endtime" value="<?php echo $_GET['endtime'];?>" />
			<input type="hidden" name="do" value="excel" />
		</form>
		<!-- 导出当前页面的信息 END-->

	</div>
</div>
</div>

<br/>
	<table class="TableBlock" border="0" width="95%" align="center">
		<tr class="TableControl">
			<th  style="text-align:center;" >序号</th>
			<th  style="text-align:center;" >周报名称</th>
			<th  style="text-align:center;" >姓名</th>
			<th  style="text-align:center;" >部门</th>
			<th  style="text-align:center;" >岗位</th>
			<th  style="text-align:center;" >岗位编码</th>

			<th  style="text-align:center;" >一级审核人</th>
			<th  style="text-align:center;" >审核时间</th>
			<th  style="text-align:center;" >二级审核人</th>
			<th  style="text-align:center;" >审核时间</th>

			<th  style="text-align:center;" >上传时间</th>
			<th  style="text-align:center;" >所花时间(分钟)</th>
			<th  style="text-align:center;" >修改次数</th>
			<th  style="text-align:center;" >本周绩效得分</th>
			<!-- <?php if( $show_status =='super_administration'):?>
			<th  style="text-align:center;" >更新绩效</th>
			<?php endif;?> -->
			
		</tr>
	
	<?php 

			if(count($data) > 0)
			{
				
				
				//有数据循环
				foreach($data as $key=>$value)
				{
					$datasHtml = '<tr class="TableControl"><td align="center">'.($key+1).'</td>
								<td><a style="color: green;" target="_bank" href="/admin.php?ac=weekly_log&fileurl=report&cl=12&do=view&orderid='.$value['id'].'">第'.$value['weekly_number'].'周总结汇报表与第'.($value['weekly_number_plan']).'周计划汇报表</a></td>';
					$datasHtml .= '<td>'.get_realname($value['user_id']).'</td>';
					$datasHtml .= '<td>'.get_realdepaname($value['department_id']).'</td>';
					$datasHtml .= '<td>'.get_postcode($value['user_id'])['name'].'</td>';
					$datasHtml .= '<td>'.get_postcode($value['user_id'])['code'].'</td>';



					$datasHtml .= '<td>'.get_realname(get_realname_access($value['id'])[0]['user_id']).'</td>';
					$datasHtml .= '<td>'.get_realname_access($value['id'])[0]['update_time'].'</td>';

					$datasHtml .= '<td>'.get_realname(get_realname_access($value['id'])[1]['user_id']).'</td>';
					$datasHtml .= '<td>'.get_realname_access($value['id'])[1]['update_time'].'</td>';
					


					$datasHtml .= '<td>'.$value['create_time_sub'].'</td>';
					$datasHtml .= '<td>'.count_minute($value['create_time_early'],$value['create_time_sub']).'</td>';
					$datasHtml .= '<td>'.$value['edit_number'].'</td>';
					$datasHtml .= '<td>'.$value['score'].'</td>';

					// if($show_status =='super_administration')
					// $datasHtml .= '<td><a style="color: green" href="/admin.php?ac=weekly_log&fileurl=report&do=count&orderid='.$value['id'].'">更新绩效分数</a></td></tr>';
					
					echo $datasHtml;
				}

			}
			else
			{
				echo '<tr class="TableControl">
						<td colspan="18">暂时没有信息</td>
					</tr>';
			}





	?>
		
		
	</table>

	

	<div class="data-wrap">
		<div class="data-operation">
				<div class="button-operation">
					<button type="button" action="new_work" class="btn btn-success" onClick="javascript:document:excel.submit();">导出数据</button>
					<!-- <button type="button" action="new_work" class="btn btn-success" onClick="javascript:window.location='admin.php?ac=add&fileurl=communication&type=<?php echo $_GET[type]?>'">新增通迅录</button> -->
			<!-- <button type="button" onClick="updateform(2);" action="cancel_concern" class="btn btn-info">发送短信</button> -->
			<!-- <button type="button" onClick="updateform(1);" action="cancel_concern" class="btn btn-danger">清理数据</button>		 -->
					</div>

			<div class="pager_operation">
				<?php echo newshowpage($num,$pagesize,$page,$url);?>
				
				
			</div>
		</div>		
	</div>





</body>
</html>